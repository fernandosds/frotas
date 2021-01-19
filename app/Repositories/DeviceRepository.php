<?php


namespace App\Repositories;

use App\Models\Device;
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

    public function filter(int $customer_id)
    {
        $customer = DB::table('devices')
            ->select(DB::raw('*'))
            ->where('customer_id', '=', $customer_id)
            ->get();


        return $customer;
    }
}
