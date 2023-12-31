<?php

namespace App\Http\Controllers\Iscas;

use App\Http\Controllers\Controller;
use App\Services\ApiDeviceService;
use App\Services\LogService;
use App\Services\Iscas\BoardingService;
use App\Http\Controllers\Iscas\FunctionController;
use App\Services\DeviceService;
use App\Models\Dispositivos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{

    protected $apiDeviceService;
    protected $deviceService;
    protected $boardingService;
    protected $functionController;
    protected $logService;


    /**
     * MonitoringController constructor.
     * @param ApiDeviceService $apiDeviceService
     * @param DeviceService $deviceService
     * @param BoardingService $boardingService
     * @param LogService $logService
     */
    public function __construct(ApiDeviceService $apiDeviceService, DeviceService $deviceService, BoardingService $boardingService, FunctionController $functionController, LogService $logService)
    {

        $this->apiDeviceService = $apiDeviceService;
        $this->deviceService = $deviceService;
        $this->boardingService = $boardingService;
        $this->functionController = $functionController;
        $this->logService = $logService;

        $this->data = [
            'icon' => 'fa fa-map-marker',
            'title' => 'Monitoramento',
            'menu_open_boarding' => ''
        ];
    }

    /**
     * @param null $device
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($device = null)
    {


        $data = $this->data;
        $data['device'] = $device;

        $this->logService->saveLog(strval(Auth::user()->name), 'Monitoramento: Monitorou a isca: ' . strval($device));
        saveLog([
            'value'     => strval(Auth::user()->name),
            'type'      => 'Monitoramento: Monitorou_a_isca: ' . strval($device),
            'local'     => 'MonitoringController',
            'funcao'    => 'index'
        ]);
        return view('monitoring.index', $data);
    }

    /**
     * @param String $device
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function lastPosition(String $device)
    {

        $telemil_dispositivo = Dispositivos::where('MODELO', $device)->first();

        // Verifica se a isca é válida
        if ($this->deviceService->validDevice($device)) {

            // Verifica se o embarque é válido
            $boarding = $this->boardingService->getCurrentBoardingByDevice($device);


            $time_left = (isset($boarding->finished_at)) ? timeLeft($boarding->finished_at) : '';

            if ($boarding) {

                // Verifica se possui dispositivo vinculado no embarque
                if (isset($boarding->pair_device)) {

                    // Pega status do dispositivo e pareamento
                    $check_pairing = $this->apiDeviceService->checkPairing($device, $boarding->pair_device);

                    if ($check_pairing['status'] == "success") {

                        if ($check_pairing['CheckStatusIsca']['status'] == "Pareado") {

                            $pairing = [
                                'status' => 'success',
                                'message' => "A ísca {$device} esta pareada com o rastreador {$boarding->pair_device}.",
                                'event' => $check_pairing['CheckStatusIsca']['event'],
                                'r12' => $check_pairing['CheckStatusIsca']['r12'],
                            ];
                        } else {

                            $pairing = [
                                'status' => 'error',
                                'message' => "A ísca {$device} não esta pareada com o rastreador {$boarding->pair_device}.",
                                'event' => $check_pairing['CheckStatusIsca']['event'],
                                'r12' => $check_pairing['CheckStatusIsca']['r12'],
                            ];
                        }
                    } else {

                        $pairing = [
                            'status' => 'error',
                            'message' => "A ísca {$device} não esta pareada com o rastreador {$boarding->pair_device}.",
                            'event' => (isset($check_pairing['CheckStatusIsca']['event'])) ? $check_pairing['CheckStatusIsca']['event'] : '',
                            'r12' => (isset($check_pairing['CheckStatusIsca']['r12'])) ? $check_pairing['CheckStatusIsca']['r12'] : '',
                        ];
                    }
                } else {
                    $pairing = [
                        'status' => 'false',
                        'message' => "Pareamento não informado no momento do embarque"
                    ];
                }
            } else {
                return response()->json(['status' => 'error', 'errors' => 'Ísca não embarcada'], 200);
            }

            // Get Last position
            $last_positions = $this->apiDeviceService->getLastPosition($device);

            // Get Address
            $address = "";
            if (isset($last_positions['body'][0])) {
                $address = $this->apiDeviceService->getAddress($last_positions['body'][0]['Latitude'], $last_positions['body'][0]['Longitude']);
            }
            $last_positions['body'][0]['codigo_produto'] = $telemil_dispositivo->CODIGO_PRODUTO;
            
            return ['last_positions' => $last_positions, 'pairing' => $pairing, 'time_left' => $time_left, 'address' => $address];
        } else {

            return response()->json(['status' => 'error', 'errors' => 'Ísca não encontrada'], 200);
        }
    }

    /**
     * @param String $lat
     * @param String $lng
     * @return array
     */
    public function getAddress(String $lat, String $lng)
    {
        return $this->apiDeviceService->getAddress($lat, $lng);
    }

    /**
     * @param String $device
     * @param Int $minutes
     * @return array
     */
    public function heat(String $device, Int $minutes = 15000)
    {
        $heat_positions = $this->apiDeviceService->getHeatPositions($device, $minutes);

        // Heat
        $arr_heat_positions = [];
        if (isset($heat_positions['body'])) {
            foreach ($heat_positions['body'] as $position) {

                $arr_heat_positions[] = [
                    $position['latitude_hospedeiro'],
                    $position['longitude_hospedeiro'],
                    0.1
                ];
            }
        }

        return $arr_heat_positions;
    }

    public function getExistsLorawan($model){
        try{

            $lorawan = $this->apiDeviceService->getLastPosition($model);

            $telemil_dispositivo = Dispositivos::where('MODELO', $model)->first();

            $lorawan['body'][0]['codigo_produto'] = $telemil_dispositivo->CODIGO_PRODUTO;

            if($lorawan['body'][0]['Satelites'] == '15' && $lorawan['body'][0]['codigo_produto'] >= 100){
                return Response()->json(['status' => 'success', 'isLorawan' => true], 200);
            }else{
                return Response()->json(['status' => 'success', 'isLorawan' => false], 200);
            }

        }catch(\Exception $e){
            return Response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

    }

        /**
     * @param String $device
     * @return array
     */
    public function heatLorawan(String $device)
    {
        $heat_positions = $this->apiDeviceService->getAllPosition($device);

        $arr_heat_positions = [];
        foreach($heat_positions['body'] as $position){
            $arr_heat_positions[] = [
                $position['Latitude'],
                $position['Longitude'],
                0.1
            ];
        }

        return $arr_heat_positions;

    }


    /**
     * @param String $model
     * @return mixed
     */
    public function testDevice(String $model)
    {

        $device = $this->deviceService->findByModel($model);

        $return['status'] = $device['status'];
        if ($device['status'] == 'success') {

            $boarding = $this->boardingService->getCurrentBoardingByDeviceId($device['data']->id);

            $return['device_type']  = $device['data']->technologie;
            $return['pair_device']  = (isset($boarding->pair_device)) ? $boarding->pair_device : 'Não Pareado';
            $return['model']        = $device['data']->model;
            $return['device_id']    = $device['data']->id;

            $test_device = $this->apiDeviceService->getLastPosition($model);

            if ($test_device['status'] == "sucesso") {

                $return['last_transmission'] = $test_device['body'][0]['Data_GPS'];
                $return['battery_level'] = $this->functionController->getStatus($test_device['body'][0]['Tensão'], $test_device['body'][0]['Data_GPS'], $boarding->created_at); //$test_device['body'][0]['Tensão'];
            } else {
                $return['last_transmission'] = '';
                $return['battery_level'] = '';
            }
        } else {

            $return['message'] = $device['message'];
        }


        return $return;
    }

    /**
     * @param String $device
     * @param Int $minutes
     * @return array
     */
    public function getGrid(String $device, Int $minutes)
    {

        $boarding = $this->boardingService->getCurrentBoardingByDevice($device);

        if ($boarding) {
            $pair_device = (isset($boarding->pair_device)) ? $boarding->pair_device : '';
        }

        $grid = $this->apiDeviceService->getGrid($device, $minutes);

        if ($grid['status'] == "sucesso") {
            $dataTable = [];
            foreach ($grid['body'] as $row) {
                $row['nivel_bateria'] = $this->functionController->getStatus($row['nivel_bateria'], $row['DATA_GPS_HOSPEDE'], $boarding->created_at);
                $dataTable[] = $row;
            }
            $data['return'] = [
                'status' => 'success',
                'pair_device' => $pair_device,
                'positions' =>  $dataTable
            ];
        } else {

            $data['return'] = [
                'status' => 'error',
                'message' => "Nenhuma posição encontrada para a ísca {$device}, no período de {$minutes} minutos."
            ];
        }

        return view('monitoring.grid', $data);
    }
    public function getGridLorawan(String $device)
    {
        $boarding = $this->boardingService->getCurrentBoardingByDevice($device);
        $grid = $this->apiDeviceService->getGridLorawan($device);
        
        $dataTable = [];
        if(count($grid) > 0){
            foreach ($grid['body'] as $row) {
                $row['nivel_bateria'] = $this->functionController->getStatus($row['Tensão'], $row['Data_GPS'], $boarding->created_at);
                $dataTable[] = $row;
            }

            $data['return'] = [
                'status'    => 'success',
                'positions' =>  $dataTable
            ];
        }else{
            $data['return'] = [
                'status' => 'error',
                'message' => "Nenhuma posição encontrada para a ísca {$device}."
            ];
        }

        return view('monitoring.grid', $data);
    }

    /**
     * @param String $device
     * @param String $from
     * @param String $to
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printGrid(String $device, String $from, String $to)
    {

        $carbon_from = Carbon::parse($from);

        if ($carbon_from->diffInDays(Carbon::parse($to)) <= 5) {

            $boarding = $this->boardingService->getCurrentBoardingByDevice($device);

            if ($boarding) {
                $pair_device = (isset($boarding->pair_device)) ? $boarding->pair_device : '';
            }

            $grid = $this->apiDeviceService->printGrid($device, $from, $to);


            if ($grid['status'] == "sucesso") {
                $dataTable = [];
                foreach ($grid['body'] as $row) {
                    $row['nivel_bateria'] =
                        $this->functionController->getStatus($row['nivel_bateria'], $row['DATA_GPS_HOSPEDE'], $boarding->created_at);
                    $dataTable[] = $row;
                }
                $data['return'] = [
                    'status' => 'success',
                    'pair_device' => $pair_device,
                    'positions' =>  $dataTable
                ];
            } else {

                $data['return'] = [
                    'status' => 'error',
                    'message' => "Nenhuma posição encontrada para a ísca {$device}, no período de {$from} até {$to}."
                ];
            }

            return view('monitoring.print_grid', $data);
        } else {
            return 'O intervalo entre as datas deve ser inferior a 5 dias';
        }
    }

    /**
     * @param String $device
     * @param String $pair_device
     * @return array
     */
    // public function checkPairing(String $device, String $pair_device)
    // {
    //     return $this->apiDeviceService->checkPairing($device, $pair_device);
    // }

    /**
     * @param String $device
     * @return \Illuminate\Http\JsonResponse
     */
    public function map(String $device, Int $minutes = 10)
    {
        /*
        if($this->deviceService->validDevice($device)){

            // Marker
            $last_positicon = $this->apiDeviceService->getLastPosition($device);

            // Heat map
            $heat_positions = $this->apiDeviceService->getHeatPositions($device, $minutes);

            $boarding = $this->boardingService->getCurrentBoardingByDevice($device);
            $time_left = timeLeft($boarding->finished_at);

            // Paring
            $pairing = [
                'status' => false,
                'message' => "A ísca {$device} não esta pareada com o rastreador {$boarding->pair_device}."
            ];
            if($boarding){

                if(isset($boarding->pair_device)){
                    $api_pairing = $this->apiDeviceService->getPairing($device, $boarding->pair_device);
                    if($api_pairing['status'] == "sucesso"){
                        if($api_pairing['body'][0]['msgs'] > 0){
                            $pairing = [
                                'status' => true,
                                'message' => "A ísca {$device} esta pareada com o rastreador {$boarding->pair_device}."
                            ];
                        }
                    }
                }else{
                    $pairing = [
                        'status' => false,
                        'message' => "Pareamento não informado no momento do embarque"
                    ];
                }

            }

            // Heat
            $arr_heat_positions = [];
            if(isset($heat_positions['body'])) {
                foreach ($heat_positions['body'] as $position) {

                    $arr_heat_positions[] = [
                        $position['latitude_hospedeiro'],
                        $position['longitude_hospedeiro'],
                        0.1
                    ];

                }
            }

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
                        'time_left' => $time_left,
                        'status' => 'success'
                    ], 200);
            }

        }else{

            return response()->json(['status' => 'error', 'errors' => 'Ísca não encontrada'], 200);

        }

*/
    }
}
