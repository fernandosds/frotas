<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CercaController extends Controller
{
    public function index()
    {
        return view('fleetslarge.cercas.lista');
    }

    public function new()
    {

        return view('fleetslarge.cercas.cerca');
    }
}
