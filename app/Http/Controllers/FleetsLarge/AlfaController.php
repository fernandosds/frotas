<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\AlfaService;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlfaController extends Controller
{

    /**
     * FleetController constructor.
     */
    public function __construct(AlfaService $alfa)
    {
        $this->alfaService = $alfa;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function findByChassi()
    {
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];

        try {
            $data = $this->alfaService->findByChassi($chassis);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
