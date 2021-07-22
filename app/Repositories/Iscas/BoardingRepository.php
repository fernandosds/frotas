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
        return $this->model->where('device_id', $id)
            ->where('customer_id', Auth::user()->customer_id)
            ->where('active', 1)
            ->first();
    }

    /**
     * @param Int $id
     * @return mixed
     */
    public function getAllActive()
    {
        if (Auth::user()->type == 'ext') {
            return $this->model->where('customer_id', Auth::user()->customer_id)
                ->where('active', 1)
                ->paginate(10);
        }
        return $this->model->where('active', 1)
            ->paginate(10);
    }


    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginateFinished(Int $limit)
    {
        return $this->model->where('active', '0')->orderBy('id', 'desc')->paginate($limit);
    }

    /**
     * @return mixed
     */
    public function getAllPairActive()
    {
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
        return DB::table('boardings')
            ->join('devices', 'devices.id', '=', 'boardings.device_id')
            ->select('boardings.*')
            ->where('devices.model', $device)
            ->where('boardings.customer_id', Auth::user()->customer_id)
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
