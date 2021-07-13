<?php

namespace App\Http\Controllers\Iscas;

//use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//use App\Http\Requests\DeviceRequest;
use App\Services\DeviceService;

class StockController extends Controller
{

    private $deviceService;
    private $data;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;

        $this->data = [
            'icon' => 'flaticon-placeholder-3',
            'title' => 'Íscas',
            'menu_open_devices' => 'kt-menu__item--open'
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
        $data['devices'] = $this->deviceService->filter($customer_id);

        return response()->view('stock.list', $data);
    }
}
