<?php


namespace App\Repositories\FleetsLarge;


use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class CercasRepository extends AbstractRepository
{

    public function __construct(GrupoCerca $model, GrupoCercaRelacionamento $modelCercaRelacionamento)
    {
        $this->model = $model;
        $this->modelCercaRelacionamento = $modelCercaRelacionamento;
    }

    public function saveCercaGrupo($id, $data)
    {
<<<<<<< HEAD
        try {
            $cercas = $this->model->find($id);
            $cercas->detach();
            $this->model->grupoCerca()->syncWithoutDetaching($data);
            return response()->json(['status' => 'success', 'data' => $data], 201);

=======
        try {    
            // $cercas = $this->model->find($id);
            // $cercas->detach();
            // $this->model->GrupoCercaRelacionamento()->syncWithoutDetaching($data);
            // return response()->json(['status' => 'success', 'data' => $data], 201);

            
>>>>>>> 69203617124881c3fa9902177658b18d0daf85bb
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function delete($id){
        try{
            $this->modelCercaRelacionamento->where('grupo_id', $id)->delete();
            $this->model->where('id', $id)->delete();
            $data = GrupoCerca::all();
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch(\Exception $e){
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }


}
