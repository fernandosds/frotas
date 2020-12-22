<?php

namespace App\Http\Controllers;

use App\Services\ApiDeviceService;
use App\Services\BoardingService;
use App\Services\DeviceService;
use App\Services\TypeOfLoadService;
use App\Services\AccommodationLocationsService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardingController extends Controller
{

    /**
     * @var BoardingService
     */
    private $boardingService;
    
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var
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
     * BoardingController constructor.
     * @param BoardingService $boardingService
     * @param DeviceService $deviceService
     * @param ApiDeviceService $apiDeviceServic
     * @param TypeOfLoadService $typeOfLoadService
     * @param AccommodationLocationsService $accommodationLocationsService
     */
    public function __construct(BoardingService $boardingService, DeviceService $deviceService, ApiDeviceService $apiDeviceServic, TypeOfLoadService $typeOfLoadService, AccommodationLocationsService $accommodationLocationsService, UserService $userService)
    {
        $this->boardingService = $boardingService;
        $this->deviceService = $deviceService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->typeOfLoadService = $typeOfLoadService;
        $this->userService = $userService;
        $this->accommodationLocationsService = $accommodationLocationsService;

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
        $data['boardings'] = $this->boardingService->paginate();

        return response()->view('boardings.list', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        try {

            $this->boardingService->save($request);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, Request $request)
    {

        try {

            $this->boardingService->update($request, $request->id);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }


    /**
     * @return \Illuminate\Http\Response
     */
    public function new()
    {

        $data = $this->data;
        //$typeOfLoads = $this->typeOfLoadService->all();
        $data['accommodationlocations'] = $this->accommodationLocationsService->all();
        $data['typeofloads'] = $this->typeOfLoadService->all();
        $data['users'] = $this->userService->all();


        return response()->view('boardings.new', $data);
    }

    public function testDevice(Request $request)
    {
        $device = $this->deviceService->findByModel($request->device);

        $return['status'] = $device['status'];
        if ($device['status'] == 'success') {

            $return['device_type'] = $device['data']->device_type;
            $return['model'] = $device['data']->model;
            $return['device_id'] = $device['data']->id;

            $test_device = $this->apiDeviceServic->testDevice($request->device);

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
