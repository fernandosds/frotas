<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\MapMarkerSantander;

class MapMarkersSantanderRepository extends AbstractRepository
{

    private $modelMovida;

    /**
     * UserRepository constructor.
     * @param MapMarkerSantander $modelSantander
     */
    public function __construct(MapMarkerSantander $modelSantander)
    {
        $this->modelSantander = $modelSantander;
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
            $this->model->save();
            return $this->model;
        } catch (\Exception $e) {
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
            return $this->model
                ->when($customer_id == 7, function ($query) {
                    return $query->where('customer', 42);
                }, function ($query) {
                    return $query->where('customer', 11);
                })
                ->get(['name']);
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
        return $this->model->find($id)->delete();
    }
}
