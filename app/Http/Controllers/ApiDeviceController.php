<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 16:41
 */

namespace App\Http\Controllers;


use App\Services\ApiDeviceService;

class ApiDeviceController
{

    /**
     * @var BoardingService
     */
    private $apiDeviceService;

    /**
     * BoardingController constructor.
     * @param ApiDeviceService $apiDeviceService
     */
    public function __construct(ApiDeviceService $apiDeviceService)
    {
        $this->apiDeviceService = $apiDeviceService;
    }

    /**
     * @param String $device
     * @return mixed
     */
    public function testDevice(String $device)
    {
        return $this->apiDeviceService->testDevice($device);
    }

}