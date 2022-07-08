<?php


namespace App\Repositories\FleetsLarge;


use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class CercasRepository extends AbstractRepository
{

    public function __construct(GrupoCerca $model)
    {
        $this->model = $model;
    }

    public function saveCercaGrupo($id, $data)
    {
        try {    
            // $cercas = $this->model->find($id);
            // $cercas->detach();
            // $this->model->GrupoCercaRelacionamento()->syncWithoutDetaching($data);
            // return response()->json(['status' => 'success', 'data' => $data], 201);

            
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

}
