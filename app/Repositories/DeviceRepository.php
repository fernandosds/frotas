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
    public function saveDeviceContract(Request $request)
    {

        $devices = $this->model
            ->whereNull('contract_id')
            ->whereNull('customer_id')
            ->where('technologie_id', $request->technologie_id)
            ->limit($request->quantity)
            ->update([
                'contract_id' => $request->contract_id,
                'customer_id' => $request->customer_id
            ]);

        return $devices;
    }
}
