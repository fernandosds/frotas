<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoUsuariosService;
use Illuminate\Http\Request;

class GrupoUsuariosController extends Controller
{


    public function __construct(GrupoUsuariosService $grupousuariosService)
    {
        $this->grupousuariosService = $grupousuariosService;
    }

    public function index()
    {
        return view('fleetslarge.cercas.listUsers');
    }
}
