<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Services\ContractDeviceService;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Print_;

class LogisticController extends Controller
{
    private $contractService;
    private $deviceService;
    private $contractDeviceService;
    private $data;

    public function __construct(ContractService $contractService, ContractDeviceService $contractDeviceService, DeviceService $deviceService)
    {
        $this->contractService = $contractService;
        $this->contractDeviceService = $contractDeviceService;
        $this->deviceService = $deviceService;

        $this->data = [
            'icon' => 'file-text',
            'title' => 'Contratos',
            'menu_open_logistics' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $customer_id = Auth::user()->customer_id;

        $data = $this->data;
        $data['logistics'] = $this->contractService->paginate();

        return response()->view('logistic.list', $data);
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contractCompleted()
    {

        $data = $this->data;
        $data['logistics'] = $this->contractService->paginate();

        return response()->view('logistic.list_completed', $data);
    }



    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['contract'] = $this->contractService->show($id);

        return view('logistic.new', $data);
    }

    /**
     * @param Int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        try {



            $checkStatus =  $this->contractDeviceService->checkStatusContractDevice($request->id);

            if ($checkStatus > 0) {
                return response()->json(['status' => 'error', 'message' => 'É necessário vincular os dispositivos antes de confirmar.'], 200);
            }
            $this->contractService->update($request, $request->id);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachDevices(Int $id)
    {

        try {

            $contract_devices = $this->contractDeviceService->show($id);

            $attach_devices = $this->deviceService->attachDevices($id, $contract_devices);

            if ($attach_devices['status'] == 'success') {
                $this->contractDeviceService->setAttachStatus($id);
            } else {
                return response()->json($attach_devices, 200);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
