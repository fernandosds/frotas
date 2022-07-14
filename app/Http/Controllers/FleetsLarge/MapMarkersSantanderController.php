<?php

namespace App\Http\Controllers\FleetsLarge;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapMarkersRequest;
use App\Http\Requests\MapMarkersDeleteRequest;
use App\Services\MapMarkersSantanderService;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\LogService;

class MapMarkersSantanderController extends Controller
{

    private $mapMarkersSantanderService;
    private $logService;
    private $grupocercaService;

    public function __construct(GrupoCercaService $grupocercaService, MapMarkersSantanderService $mapMarkersSantanderService, LogService $logService)
    {
        $this->grupocercaService = $grupocercaService;
        $this->mapMarkersSantanderService = $mapMarkersSantanderService;
        $this->logService = $logService;
    }


    public function index()
    {
        $data['grupos'] = $this->grupocercaService->allGroup();

        $this->logService->saveLog(strval(Auth::user()->name), 'Mapa Monitoramento Cercas: Acessou o Mapa de monitoramento de Cercas ');
        return view('fleetslarge.monitoring.allcarsSantander', $data);
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

    public function getGrupoRelacionamento(Request $request){
        if(empty($request->grupo))
            return array();
        
        $placas = array();
        $resultsGrupo = $this->grupocercaService->getGrupoCercaSantander($request->grupo);
        foreach($resultsGrupo as $resultGrupo){
            foreach($resultGrupo->grupoCercaRelacionamento as $grupoCercaRelacionamento){
                $placa = $this->grupocercaService->findByChassi($grupoCercaRelacionamento->chassis);
                $placas[] = $placa->placa;
                // foreach($grupoCercaRelacionamento as $cerca){
                //     dd($grupoCercaRelacionamento);
                //     dd($this->grupocercaService->findByChassi($cerca->chassis));
                // }
            }
        }
        return $placas;
    }
}
