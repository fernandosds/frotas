<?php


namespace App\Repositories;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Device $model
     */
    public function __construct(Device $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
    public function filter(int $customer_id)
    {
        $customer = DB::table('devices')
            ->select(DB::raw('*'))
            ->where('customer_id', '=', $customer_id)
            ->get();


        return $customer;
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




        $devices = $this->model
            ->whereNull('contract_id')
            ->whereNull('customer_id')
            ->where('technologie_id', $object->technologie_id)
            ->limit($object->quantity);

        /*
            ->update([
                'contract_id' => $object->contract_id,
                'customer_id' => $object->contract->customer_id
            ]);
            */

        if ($devices->count() < $object->quantity) {
            return ['status' => 'error', 'message' => 'Quantidade de dispositivos insuficiente no estoque'];
        } else {

            $devices->update([
                'contract_id' => $object->contract_id,
                'customer_id' => $object->contract->customer_id
            ]);

            return ($devices) ? ['status' => 'success'] : ['status' => 'error'];
        }
    }


    /**
     * @param int $customer_id
     * @return \Illuminate\Support\Collection
     */
    public function filterByContractDevice($contract_devices)
    {
        //var_dump($contract_devices);
        //die();

        $users = $this->model
            ->where([
                ['id', '=', $contract_devices->id],
                ['technologie_id', '=',  $contract_devices->technologie_id],

            ])
            ->select('*')
            ->get();

        print_r($users);
        die();
    }
}
