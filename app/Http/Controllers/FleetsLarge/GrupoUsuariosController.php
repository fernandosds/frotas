<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoUsuariosService;
use App\Services\UserService;
use App\User;
use App\Models\GrupoUsuario;
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
        return view('fleetslarge.cercas.grupo_usuario.list');
    }

    public function new()
    {

        $data['users'] = $this->userService->paginate();
        //dd($data);
        return view('fleetslarge.cercas.grupo_usuario.new', $data);
    }

    public function save(Request $request)
    {

        $usuarios = $request->users;

        $grupoUsuario = new GrupoUsuario();
        $grupoUsuario->nome       = $request->nameGroup;
        $grupoUsuario->id_usuario = Auth::user()->id;
        $grupoUsuario->created_at = Carbon::now();

        if($grupoUsuario->save()){

            // dd('Dentro do if $grupoUsuario->save()');
            // exit;


            $arrGrupoUsuarioRelacionamento = [];
            foreach($usuarios as $usuario){
                $user = User::where('name', $usuario)->first();
                $arrMontagem = [
                    'id_grupo'      => $grupoUsuario->id,
                    'id_usuario'        => $user->id,
                    'created_at'    => Carbon::now()
                ];

                $arrGrupoUsuarioRelacionamento[] = $arrMontagem;
            }

            try {
                $this->grupousuariosService->saveGrupoUsuario($grupoUsuario->id, $arrGrupoUsuarioRelacionamento);
                return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
            }

        }

        dd('Passou do if $grupoUsuario->save()');
        exit;

    }
}