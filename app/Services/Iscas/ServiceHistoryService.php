<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Services\Iscas;

use App\Models\Device;
use Illuminate\Http\Request;

use App\Repositories\Iscas\ServiceHistoryRepository;
use App\Repositories\DeviceRepository;
use Illuminate\Support\Facades\Auth;


class ServiceHistoryService
{

    protected $serviceHistoryRepository;
    protected $deviceRepository;

    /**
     * ServiceHistoryRepository constructor.
     * @param ServiceHistoryRepository $serviceHistoryRepository
     */
    public function __construct(ServiceHistoryRepository $serviceHistoryRepository, DeviceRepository $deviceRepository)
    {
        $this->serviceHistoryRepository = $serviceHistoryRepository;
        $this->deviceRepository = $deviceRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function saveHistory(Request $request)
    {
        $deviceId =  $this->deviceRepository->findDevice($request['device_number']);
        unset($request['device_number']);

        $request->merge([
            'customer_id' => Auth::user()->customer_id,
            'user_id' => Auth::user()->id,
            'device_id' => $deviceId->id
        ]);

        $seveHistory = $this->serviceHistoryRepository->create($request->all());
        return $seveHistory;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function showDevice($device_number)
    {
        $deviceId =  $this->deviceRepository->findDevice($device_number);
        return $deviceId;
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function showByCustomerId(Int $deviceId)
    {
        $deviceId =  $this->serviceHistoryRepository->showByCustomerId($deviceId);
        return ($deviceId) ? $deviceId : abort(404);
    }
}
