<?php

namespace App\Http\Controllers\Iscas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\DeviceService;
use App\Services\Iscas\TrackerService;

class StockController extends Controller
{

    private $deviceService;
    private $data;

    public function __construct(
        DeviceService $deviceService,
        TrackerService $trackerService
    ) {
        $this->deviceService = $deviceService;
        $this->trackerService = $trackerService;

        $this->data = [
            'icon' => 'flaticon-placeholder-3',
            'title' => 'Dispositivos',
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
        $data['trackers'] = $this->trackerService->filter($customer_id);

        return response()->view('stock.list', $data);
    }
}
