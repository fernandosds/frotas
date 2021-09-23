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
            $json = $request->json()->all();
            $result = $this->mapMarkersService->save($json['data']['name'], $json['data']['type'], $json['data']['markers']);
            //$result = [];
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 201);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function getList()
    {
        try {
            $result = $this->mapMarkersService->getList();
            //$result = [];
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->mapMarkersService->getMarker($id);
            //$result = [];
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
