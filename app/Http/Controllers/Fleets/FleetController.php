<?php

namespace App\Http\Controllers\Fleets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FleetController extends Controller
{

    /**
     * FleetController constructor.
     */
    public function __construct()
    {
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

        $data = $this->data;

        return response()->view('fleets.dashboard', $data);
    }


}
