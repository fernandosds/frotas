<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Http\Requests\MapMarkersRequest;
use App\Http\Requests\MapMarkersDeleteRequest;
use App\Services\MapMarkersSantanderService;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;


class MapMarkersSantanderController extends Controller
{

    private $mapMarkersSantanderService;
    private $logService;

    public function __construct(MapMarkersSantanderService $mapMarkersSantanderService, LogService $logService)
    {
        $this->mapMarkersSantanderService = $mapMarkersSantanderService;
        $this->logService = $logService;
    }


    public function index()
    {
        $this->logService->saveLog(strval(Auth::user()->name), 'Mapa Monitoramento Cercas: Acessou o Mapa de monitoramento de Cercas ');
        return view('fleetslarge.monitoring.allcarsSantander');
    }

    public function save(MapMarkersRequest $request)
    {
        try {
            $json = $request->json()->all();
            $result = $this->mapMarkersSantanderService->save($json['data']);
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 201);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }
    public function delete(MapMarkersDeleteRequest $request)
    {
        try {
            $json = $request->json()->all();
            $result = $this->mapMarkersSantanderService->delete($json['data']['id'], $json['data']['name']);
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 202);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }


    public function getList()
    {
        try {
            $result = $this->mapMarkersSantanderService->getList();
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->mapMarkersSantanderService->getMarker($id);
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
