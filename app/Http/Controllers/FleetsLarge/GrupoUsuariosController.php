<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoUsuariosService;
use App\Services\UserService;
use Illuminate\Http\Request;

class GrupoUsuariosController extends Controller
{


    public function __construct(GrupoUsuariosService $grupousuariosService, UserService $userService)
    {
        $this->grupousuariosService = $grupousuariosService;
        $this->userService = $userService;
    }

    public function index()
    {
        return view('fleetslarge.cercas.grupo_usuario.list');
    }

    public function new()
    {
        $data['users'] = $this->userService->paginate();
        return view('fleetslarge.cercas.grupo_usuario.new', $data);
    }
}
