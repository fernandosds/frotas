<?php

namespace App\Http\Controllers\Iscas\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Iscas\ContractService;
use App\Services\Iscas\ContractDeviceService;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Print_;

class LogisticController extends Controller
{
    private $contractService;
    private $deviceService;
    private $contractDeviceService;
    private $data;

    /**
     * LogisticController constructor.
     * @param ContractService $contractService
     * @param ContractDeviceService $contractDeviceService
     * @param DeviceService $deviceService
     */
    public function __construct(ContractService $contractService, ContractDeviceService $contractDeviceService, DeviceService $deviceService)
    {
        $this->contractService = $contractService;
        $this->contractDeviceService = $contractDeviceService;
        $this->deviceService = $deviceService;

        $this->data = [
            'icon' => 'file-text',
            'title' => 'Logística > Contratos',
            'menu_open_logistics' => 'kt-menu__item--open'
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = $this->data;
        $data['logistics'] = $this->contractService->paginatePendentes();

        return response()->view('logistic.list', $data);
    
    }

}
