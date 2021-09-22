<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\MapMarkerMovida;
use App\Models\MapMarkerSantander;

class MapMarkersRepository extends AbstractRepository
{

    private $modelMovida;
    private $modelSantander;

    /**
     * UserRepository constructor.
     * @param MapMarkerMovida $modelMovida
     * @param MapMarkerSantander $modelSantander
     */
    public function __construct(MapMarkerMovida $modelMovida, MapMarkerSantander $modelSantander)
    {
        $this->modelMovida = $modelMovida;
        $this->modelSantander = $modelSantander;
    }

    public function create(array $data)
    {
        try {
            $this->fixModel();
            $this->model->name = $data['name'];
            $this->model->markers = $data['markers'];
            $this->model->save();
            return $this->model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getMarkers()
    {
        try {
            $this->fixModel();
            return $this->model->get(['name']);
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
    }
}
