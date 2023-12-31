<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Repositories\Iscas;


use App\Models\Boarding;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\AbstractRepository;

class BoardingRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Boarding $model
     */
    public function __construct(Boarding $model)
    {
        $this->model = $model;
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function finish(Int $id)
    {

        return $this->model->where('id', $id)
            ->where('customer_id', Auth::user()->customer_id)
            ->update(['active' => 0]);
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getCurrentBoardingByDeviceId(Int $id)
    {
        $adminSat = Auth::user()->email == 'admin@satcompany.com.br';

        return $this->model->where('device_id', $id)
            ->when(!$adminSat, function ($query) {
                return $query->where('customer_id', Auth::user()->customer_id);
            })
            ->where('active', 1)
            ->first();
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getAllActive($customer_id, $device_id)
    {

        $adminSat = Auth::user()->email == 'admin@satcompany.com.br';

        return $this->model
            ->where('active', 1)
            ->when(!$adminSat, function ($query) {
                return $query->where('customer_id', Auth::user()->customer_id);
            })
            ->when($customer_id != null, function ($query) use ($customer_id) {
                return $query->where('customer_id', $customer_id);
            })
            ->when($device_id != null, function ($query) use ($device_id) {
                return $query->where('device_id', $device_id->id);
            })
            ->orderBy('customer_id', 'asc')
            ->paginate(200);
    }


    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginateFinished(Int $limit)
    {
        $adminSat = Auth::user()->email == 'admin@satcompany.com.br';
        return $this->model
            ->where('active', '0')
            ->when(!$adminSat, function ($query) {
                return $query->where('customer_id', Auth::user()->customer_id);
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }

    /**
     * @return mixed
     */
    public function getAllPairActive()
    {
        /*
        $adminSat = Auth::user()->email == 'admin@satcompany.com.br';

        return $this->model->where('active', 1)
            ->when(!$adminSat, function ($query) {
                return $query->where('customer_id', Auth::user()->customer_id);
            })
            ->whereNotNull('pair_device')
            ->get();
            */
        return $this->model->where('active', 1)
            ->whereNotNull('pair_device')
            ->get();
    }

    /**
     * @param String $device
     * @return mixed
     */
    public function getCurrentBoardingByDevice(String $device)
    {
        $adminSat = Auth::user()->email == 'admin@satcompany.com.br';
        return DB::table('boardings')
            ->join('devices', 'devices.id', '=', 'boardings.device_id')
            ->select('boardings.*')
            ->where('devices.model', $device)
            ->when(!$adminSat, function ($query) {
                return $query->where('boardings.customer_id', Auth::user()->customer_id);
            })
            ->where('boardings.active', 1)
            ->first();
    }

    /**
     * @return mixed
     */
    public function autoFinatlizeBoardings()
    {

        return $this->model->where('finished_at', '<', date('Y-m-d H:i:s'))
            ->update(['active' => 0]);
    }
}
