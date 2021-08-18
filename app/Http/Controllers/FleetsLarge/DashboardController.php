<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->data = [
            'icon' => 'fa-car-alt',
            'title' => 'Grandes Frotas',
            'menu_open_fleetslarges' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['dataPoints'] = array(
            array("label"=>"Alugados", "y"=>1.7),
            array("label"=>"Manutenção", "y"=>26.6),
            array("label"=>"Disponível", "y"=>13.9),
            array("label"=>"Roubados", "y"=>7.8)
        );

        return response()->view('fleetslarge.dashboard.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Int $id)
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function save()
    {
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {
    }

    /**
     * @param CarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
    }
}
