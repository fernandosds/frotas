<?php

namespace App\Http\Controllers;

use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{

    protected $apiDeviceController;
    protected $deviceService;

    /**
     * MonitoringController constructor.
     * @param ApiDeviceController $apiDeviceController
     * @param DeviceService $deviceService
     */
    public function __construct(ApiDeviceController $apiDeviceController, DeviceService $deviceService)
    {

        $this->apiDeviceController = $apiDeviceController;
        $this->deviceService = $deviceService;

        $this->data = [
            'icon' => 'fa fa-map-marker',
            'title' => 'Monitoramento',
            'menu_open_boarding' => ''
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

        return view('monitoring.index', $data);
    }

    /**
     * @param String $device
     * @return \Illuminate\Http\JsonResponse
     */
    public function map(String $device)
    {

        if($this->deviceService->validDevice($device)){

            $last_positicon = $this->apiDeviceController->getLastPosition($device);

            if(empty($last_positicon)){
                return response()->json([]);
            }else{
                return response()->json(
                    [
                        [
                            'lat' => $last_positicon[0]['LATITUDE'],
                            'lng' => $last_positicon[0]['LONGITUDE']
                        ],
                        'status' => 'success'
                    ], 200);
            }

        }else{

            return response()->json(['status' => 'error', 'errors' => 'Ísca não encontrada'], 200);

        }


    }

}
