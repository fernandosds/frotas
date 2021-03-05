<?php

namespace App\Http\Controllers\Fleets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiDeviceService;

class MonitoringController extends Controller
{

    /**
     * @var DeviceService
     */
    private $deviceService;
    /**
     * FleetController constructor.
     *
     * @param ApiDeviceService $apiDeviceService
     */

    public function __construct(ApiDeviceService $apiDeviceService)
    {

        $this->apiDeviceService = $apiDeviceService;
        $this->data = [
            'icon' => 'flaticon-truck',
            'title' => 'Monitoramento',
            'menu_open_fleets_monitoring' => 'kt-menu__item--open'
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = $this->data;

        return response()->view('fleets.monitoring.index', $data);
    }

    public function positions()
    {
        /*

            '9BFZH54S9M8038266' => 907156501,
            '9BFZH54SXM8043234' => 907156689,
            '8AFAR21N4MJ206981' => 907156676,
            '8AFAR21N5MJ206973' => 907156664,
            '9BFZH54S8M8038274' => 907156507,
            '9BFZH54S0M8037409' => 907156656,
            '8AFAR23NXMJ201135' => 907156521,
            '9BFZH54S5M8037406' => 907156499,
            '9BFZH54S0M8038267' => 907156532,
            '8AFAR21N9MJ203168' => 907156666,
        */
        $chassis = [
            'RFI2D86' => 907156501,
            'RFI2D83' => 907156689,
            'RFT6F57' => 907156676,
            'RFT6F56' => 907156664,
            'RFI2D85' => 907156507,
            'RFI2D84' => 907156656,
            'RFI2D82' => 907156521,
            'RFJ4G49' => 907156499,
            'RFJ4G48' => 907156532,
            'RFT6F59' => 907156666,
        ];
        $geojson = array('type' => 'FeatureCollection', 'features' => array());
        $aux = 0;
        $auxColor = 0;
        $colors = ['red', 'darkred', 'orange', 'green', 'darkgreen', 'blue', 'purple', 'darkpuple', 'cadetblue'];
        foreach($chassis as $placa => $device) {
            $test_device = $this->apiDeviceService->getLastPosition($device);
            if ($test_device['status'] == "sucesso") {
                $return['last_transmission'] = ['Data_GPS'];
                $return['battery_level'] = $test_device['body'][0]['Tensão'];

                $marker = array(
                    'type' => 'Feature',
                    'features' => array(
                        'type' => 'Feature',
                        'properties' => array(
                            'id' => $test_device['body'][0]['ID'],
                            'chassi'=> $placa,
                            'placa'=> $placa,
                            'number' => $aux,
                            'color' => $colors[$auxColor]
                        ),
                        "geometry" => array(
                            'type' => 'Point',
                            'coordinates' => array(
                                $test_device['body'][0]['Longitude'],
                                $test_device['body'][0]['Latitude']
                            )
                        )
                    )
                );
                array_push($geojson['features'], $marker['features']);
                $aux++;
                $auxColor++;
                if($auxColor > 8){
                    $auxColor = 0;
                }
            }
        }
        echo json_encode($geojson);
    }
}
