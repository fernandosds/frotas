<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Repositories\Iscas;


use App\Models\ServiceHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\AbstractRepository;

class ServiceHistoryRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param ServiceHistory $model
     */
    public function __construct(ServiceHistory $model)
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
    public function showByCustomerId(Int $deviceId)
    {


        return $this->model->where('device_id', $deviceId)
            ->where('customer_id', Auth::user()->customer_id)
            ->orderBy('id', 'desc')
            ->get();
    }
}
