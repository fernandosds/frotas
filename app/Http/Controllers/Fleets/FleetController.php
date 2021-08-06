<?php

namespace App\Http\Controllers\Fleets;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetController extends Controller
{

    /**
     * FleetController constructor.
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;

        $this->data = [
            'icon' => 'flaticon-truck',
            'title' => 'Dashboard',
            'menu_open_fleets_dashbaord' => 'kt-menu__item--open'
        ];
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {

        $hash = $this->customerService->show(Auth::user()->customer_id);

        $data = $this->data;
        $data['hash'] = $hash->hash;
        return response()->view('fleets.dashboard', $data);
    }
}
