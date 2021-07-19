<?php

namespace App\Repositories\Iscas;


use App\Models\Tracker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\AbstractRepository;

class TrackerRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     * @param Boarding $model
     */
    public function __construct(Tracker $model)
    {
        $this->model = $model;
    }

    public function findTrackerByModel($trackerModel)
    {
        $trackerModel = $this->model
            ->where('model', '=', $trackerModel)
            ->where('customer_id', '=', Auth::user()->customer_id)
            ->first();

        return $trackerModel;
    }

    /**
     * @param String $model
     * @return mixed
     */
    public function exists(String $model)
    {
        return $this->model->where('model', $model)->count();
    }

    /**
     * @param String $model
     * @return mixed
     */
    public function attachDevices($object)
    {
        $trackerDevices = $this->model
            ->whereNull('contract_id')
            ->whereNull('customer_id')
            ->limit($object->quantity);

        if ($trackerDevices->count() < $object->quantity) {
            return ['status' => 'error', 'message' => 'Quantidade de dispositivos insuficiente no estoque'];
        } else {
            $trackerDevices->update([
                'contract_id' => $object->contract_id,
                'customer_id' => $object->contract->customer_id,
                'status'      => 'disponivel'
            ]);

            return ($trackerDevices) ? ['status' => 'success'] : ['status' => 'error'];
        }
    }

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
    public function filterByContractDevice($contract_devices)
    {
        $trackers = $this->model
            ->where('contract_id', $contract_devices->contract_id)
            ->get();

        return $trackers;
    }

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
    public function filter(int $customer_id)
    {
        $tracker = $this->model->select(DB::raw('*'))
            ->where('customer_id', '=', $customer_id)
            ->get();
        return $tracker;
    }
}
