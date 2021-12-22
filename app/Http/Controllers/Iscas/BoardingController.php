<?php

namespace App\Http\Controllers\Iscas;

use App\Http\Controllers\Controller;
use App\Http\Requests\BoardingRequest;
use App\Services\ApiDeviceService;
use App\Services\ApiUserService;
use App\Services\Iscas\BoardingService;
use App\Services\CustomerService;
use App\Services\DeviceService;
use App\Services\Iscas\ServiceHistoryService;
use App\Services\Iscas\TypeOfLoadService;
use App\Services\Iscas\AccommodationLocationsService;
use App\Services\Iscas\TrackerService;
use App\Http\Controllers\Iscas\TrackerController;
use Carbon\Carbon;
use DateTime;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use PhpParser\Node\Expr\Print_;

class BoardingController extends Controller
{

    /**
     * @var TrackerController
     */
    private $trackerController;

    /**
     * @var BoardingService
     */
    private $boardingService;

    /**
     * @var CustomerService
     */
    private $customerService;

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
     * @var FunctionController
     */
    private $functionController;

    /**
     * @var AccommodationLocationsService
     */
    private $accommodationLocationsService;

    /**
     * @var TrackerService
     */
    private $trackerService;

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
     * @param TrackerService $trackerService
     * @param CustomerService $customerService
     * @param ApiUserService $apiUserService
     * @param ServiceHistoryService $serviceHistoryService
     * @param FunctionController $functionController
     */
    public function __construct(
        TrackerController $trackerController,
        BoardingService $boardingService,
        DeviceService $deviceService,
        ApiDeviceService $apiDeviceServic,
        TypeOfLoadService $typeOfLoadService,
        AccommodationLocationsService $accommodationLocationsService,
        TrackerService $trackerService,
        CustomerService $customerService,
        ApiUserService $apiUserService,
        ServiceHistoryService $serviceHistoryService,
        FunctionController $functionController
    ) {
        $this->trackerController = $trackerController;
        $this->boardingService = $boardingService;
        $this->deviceService = $deviceService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->typeOfLoadService = $typeOfLoadService;
        $this->accommodationLocationsService = $accommodationLocationsService;
        $this->trackerService = $trackerService;
        $this->customerService = $customerService;
        $this->apiUserService = $apiUserService;
        $this->serviceHistoryService = $serviceHistoryService;
        $this->functionController = $functionController;

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
    public function index(Request $request)
    {
        $data = $this->data;
        $data['boardings'] = $this->boardingService->getAllActive($request->customer_id);
        $data['customers'] = $this->customerService->getAllCustomerDevice();

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

        if ($request->attatch_device == 'movel' && $request->pair_device) {
            $tracker = $this->trackerService->findTrackerByModel($request->pair_device);

            if (isset($tracker->status) == 'indisponivel') {
                return response()->json(['status' => 'validation_error', 'errors' => "Este dispositivo está em uso!"], 404);
            }

            if (!$tracker) {
                return response()->json(['status' => 'validation_error', 'errors' => "Código do dispositivo inválido."], 404);
            }

            $this->trackerService->updateStatusTracker($tracker->model);
        }
        $this->deviceService->updateStatusDevice($device);

        $in_use = $this->boardingService->getCurrentBoardingByDevice($device->model);

        if ($in_use) {
            return response()->json(['status' => 'validation_error', 'errors' => "Dispositivo utilizado!"], 404);
        }

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
            $boarding = $this->boardingService->show($id);
            if ($boarding['attatch_device'] == 'movel') {
                $this->trackerService->updateStatusTracker($boarding['pair_device']);
            }
            $this->boardingService->finish($id);
            saveLog(['value' => $id, 'type' => 'Encerrou embarque', 'local' => 'BoardingController', 'funcao' => 'finish']);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
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

            if ($test_device['status'] == "sucesso") {
                $return['last_transmission'] = $test_device['body'][0]['Data_GPS'];
                $return['battery_level'] = $this->functionController->getStatus($test_device['body'][0]['Tensão'], $test_device['body'][0]['Data_Rec'], Carbon::now());
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
