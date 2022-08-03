<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\User;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\UserService;
use App\Services\FleetsLarge\GrupoCercaRelacionamentoService;

use App\Models\GrupoAlerta;
use App\Models\GrupoAlertaRelacionamento;

use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Models\GrupoUsuarioRelacionamento;
use App\Models\BancoSantander;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GrupoAlertaController extends Controller
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
        $data['grupos'] = GrupoAlerta::with('grupoAlertaRelacionamento')->get();
        return view('fleetslarge.alerta.list', $data);
    }

    public function new(Request $request)
    {
        
        $data = $this->data;
        
        if (!isset($request->id)) {
            $data['users'] = $this->userService->paginate();
            
            return view('fleetslarge.alerta.new', $data);
        } else {
            $removeUser  = [];
            $gruposAlerta = GrupoAlerta::with('grupoAlertaRelacionamento')->where('id', $request->id)->first();

            $data['grupo']  = $gruposAlerta;

            $gruposUsuarios = GrupoAlerta::with('grupoUsuarioRelacionamento')->where('id', $request->id)->first();
            $data['usuarios']  = $gruposUsuarios;

            foreach ($gruposUsuarios->grupoAlertaRelacionamento as $grupoAlertaRelacionamento) {
                $removeUser[] = $grupoAlertaRelacionamento->nome_usuario;
            }

            $data['users'] = $this->userService->getRemoveUsers($removeUser);

            return view('fleetslarge.alerta.new', $data);
        }
    }

    public function save(Request $request)
    {

        if (empty($request->name)) {
            return response()->json(['status' => 'error', 'errors' => 'Não é permitido criar um Grupo com o campo nome vazio'], 400);
        }

        if(!isset($request->email) && !isset($request->telephone)){
            return response()->json(['status' => 'error', 'errors' => 'Seleciona o tipo de recebimento de alerta'], 400);
        }
        $usuarios = $request->usuarios;

        //SE ID GRUPO FOR NULL ENTÃO É CADASTRO
        if (is_null($request->id_grupo)) {
            $grupoAlerta = new GrupoAlerta();
            $grupoAlerta->created_at = Carbon::now();
        } else {
            $this->logService->saveLog(strval(Auth::user()->name), 'Mapa Monitoramento: Monitorou o grupo: ' . $request->id_grupo);
            saveLog([
                'value'     => strval(Auth::user()->name),
                'type'      => "Grupo: Monitorou_o_grupo {$request->name}",
                'local'     => 'GrupoAlertaController',
                'funcao'    => 'save'
            ]);
            $grupoAlerta = GrupoAlerta::find($request->id_grupo);
            $grupoAlerta->updated_at = Carbon::now();
        }

        $grupoAlerta->nome       = $request->name;
        $grupoAlerta->user_id    = Auth::user()->id;
        $grupoAlerta->telephone  = (isset($request->telephone)) ? true : false;
        $grupoAlerta->email      = (isset($request->email)) ? true : false;
        
        if ($grupoAlerta->save()) {
            $arrMontagem = [];

            foreach ($usuarios as $usuario) {
                $user = User::where('name', $usuario)->first();
                $arrMontagemUser[] = [
                    'id_grupo'      => $grupoAlerta->id,
                    'id_usuario'    => $user->id,
                    'nome_usuario'  => $usuario,
                    'created_at'    => Carbon::now()
                ];
            }

            if (is_null($request->id_grupo)) {
                $grupoAlerta           =  new GrupoAlertaRelacionamento();
                $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Criou o grupo: ' . $request->name);
                saveLog([
                    'value'     => strval(Auth::user()->name),
                    'type'      => "Grupo: Criou_o_grupo: " . $request->name,
                    'local'     => 'GrupoAlertaController',
                    'funcao'    => 'save'
                ]);

                return $grupoAlerta->insert($arrMontagemUser)
                    ? response()->json(['status' => 'success'], 200)
                    : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
            } else {
                $validation = GrupoAlertaRelacionamento::where('id_grupo', $grupoAlerta->id)->delete() ? true : false;
                if ($validation) {
                    $grupoAlerta =  new GrupoAlertaRelacionamento();

                    saveLog([
                        'value'     => strval(Auth::user()->name),
                        'type'      => "Grupo: Editou_o_grupo: " . $grupoAlerta->id,
                        'local'     => 'GrupoAlertaController',
                        'funcao'    => 'save'
                    ]);
                    $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Editou o grupo: ' . $grupoAlerta->id);

                    return $grupoAlerta->insert($arrMontagemUser)
                        ? response()->json(['status' => 'success'], 200)
                        : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
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
            'local'     => 'GrupoAlertaController',
            'funcao'    => 'destroy'
        ]);
        $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Deletou o grupo: ' . $id);
        //CRIAR O DESTROY ALERTA NA SERVICES 
        return $this->grupocercaService->destroyAlerta($id);
    }

}
