<?php


namespace App\Repositories\FleetsLarge;


use App\Models\GrupoUsuario;
use App\Models\GrupoUsuarioelacionamento;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class UsuariosRepository extends AbstractRepository
{

    public function __construct(GrupoUsuario $model)
    {
        $this->model = $model;
    }

    public function saveGrupoUsuario($id, $data)
    {
        try {
            $cercas = $this->model->find($id);
            $cercas->detach();
            $this->model->grupoCerca()->syncWithoutDetaching($data);
            return response()->json(['status' => 'success', 'data' => $data], 201);

        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

}
