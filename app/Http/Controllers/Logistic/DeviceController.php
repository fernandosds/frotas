<?php

namespace App\Http\Controllers\Logistic;

use App\Http\Controllers\Controller;
use App\Services\ContractDeviceService;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{

    private $contractService;
    private $contractDeviceService;
    private $data;

    public function __construct(DeviceService $deviceService, ContractDeviceService $contractDeviceService)
    {

        $this->deviceService = $deviceService;
        $this->contractDeviceService = $contractDeviceService;

        $this->data = [
            'icon' => 'file-text',
            'title' => 'Contratos',
            'menu_open_logistics' => 'kt-menu__item--open'
        ];
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

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filterByContractDevice(Int $id)
    {
        $contract_devices = $this->contractDeviceService->show($id);
        
        $data = $this->data;
        $data['devices'] = $this->deviceService->filterByContractDevice($contract_devices);
       
        return response()->view('logistic.contracts.device.device_registered_list', $data);
    }
}
