<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Http\Requests\MapMarkersRequest;
use App\Services\MapMarkersService;

class MapMarkersController extends Controller
{

    private $mapMarkersService;

    public function __construct(MapMarkersService $mapMarkersService)
    {
        $this->mapMarkersService = $mapMarkersService;
    }

    public function save(MapMarkersRequest $request)
    {
        try {
            //$this->mapMarkersService->save($request->data->name, $request->data->markers);
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true], 201);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false], 400);
        }
    }
}
