<?php

namespace App\Http\Controllers;

use App\Services\ApiDeviceService;
use App\Services\BoardingService;
use App\Services\DeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{

    protected $apiDeviceService;
    protected $deviceService;
    protected $boardingService;

    /**
     * MonitoringController constructor.
     * @param ApiDeviceService $apiDeviceService
     * @param DeviceService $deviceService
     * @param BoardingService $boardingService
     */
    public function __construct(ApiDeviceService $apiDeviceService, DeviceService $deviceService, BoardingService $boardingService)
    {

        $this->apiDeviceService = $apiDeviceService;
        $this->deviceService = $deviceService;
        $this->boardingService = $boardingService;

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

            // Marker
            $last_positicon = $this->apiDeviceService->getLastPosition($device);

            // Heat map
            $heat_positions = $this->apiDeviceService->getHeatPositions($device);

            // Paring
            $pairing = false;
            $boarding = $this->boardingService->getCurrentBoardingByDevice($device);
            if($boarding){
                $api_pairing = $this->apiDeviceService->getPairing($device, $boarding->pair_device);
                if($api_pairing['status'] == "sucesso"){
                    if($api_pairing['body'][0]['msgs'] > 0){
                        $pairing = true;
                    }
                }
            }

            // Heat
            $arr_heat_positions = [];
            foreach($heat_positions['body'] as $position){

                $arr_heat_positions[] = [
                    $position['latitude_hospedeiro'],
                    $position['longitude_hospedeiro'],
                    0.1
                ];

            };

            // Marker
            if(empty($last_positicon)){
                return response()->json([]);
            }else{
                return response()->json(
                    [
                        [
                            'qtd_satelite' => $last_positicon[0]['QT_SATELITE'],
                            'atualizado' => $last_positicon[0]['ATUALIZADO'],
                            'lat' => $last_positicon[0]['LATITUDE'],
                            'lng' => $last_positicon[0]['LONGITUDE'],
                            'pairing' => $pairing
                        ],
                        'heat_positions' => $arr_heat_positions,
                        'status' => 'success'
                    ], 200);
            }

        }else{

            return response()->json(['status' => 'error', 'errors' => 'Ísca não encontrada'], 200);

        }


    }

    /**
     * @param String $model
     * @return mixed
     */
    public function testDevice(String $model)
    {

        $device = $this->deviceService->findByModel($model);

        $boarding = $this->boardingService->getCurrentBoardingByDeviceId($device['data']->id);

        $return['status'] = $device['status'];
        if ($device['status'] == 'success') {

            $return['device_type']  = $device['data']->technologie;
            $return['pair_device']  = ($boarding->pair_device) ? $boarding->pair_device : 'Não Pareado';
            $return['model']        = $device['data']->model;
            $return['device_id']    = $device['data']->id;

            $test_device = $this->apiDeviceService->testDevice($model);

            if ($test_device['status'] == "sucesso") {
                $return['last_transmission'] = $test_device['body'][0]['dh_gps'];
                $return['battery_level'] = $test_device['body'][0]['nivel_bateria'];
            } else {
                $return['last_transmission'] = '';
                $return['battery_level'] = '';
            }
        } else {

            $return['message'] = $device['message'];
        }


        return $return;
    }

}
