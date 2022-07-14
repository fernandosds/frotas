<?php


namespace App\Repositories\FleetsLarge;


use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Models\GrupoUsuarioRelacionamento;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class CercasRepository extends AbstractRepository
{

    public function __construct(GrupoCerca $model, GrupoCercaRelacionamento $modelCercaRelacionamento, GrupoUsuarioRelacionamento $modelUsuarioRelacionamento)
    {
        $this->model = $model;
        $this->modelCercaRelacionamento = $modelCercaRelacionamento;
        $this->modelUsuarioRelacionamento = $modelUsuarioRelacionamento;
    }

    public function saveCercaGrupo($id, $data)
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

    public function delete($id){
        try{
            $this->modelCercaRelacionamento->where('grupo_id', $id)->delete();
            $this->modelUsuarioRelacionamento->where('id_grupo', $id)->delete();
            $this->model->where('id', $id)->delete();
            $data = GrupoCerca::all();
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch(\Exception $e){
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function getGrupoCercaSantander($arrGrupo){

        return $this->model->with('grupoCercaRelacionamento')
            ->with('grupoUsuarioRelacionamento')
            ->whereIn('id', $arrGrupo)
            ->get();
    }

    public function getAllGrupoCercaSantander(){
        return GrupoCercaRelacionamento::with('santander')->get();

        // return $this->model->with('grupoCercaRelacionamento')->with('grupoUsuarioRelacionamento')->get();
    }

}
