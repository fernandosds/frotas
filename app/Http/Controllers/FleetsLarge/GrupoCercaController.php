<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\User;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\UserService;
use App\Services\FleetsLarge\GrupoCercaRelacionamentoService;
use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Models\GrupoUsuarioRelacionamento;
use App\Models\BancoSantander;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GrupoCercaController extends Controller
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
    }

    public function index()
    {
        $data['grupos'] = GrupoCerca::with('grupoCercaRelacionamento')->with('grupoUsuarioRelacionamento')->get();
        return view('fleetslarge.cercas.list', $data);
    }

    public function new(Request $request)
    {

        $data['users'] = $this->userService->paginate();
        $data['cars'] = $this->grupocercaService->getPlate();
        if (!isset($request->id)) {
            return view('fleetslarge.cercas.new', $data);
        } else {

            $gruposCerca = GrupoCerca::with('grupoCercaRelacionamento')->where('id', $request->id)->first();
            $placas = $this->grupocercaService->getPlaceGroupAll($gruposCerca->grupoCercaRelacionamento);
            $data['grupo']  = $gruposCerca;
            $gruposUsuarios = GrupoCerca::with('grupoUsuarioRelacionamento')->where('id', $request->id)->first();
            $data['usuarios']  = $gruposUsuarios;
            $data['placas'] = $placas;
            return view('fleetslarge.cercas.new', $data);
        }
    }

    public function save(Request $request)
    {

        
        if (empty($request->name)) {
            return response()->json(['status' => 'error', 'errors' => 'Não é permitido criar um Grupo de Cerca com o campo nome vazio'], 400);
        }

        $placas = $request->placas;
        $usuarios = $request->usuarios;

        if (count($placas) > 50) {
            return response()->json(['status' => 'error', 'errors' => 'Não é permitido adicionar mais de 50 placas no grupo'], 400);
        }

        //SE ID GRUPO FOR NULL ENTÃO É CADASTRO
        if (is_null($request->id_grupo)) {
            $grupoCerca = new GrupoCerca();
            $grupoCerca->created_at = Carbon::now();
        } else {
            $this->logService->saveLog(strval(Auth::user()->name), 'Cerca: Monitorou a cerca ' . $request->id_grupo);
            $grupoCerca = GrupoCerca::find($request->id_grupo);
            $grupoCerca->updated_at = Carbon::now();
        }

        $grupoCerca->nome       = $request->name;
        $grupoCerca->user_id    = Auth::user()->id;
        if ($grupoCerca->save()) {
            $arrGrupoCercaRelacionamento = [];
            $arrMontagem = [];
            if (!$placas) {
                $this->logService->saveLog(strval(Auth::user()->name), 'Cerca: Tentou criar uma cerca com mais de 50 veículos');
                return response()->json(['status' => 'error', 'errors' => 'Necessário adicionar uma placa para gravar o grupo de cerca'], 400);
            }
            foreach ($placas as $placa) {
                $car = BancoSantander::where('placa', $placa)->first();
                $arrMontagem[] = [
                    'grupo_id'      => $grupoCerca->id,
                    'chassis'       => $car->chassis,
                    'dispositivo'   => $car->modelo,
                    'created_at'    => Carbon::now()
                ];
                $arrGrupoCercaRelacionamento[] = $arrMontagem;
            }

            foreach($usuarios as $usuario){
                $user = User::where('name', $usuario)->first();
                $arrMontagemUser[] = [
                    'id_grupo'      => $grupoCerca->id,
                    'id_usuario'    => $user->id,
                    'nome_usuario'  => $usuario,
                    'created_at'    => Carbon::now()
                ];
            }

            if (is_null($request->id_grupo)) {
                $grupoRelacionamento    =  new GrupoCercaRelacionamento();
                $grupoUsuario           =  new GrupoUsuarioRelacionamento();
                $this->logService->saveLog(strval(Auth::user()->name), 'Cerca: Criou a cerca: ' . $request->name);

                return $grupoRelacionamento->insert($arrMontagem) && $grupoUsuario->insert($arrMontagemUser)
                    ? response()->json(['status' => 'success'], 200)
                    : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);

            } else {
                $validation = GrupoCercaRelacionamento::where('grupo_id', $grupoCerca->id)->delete() && GrupoUsuarioRelacionamento::where('id_grupo', $grupoCerca->id)->delete() ? true : false;
                if ($validation) {
                    $grupoRelacionamento    =  new GrupoCercaRelacionamento();
                    $grupoUsuario           =  new GrupoUsuarioRelacionamento();
                    $this->logService->saveLog(strval(Auth::user()->name), 'Cerca: Editou a cerca: ' . $grupoCerca->id);
                    
                    return $grupoRelacionamento->insert($arrMontagem) && $grupoUsuario->insert($arrMontagemUser)
                        ? response()->json(['status' => 'success'], 200)
                        : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
                }
            }
        }
    }

    public function destroy(Int $id)
    {
        $this->logService->saveLog(strval(Auth::user()->name), 'Cerca: Deletou a cerca: ' . $id);
        return $this->grupocercaService->destroy($id);
    }
}
