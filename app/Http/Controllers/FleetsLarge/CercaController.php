<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\CercaService;
use Illuminate\Http\Request;

class CercaController extends Controller
{


    /**
     * FleetController constructor.
     */
    public function __construct(CercaService $cercaService)
    {
        $this->cercaService = $cercaService;
    }

    public function index()
    {
        return view('fleetslarge.cercas.lista');
    }

    public function new()
    {
        $data['cars'] = $this->cercaService->getPlate();
        var_dump($data['cars']);die();

        return view('fleetslarge.cercas.cerca');
    }
}
