<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoUsuariosService;
use App\Services\UserService;
use App\User;
use App\Models\GrupoUsuario;
use App\Models\GrupoUsuarioRelacionamento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class GrupoUsuariosController extends Controller
{

    public function __construct(GrupoUsuariosService $grupousuariosService, UserService $userService)
    {
        $this->grupousuariosService = $grupousuariosService;
        $this->userService = $userService;
    }

    public function index()
    {
        $data['usuarios'] = GrupoUsuario::with('grupoUsuarioRelacionamento')->get();
        return view('fleetslarge.cercas.grupo_usuario.list', $data);
    }

    public function new(Request $request)
    {
        $data['users'] = $this->userService->paginate();
        if (!isset($request->id)) {
            return view('fleetslarge.cercas.grupo_usuario.new', $data);
        } else {
            $gruposUsuarios = GrupoUsuario::with('grupoUsuarioRelacionamento')->where('id', $request->id)->first();
            $data['grupo']  = $gruposUsuarios;
            return view('fleetslarge.cercas.grupo_usuario.new', $data);
        }
    }

    public function save(Request $request)
    {
        $usuarios = $request->users;

        //SE ID GRUPO FOR NULL ENTÃO É CADASTRO
        if (is_null($request->id_grupo)) {
            $grupoUsuario = new GrupoUsuario();
            $grupoUsuario->created_at = Carbon::now();
        } else {
            $this->logService->saveLog(strval(Auth::user()->name), 'Cerca: Monitorou a cerca ' . $request->id_grupo);
            $grupoUsuario = GrupoUsuario::find($request->id_grupo);
            $grupoUsuario->updated_at = Carbon::now();
        }

        $grupoUsuario->nome       = $request->nameGroup;
        $grupoUsuario->id_usuario = Auth::user()->id;

        if($grupoUsuario->save()){

            $arrGrupoUsuarioRelacionamento = [];
            foreach($usuarios as $usuario){
                $user = User::where('name', $usuario)->first();
                $arrMontagem = [
                    'id_grupo'      => $grupoUsuario->id,
                    'id_usuario'    => $user->id,
                    'nome_usuario'  => $usuario,
                    'created_at'    => Carbon::now()
                ];

                $arrGrupoUsuarioRelacionamento[] = $arrMontagem;
            }

            if (is_null($request->id_grupo)) {
                $grupoRelacionamento  =  new GrupoUsuarioRelacionamento();
                // $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Criou o grupo: ' . $request->name);
                return $grupoRelacionamento->insert($arrGrupoUsuarioRelacionamento)
                    ? response()->json(['status' => 'success'], 200)
                    : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
            } else {
                if (GrupoUsuarioRelacionamento::where('id_grupo', $grupoUsuario->id)->delete()) {
                    $grupoRelacionamento  =  new GrupoUsuarioRelacionamento();
                    // $this->logService->saveLog(strval(Auth::user()->name), 'Grupo: Editou o grupo: ' . $grupoUsuario->id);
                    return $grupoRelacionamento->insert($arrGrupoUsuarioRelacionamento)
                        ? response()->json(['status' => 'success'], 200)
                        : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
                }
            }

        }

        dd('Passou do if $grupoUsuario->save()');
        exit;

    }

    public function destroy(int $id){
        return $this->grupousuariosService->destroy($id);
    }
}
