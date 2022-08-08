<?php


namespace App\Repositories\FleetsLarge;

use App\Models\GrupoGaragem;
use App\Models\GrupoGaragemRelacionamento;

use App\Models\GrupoAlerta;
use App\Models\GrupoAlertaRelacionamento;

use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Models\GrupoUsuarioRelacionamento;
use App\Models\MapMarkerSantander;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class CercasRepository extends AbstractRepository
{

    public function __construct(
        GrupoCerca $model, 
        GrupoGaragem $modelGaragem, 
        GrupoAlerta $modelAlerta, 
        GrupoAlertaRelacionamento $modelAlertaRelacionamento, 
        GrupoCercaRelacionamento $modelCercaRelacionamento, 
        GrupoGaragemRelacionamento $modelGaragemRelacionamento, 
        GrupoUsuarioRelacionamento $modelUsuarioRelacionamento)
    {
        $this->model = $model;
        $this->modelGaragem = $modelGaragem;
        $this->modelAlerta = $modelAlerta;
        $this->modelAlertaRelacionamento = $modelAlertaRelacionamento;
        $this->modelCercaRelacionamento = $modelCercaRelacionamento;
        $this->modelGaragemRelacionamento = $modelGaragemRelacionamento;
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

    public function delete($id)
    {
        try {
            $this->modelGaragemRelacionamento->where('grupo_id', $id)->delete();
            // $this->modelUsuarioRelacionamento->where('id_grupo', $id)->delete();
            $this->modelGaragem->where('id', $id)->delete();
            $data = GrupoGaragem::all();
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function deleteAlerta($id)
    {
        try {
            $this->modelAlertaRelacionamento->where('id_grupo', $id)->delete();
            // $this->modelUsuarioRelacionamento->where('id_grupo', $id)->delete();
            $this->modelAlerta->where('id', $id)->delete();
            $data = GrupoAlerta::all();
            return response()->json(['status' => 'success', 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function getGrupoCercaSantander($arrGrupo)
    {

        return $this->model->with('grupoCercaRelacionamento')
            ->with('grupoUsuarioRelacionamento')
            ->whereIn('id', $arrGrupo)
            ->get();
    }

    public function getAllGrupoCercaSantander()
    {
        return GrupoCercaRelacionamento::with('santander')->with('grupoCerca')->get();
    }

    public function getAllGrupoCercaSantanderParameters($arrGrupo)
    {
        return GrupoGaragemRelacionamento::with('santander')->with('grupoGaragem')->whereIn('grupo_id', $arrGrupo)->get();
    }


    public function grupoSeletedSantander($arrIdsSeleted){
        return GrupoCercaRelacionamento::with('santander')->with('grupoCerca')->whereIn('grupo_id', $arrIdsSeleted)->get();
    }

    public function all(){
        return GrupoGaragem::with('grupoGaragemRelacionamento')->get();
    }

    public function getAllCercas($arrCercas){
        $markers = MapMarkerSantander::where('_id', $arrCercas)->get();
        return $markers;
    }
}
