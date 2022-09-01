<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\MapMarkerMovida;
use App\Models\MapMarkerSantander;
use App\Models\MapMarkerMapfre;


class MapMarkersRepository extends AbstractRepository
{

    private $modelMovida;
    private $modelSantander;

    /**
     * UserRepository constructor.
     * @param MapMarkerMovida $modelMovida
     * @param MapMarkerSantander $modelSantander
     */
    public function __construct(MapMarkerMovida $modelMovida, MapMarkerSantander $modelSantander, MapMarkerMapfre $modelMapfre)
    {
        $this->modelMovida       = $modelMovida;
        $this->modelSantander    = $modelSantander;
        $this->modelMapfre       = $modelMapfre;
    }

    public function create(array $data)
    {
        
        try {
            $this->fixModel();

            $this->model->name = $data['name'];
            $this->model->type = $data['type'];
            $this->model->lenght_of_stay = $data['lenght_of_stay'];
            $this->model->to_deliver = $data['to_deliver'];
            $this->model->markers = $data['markers'];
            $this->model->user_id = Auth::user()->id;
            if (Auth::user()->customer_id == 7) {
                $this->model->customer = 42;
            }
            if (Auth::user()->customer_id == 11) {
                $this->model->customer = 11;
            }
            
            return $this->model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function deleteMarker($id, $name)
    {
        try {
            $this->fixModel();
            return $this->model->find($id);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getMarkers()
    {
        try {
            $customer_id = Auth::user()->customer_id;
            $this->fixModel();
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
            $this->fixModel();
            return $this->model->find($id);
        } catch (\Exception $e) {
            return $e;
        }
    }


    public function getByCustomer()
    {
        if (Auth::user()->customer_id == 7 || Auth::user()->customer_id == 8) {
            return $this->getMarkers();
        } else {
            $this->model->findByCustomer(Auth::user()->customer_id);
        }
    }

    private function fixModel()
    {
        if (Auth::user()->customer_id == 7) {
            $this->model = $this->modelMovida;
        }

        if (Auth::user()->customer_id == 8) {
            $this->model = $this->modelSantander;
        }

        if (Auth::user()->customer_id == 11) {
            $this->model = $this->modelMapfre;
        }
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
