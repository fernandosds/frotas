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

}