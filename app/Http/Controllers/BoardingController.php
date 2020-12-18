<?php

namespace App\Http\Controllers;

use App\Services\ApiDeviceService;
use App\Services\BoardingService;
use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardingController extends Controller
{

    /**
     * @var BoardingService
     */
    private $boardingService;

    /**
     * @var
     */
    private $deviceService;

    /**
     * @var ApiDeviceService
     */
    private $apiDeviceServic;

    /**
     * BoardingController constructor.
     * @param BoardingService $boardingService
     * @param DeviceService $deviceService
     * @param ApiDeviceService $apiDeviceServic
     */
    public function __construct(BoardingService $boardingService, DeviceService $deviceService, ApiDeviceService $apiDeviceServic)
    {
        $this->boardingService = $boardingService;
        $this->deviceService = $deviceService;
        $this->apiDeviceServic = $apiDeviceServic;

        $this->data = [
            'icon' => 'fa fa-shipping-fast',
            'title' => 'Embarque',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['boardings'] = $this->boardingService->paginate();

        return response()->view('boardings.list', $data);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function new()
    {

        $data = $this->data;
        return response()->view('boardings.new', $data);
    }

    public function testDevice(Request $request)
    {
        $device = $this->deviceService->findByModel($request->device);

        $return['status'] = $device['status'];
        if($device['status'] == 'success'){

            $return['device_type'] = $device['data']->device_type;
            $return['model'] = $device['data']->model;

            $test_device = $this->apiDeviceServic->testDevice($request->device);

            if($test_device['status'] == "sucesso"){
                $return['last_transmission'] = $test_device['body'][0]['dh_gps'];
                $return['battery_level'] = $test_device['body'][0]['nivel_bateria'];
            }else{
                $return['last_transmission'] = '';
                $return['battery_level'] = '';
            }

        }else{

            $return['message'] = $device['message'];

        }

        return $return;

    }



}
