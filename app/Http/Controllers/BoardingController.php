<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardingRequest;
use App\Services\ApiDeviceService;
use App\Services\BoardingService;
use App\Services\DeviceService;
use App\Services\TypeOfLoadService;
use App\Services\AccommodationLocationsService;
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
     * BoardingController constructor.
     * @param BoardingService $boardingService
     * @param DeviceService $deviceService
     * @param ApiDeviceService $apiDeviceServic
     * @param TypeOfLoadService $typeOfLoadService
     * @param AccommodationLocationsService $accommodationLocationsService
     */
    public function __construct(BoardingService $boardingService, DeviceService $deviceService, ApiDeviceService $apiDeviceServic, TypeOfLoadService $typeOfLoadService, AccommodationLocationsService $accommodationLocationsService)
    {
        $this->boardingService = $boardingService;
        $this->deviceService = $deviceService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->typeOfLoadService = $typeOfLoadService;
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
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $data = $this->data;

        //$typeOfLoads = $this->typeOfLoadService->all();
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

        try {

            $request->merge([
                    'user_id' => Auth::user()->id,
                    'customer_id' => Auth::user()->customer_id,
                    'active' => 1
                ]);

            if(isset($request->duration)) {
                $request->merge([
                    'finished_at' => date('Y-m-d H:i:s', strtotime("+{$request->duration} hour", strtotime(date('Y-m-d H:i:s'))))
                ]);
            }

            $this->boardingService->save($request);

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

        try{
            $this->boardingService->finish($id);
            return response()->json(['status' => 'success'], 200);
        }catch (Exception $e){
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

        $return['status'] = $device['status'];
        if ($device['status'] == 'success') {

            $return['device_type'] = $device['data']->technologie;
            $return['model'] = $device['data']->model;
            $return['device_id'] = $device['data']->id;
            $return['contract_id'] = $device['data']->contract_id;

            $test_device = $this->apiDeviceServic->testDevice($model);

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
