<?php


namespace App\Repositories\FleetsLarge;


use App\Models\GrupoUsuario;
use App\Models\GrupoUsuarioRelacionamento;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class UsuariosRepository extends AbstractRepository
{

    public function __construct(GrupoUsuario $model, GrupoUsuarioRelacionamento $modelGrupoUsuario)
    {
        $this->model = $model;
        $this->modelGrupoUsuario = $modelGrupoUsuario;
    }

    public function saveGrupoUsuario($id, $data)
    {
        try {
            $usuario = $this->model->find($id);
            $usuario->detach();
            $this->model->grupoUsuarioRelacionamento()->syncWithoutDetaching($data);
            return response()->json(['status' => 'success', 'data' => $data], 201);

        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function delete($id){
        try{
            $this->modelGrupoUsuario->where('id_grupo', $id)->delete();
            $this->model->where('id', $id)->delete();
            $data = GrupoUsuario::all();
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch(\Exception $e){
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

}