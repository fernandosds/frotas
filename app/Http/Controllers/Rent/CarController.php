<?php

namespace App\Http\Controllers\Rent;
use App\Services\Rent\CarService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $carService;
    private $data;
    

    /**
     * UserController constructor.
     * @param CarService $carService
     * 
     */
    public function __construct(CarService $carService)
    {
        $this->carService = $carService;

        $this->data = [
            'icon' => 'flaticon-truck',
            'title' => 'Lista de carros',
            'menu_open_cars' => 'kt-menu__item--open'
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
        $data['cars'] = $this->carService->paginate();

        return response()->view('rent.car.list', $data);
    }
}
