<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\MapMarkerSantander;
use App\Models\CercaGaragem;
use App\Models\GrupoAlerta;
use App\Models\GrupoGaragem;
use App\Models\GrupoAlertaGaragem;
use Carbon\Carbon;

class MapMarkersSantanderRepository extends AbstractRepository
{

    private $modelSantander;

    /**
     * UserRepository constructor.
     * @param MapMarkerSantander $modelSantander
     */
    public function __construct(MapMarkerSantander $modelSantander)
    {
        $this->model = $modelSantander;
    }

    public function create(array $data)
    {   
        
        try {
            $this->model->name = $data['name'];
            $this->model->type = $data['type'];
            $this->model->lenght_of_stay = $data['lenght_of_stay'];
            $this->model->to_deliver = $data['to_deliver'];
            $this->model->markers = $data['markers'];
            $this->model->user_id = Auth::user()->id;
            if($this->model->save()){

                $grupoGaragens = GrupoGaragem::whereIn('nome', $data['garagens'])->get();

                foreach($grupoGaragens as $grupoGaragem){
                    $cercaGaragem = new CercaGaragem();
                    $cercaGaragem->id_garagem = $grupoGaragem->id;
                    $cercaGaragem->id_cerca   = $this->model->_id;
                    
                    $cercaGaragem->created_at = Carbon::now(); 
                    $cercaGaragem->updated_at = Carbon::now();
                    $validation = $cercaGaragem->save() ? true : false;
                    if($validation){
                        continue;
                    }else{
                        return Response()->Json(['status' => 'error', 'errors' => 'Não foi possivel gravar na table cerca_garagem'], 500);

                    }
                    return $this->model;
                }

            }else{
                return Response()->Json(['status' => 'error', 'errors' => 'Não foi possivel gravar a cerca'], 500);
            }

        } catch (\Exception $e) {
            dd($e);
            return $e;
        }
    }

    public function deleteMarker($id, $name = null)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getMarkers()
    {
        try {
            $customer_id = Auth::user()->customer_id;
            return $this->model->get(['name']);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getMarker($id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getByCustomer()
    {
        return $this->getMarkers();
    }

    public function delete($id)
    {
        $modelMarker = $this->model->find($id);
        $validationMarkers = $modelMarker->delete() ? true : false;
        if($validationMarkers){
            return CercaGaragem::where('id_cerca', $modelMarker->_id)->delete();
        }
    }
}
