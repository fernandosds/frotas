<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoCercaService;
use Illuminate\Http\Request;

class GrupoCercaController extends Controller
{


    /**
     * FleetController constructor.
     */
    public function __construct(GrupoCercaService $grupocercaService)
    {
        $this->grupocercaService = $grupocercaService;
    }

    public function index()
    {
        return view('fleetslarge.cercas.list');
    }

    public function new()
    {
        $data['cars'] = $this->grupocercaService->getPlate();
        // var_dump($data['cars']);die();

        return view('fleetslarge.cercas.new', $data);
    }

    public function save(Request $request)
    {

        var_dump($request->all());
        die();

        // $data['cars'] = $this->grupocercaService->getPlate();
        // return view('fleetslarge.cercas.new', $data);
    }
}
