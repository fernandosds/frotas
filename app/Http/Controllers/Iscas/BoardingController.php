<?php

namespace App\Http\Controllers\Iscas;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardingRequest;
use App\Services\ApiDeviceService;
use App\Services\ApiUserService;
use App\Services\Iscas\BoardingService;
use App\Services\DeviceService;
use App\Services\Iscas\ServiceHistoryService;
use App\Services\Iscas\TypeOfLoadService;
use App\Services\Iscas\AccommodationLocationsService;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;

class BoardingController extends Controller
{

    /**
     * @var BoardingService
     */
    private $boardingService;

    /**
     * @var DeviceService
     */
    private $deviceService;

    /**
     * @var ApiDeviceService
     */
    private $apiDeviceServic;

    /**
     * @var TypeOfLoadService
     */
    private $typeOfLoadService;

    /**
     * @var AccommodationLocationsService
     */
    private $accommodationLocationsService;

    /**
     * @var $apiUserService
     */
    private $apiUserService;

    /**
     * BoardingController constructor.
     * @param BoardingService $boardingService
     * @param DeviceService $deviceService
     * @param ApiDeviceService $apiDeviceServic
     * @param TypeOfLoadService $typeOfLoadService
     * @param AccommodationLocationsService $accommodationLocationsService
     * @param ApiUserService $apiUserService
     * @param ServiceHistoryService $serviceHistoryService
     */
    public function __construct(
        BoardingService $boardingService,
        DeviceService $deviceService,
        ApiDeviceService $apiDeviceServic,
        TypeOfLoadService $typeOfLoadService,
        AccommodationLocationsService $accommodationLocationsService,
        ApiUserService $apiUserService,
        ServiceHistoryService $serviceHistoryService
    ) {
        $this->boardingService = $boardingService;
        $this->deviceService = $deviceService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->typeOfLoadService = $typeOfLoadService;
        $this->accommodationLocationsService = $accommodationLocationsService;
        $this->apiUserService = $apiUserService;
        $this->serviceHistoryService = $serviceHistoryService;

        $this->data = [
            'icon' => 'fa fa-shipping-fast',
            'title' => 'Embarque',
            'menu_open_boarding' => 'kt-menu__item--open'
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
        $data['boardings'] = $this->boardingService->getAllActive();

        return response()->view('boardings.list', $data);
    }


    public function finished()
    {

        $data = $this->data;
        $data['boardings'] = $this->boardingService->paginateFinished();

        return response()->view('boardings.finished', $data);
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $data = $this->data;

        $data['accommodationlocations'] = $this->accommodationLocationsService->all();
        $data['typeofloads'] = $this->typeOfLoadService->all();

        return response()->view('boardings.new', $data);
    }

    /**
     * @param BoardingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(BoardingRequest $request)
    {

        $device = $this->deviceService->findByUniqid($request->device_uniqid);

        // Token validation
        if (Auth::user()->required_validation) {

            if ($request->token_validation == "") {
                return response()->json(['status' => 'validation_error', 'errors' => ["Informe o código autenticador"]], 401);
                die;
            }

            $validation = $this->apiUserService->tokenValidation(Auth::user()->validation_token, $request->token_validation);

            if ($validation['return'] == "FAILED") {
                return response()->json(['status' => 'validation_error', 'errors' => ["O código autenticador inválido"]], 401);
                die;
            }
        }

        $in_use = $this->boardingService->getCurrentBoardingByDevice($device->model);

        if ($in_use) {
            return response()->json(['status' => 'validation_error', 'errors' => "Dispositivo utilizado!"], 404);
        }

        try {
            $request->merge([
                'device_id' => $device->id,
                'user_id' => Auth::user()->id,
                'customer_id' => Auth::user()->customer_id,
                'active' => 1
            ]);
            if (isset($request->duration)) {
                $request->merge([
                    'finished_at' => date('Y-m-d H:i:s', strtotime("+{$request->duration} hour", strtotime(date('Y-m-d H:i:s'))))
                ]);
            }
            $this->boardingService->save($request);
            saveLog(['value' => $device->model, 'type' => 'Novo_embarque', 'local' => 'BoardingController', 'funcao' => 'save']);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(Int $id)
    {

        try {
            $this->boardingService->finish($id);

            saveLog(['value' => $id, 'type' => 'Encerrou embarque', 'local' => 'BoardingController', 'funcao' => 'finish']);
            return response()->json(['status' => 'success'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param String $model
     * @return mixed
     */
    public function testDevice(String $model)
    {

        $device = $this->deviceService->findByModel($model);

        $in_use = $this->boardingService->getCurrentBoardingByDevice($model);

        if ($in_use) {
            return ['message' => 'Dispositivo encontrado, porém esta sendo utilizado no embarque nº ' . $in_use->id . ', informe outro dispositivo ou encerre o embarque anterior.'];
        }

        $return['status'] = $device['status'];
        if ($device['status'] == 'success') {

            $return['device_type'] = $device['data']->technologie;
            $return['model'] = $device['data']->model;
            $return['device_id'] = $device['data']->id;
            $return['contract_id'] = $device['data']->contract_id;
            $return['uniqid'] = $device['data']->uniqid;

            $test_device = $this->apiDeviceServic->getLastPosition($model);
            //$test_device = $this->apiDeviceServic->testDevice($model);

            if ($test_device['status'] == "sucesso") {
                $return['last_transmission'] = $test_device['body'][0]['Data_GPS'];
                //$return['battery_level'] = $test_device['body'][0]['Tensão'];
                //$return['battery_level'] = $this->getStatus($test_device['body'][0]['Tensão'], $test_device['body'][0]['Data_GPS'], $this->save['device_id']);
                $return['battery_level'] = $this->getStatus($test_device['body'][0]['Tensão'], $test_device['body'][0]['Data_Rec']);
                //dd($data);
            } else {
                $return['last_transmission'] = '';
                $return['battery_level'] = '';
            }
        } else {

            $return['message'] = $device['message'];
        }

        return $return;
    }
    //usar data_rec

    public function getStatus($bateriaReal, $dt_posicao)
    {
        $user = Auth::user()->id;
        $dt_embarque = $this->boardingService->dtBoarding();
        $date_embarque = $this->formatDate($dt_embarque->created_at);
        $dif = abs(strtotime($dt_embarque) - strtotime($dt_posicao)) / (60 * 60);
        $x = ($dif * 0.50);
        $y = 100 - $x;

        preg_match('/@(.*)/', Auth::user()->email, $out);
        if ($out[1] == 'satcompany.com.br') {
            return 'R: ' . $bateriaReal . ' | P: ' . $y . '%';
        } else {
            return 100 - $x . '%';
        }
    }

    public function formatDate($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i:s');
    }


    /**
     * @param Int $id
     * @return \Illuminate\Http\Response
     */
    public function view(Int $id)
    {

        $data = $this->data;
        $data['boarding'] = $this->boardingService->show($id);

        return response()->view('boardings.view', $data);
    }

    /**
     * @return array
     */
    public function tokenValidation(String $token)
    {

        return $this->apiUserService->tokenValidation(Auth::user()->validation_token, $token);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function addTime(Request $request)
    {
        $boarding = $this->boardingService->getCurrentBoardingByDevice($request->device);
        if ($boarding) {
            $carbon = Carbon::parse($boarding->finished_at);
            return $this->boardingService->update(
                new Request(['finished_at' => $carbon->addHour($request->hours)->format('Y-m-d H:i:s')]),
                $boarding->id
            );
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function saveHistory(Request $request)
    {


        try {
            $this->serviceHistoryService->saveHistory($request);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @return array
     */
    public function showDevice(String $device_number)
    {
        $data = $this->data;
        $deviceId = $this->serviceHistoryService->showDevice($device_number);
        $data['devices'] = $this->serviceHistoryService->showByCustomerId($deviceId->id);

        return view('boardings.serviceHistory.list', $data);
    }
}
