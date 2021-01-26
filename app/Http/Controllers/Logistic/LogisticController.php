<?php

namespace App\Http\Controllers\Logistic;

use App\Http\Controllers\Controller;
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

}
