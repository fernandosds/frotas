<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\User;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\UserService;
use App\Services\FleetsLarge\GrupoCercaRelacionamentoService;

use App\Models\GrupoGaragemRelacionamento;
use App\Models\GrupoGaragem;

use App\Models\GrupoAlertaRelacionamento;
use App\Models\GrupoAlerta;

use App\Models\GrupoAlertaGaragem;

use App\Models\BancoSantander;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GaragemController extends Controller
{

    private $logService;

    /**
     * FleetController constructor.
     * @var LogService
     */
    public function __construct(GrupoCercaService $grupocercaService, GrupoCercaRelacionamentoService $grupocercaRelacionamentoService, LogService $logService, UserService $userService)
    {
        $this->grupocercaService = $grupocercaService;
        $this->grupocercaRelacionamentoService = $grupocercaRelacionamentoService;
        $this->logService = $logService;
        $this->userService = $userService;

        $this->data = [
            'icon' => 'fa fa-car-side',
            'title' => 'Grupo de Monitoramento Veicular',
            'menu_open_monitoramento' => 'kt-menu__item--open'
        ];
    }

    public function index()
    {
        $data = $this->data;
        $data['grupos']         = GrupoGaragem::with('grupoGaragemRelacionamento')->get();
        $data['gruposAlerta']   = GrupoAlerta::with('grupoAlertaRelacionamento')->get();


        return view('fleetslarge.garagem.list', $data);
    }

    public function new(Request $request)
    {
        
        $data = $this->data;
        if (!isset($request->id)) {
            $data['cars'] = $this->grupocercaService->getPlate();
            $data['gruposAlerta']   = GrupoAlerta::with('grupoAlertaRelacionamento')->get();
            return view('fleetslarge.garagem.new', $data);
        } else {
            $removePlate    = [];
            $removeAlertas  = [];
            $gruposGaragem  = GrupoGaragem::with('grupoGaragemRelacionamento')->where('id', $request->id)->first();
            
            $placas = $this->grupocercaService->getPlaceGroupAll($gruposGaragem->grupoGaragemRelacionamento);
            $data['grupo']  = $gruposGaragem;

            $grupoAlertaGaragem = GrupoAlertaGaragem::with('grupoAlerta')->where('id_grupo_garagem', $request->id)->get();
            $data['alertas'] = $grupoAlertaGaragem;

            foreach($grupoAlertaGaragem as $alertaGaragem){
                $removeAlertas[] = $alertaGaragem->grupoAlerta[0]->nome;
            }

            foreach ($gruposGaragem->grupoGaragemRelacionamento as $grupoGaragemRelacionamento) {
                $plate = $this->grupocercaService->findByChassi($grupoGaragemRelacionamento->chassis);
                $removePlate[] = $plate->placa;
            }
            $data['cars'] = $this->grupocercaService->removePlates($removePlate);
            $data['placas'] = $placas;
            $data['gruposAlerta']   = GrupoAlerta::with('grupoAlertaRelacionamento')->whereNotIn('nome', $removeAlertas)->get();
            return view('fleetslarge.garagem.new', $data);
        }
    }

    public function save(Request $request)
    {

        if (empty($request->name)) {
            return response()->json(['status' => 'error', 'errors' => 'Não é permitido criar um Grupo com o campo nome vazio'], 400);
        }

        $placas = $request->placas;

        if (count($placas) > 30) {
            return response()->json(['status' => 'error', 'errors' => 'Não é permitido adicionar mais de 50 placas no grupo'], 400);
        }

        //SE ID GRUPO FOR NULL ENTÃO É CADASTRO
        if (is_null($request->id_grupo)) {
            $grupoGaragem = new GrupoGaragem();
            $grupoGaragem->created_at = Carbon::now();
        } else {
            $this->logService->saveLog(strval(Auth::user()->name), 'Mapa Monitoramento: Monitorou o grupo: ' . $request->id_grupo);
            saveLog([
                'value'     => strval(Auth::user()->name),
                'type'      => "Grupo: Monitorou_o_grupo {$request->name}",
                'local'     => 'GaragemController',
                'funcao'    => 'save'
            ]);
            $grupoGaragem = GrupoGaragem::find($request->id_grupo);
            $grupoGaragem->updated_at = Carbon::now();
        }

        $grupoGaragem->nome       = $request->name;
        $grupoGaragem->user_id    = Auth::user()->id;

        
        if ($grupoGaragem->save()) {
            $arrGrupoCercaRelacionamento = [];
            $arrMontagem = [];
            if (!$placas) {
                saveLog([
                    'value'     => strval(Auth::user()->name),
                    'type'      => "Grupo: Tentou criar um grupo com mais de 50 veículos.",
                    'local'     => 'GaragemController',
                    'funcao'    => 'save'
                ]);
                $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Tentou criar um grupo com mais de 50 veículos.');
                return response()->json(['status' => 'error', 'errors' => 'Necessário adicionar uma placa para gravar o grupo.'], 400);
            }
            foreach ($placas as $placa) {
                $car = BancoSantander::where('placa', $placa)->first();
                $arrMontagem[] = [
                    'grupo_id'      => $grupoGaragem->id,
                    'chassis'       => $car->chassis,
                    'dispositivo'   => $car->modelo,
                    'created_at'    => Carbon::now()
                ];
                $arrGrupoCercaRelacionamento[] = $arrMontagem;
            }

            if (is_null($request->id_grupo)) {

                $grupoRelacionamento    =  new GrupoGaragemRelacionamento();
                $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Criou o grupo: ' . $request->name);
                saveLog([
                    'value'     => strval(Auth::user()->name),
                    'type'      => "Grupo: Criou_o_grupo: " . $request->name,
                    'local'     => 'GrupoCercaController',
                    'funcao'    => 'save'
                ]);

                if(!is_null($request->alertas) || !empty($request->alertas)){

                    foreach($request->alertas as $alerta){
                        $grupoAlerta = GrupoAlerta::where('nome', $alerta)->first();
                        $grupoAlertaGaragem = new GrupoAlertaGaragem();
                        $grupoAlertaGaragem->id_grupo_garagem = $grupoGaragem->id;
                        $grupoAlertaGaragem->id_grupo_alerta = $grupoAlerta->id;

                        $grupoAlertaGaragem->save();
                    }
                    

                }

                return $grupoRelacionamento->insert($arrMontagem)
                    ? response()->json(['status' => 'success'], 200)
                    : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
            } else {
                // dd(array('insert' => $arrMontagem, 'id_este_grupo' => $grupoGaragem->id));
                
                $validation = GrupoGaragemRelacionamento::where('grupo_id', $grupoGaragem->id)->delete() ? true : false;
                $validationGAG = GrupoAlertaGaragem::where('id_grupo_garagem', $grupoGaragem->id)->delete() ? true : false;
                if ($validation) {

                    $grupoRelacionamento    =  new GrupoGaragemRelacionamento();

                    saveLog([
                        'value'     => strval(Auth::user()->name),
                        'type'      => "Grupo: Editou_o_grupo: " . $grupoGaragem->id,
                        'local'     => 'GaragemController',
                        'funcao'    => 'save'
                    ]);
                    $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Editou o grupo: ' . $grupoGaragem->id);

                    $validationGR = $grupoRelacionamento->insert($arrMontagem) ? true : false; 

                    if(!is_null($request->alertas) || !empty($request->alertas)){

                        foreach($request->alertas as $alerta){
                            $grupoAlerta = GrupoAlerta::where('nome', $alerta)->first();
                            $grupoAlertaGaragem = new GrupoAlertaGaragem();
                            $grupoAlertaGaragem->id_grupo_garagem = $grupoGaragem->id;
                            $grupoAlertaGaragem->id_grupo_alerta = $grupoAlerta->id;
    
                            $validationAG = $grupoAlertaGaragem->save() ? true : false;
                        }

                    }

                    if(isset($validationAG)){
                        return $validationGR && $validationAG
                            ? response()->json(['status' => 'success'], 200)
                            : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
                    }else{
                        return $validationGR
                            ? response()->json(['status' => 'success'], 200)
                            : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
                    }

                }else{
                    return response()->json(['status' => 'internal_error', 'errors' => 'NÃO FOI POSSIVEL EXCLUIR OS DADOS DA GARAGEM'], 400);
                }
            }
        }
    }

    public function destroy(Int $id)
    {
        $data = $this->data;
        saveLog([
            'value'     => strval(Auth::user()->name),
            'type'      => "Grupo: Deletou_o_grupo: " . $id,
            'local'     => 'GaragemController',
            'funcao'    => 'destroy'
        ]);
        $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Deletou o grupo: ' . $id);
        return $this->grupocercaService->destroy($id);
    }
}
