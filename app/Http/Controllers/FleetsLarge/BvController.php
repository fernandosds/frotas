<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\BvService;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BvController extends Controller
{

    /**
     * FleetController constructor.
     */
    public function __construct(BvService $bv)
    {
        $this->bvService = $bv;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function findByChassi()
    {
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];

        try {
            $data = $this->bvService->findByChassi($chassis);

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
