<?php

namespace App\Http\Controllers\FleetsLarge;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapMarkersRequest;
use App\Http\Requests\MapMarkersDeleteRequest;
use App\Services\MapMarkersSantanderService;
use App\Services\ApiFleetLargeSantanderService;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\LogService;

class MapMarkersSantanderController extends Controller
{

    private $mapMarkersSantanderService;
    private $logService;
    private $grupocercaService;

    public function __construct(GrupoCercaService $grupocercaService, MapMarkersSantanderService $mapMarkersSantanderService, LogService $logService, ApiFleetLargeSantanderService $apiFleetLargeSantanderService)
    {
        $this->grupocercaService = $grupocercaService;
        $this->mapMarkersSantanderService = $mapMarkersSantanderService;
        $this->logService = $logService;
        $this->apiFleetLargeSantanderService = $apiFleetLargeSantanderService;
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

    public function getGrupoRelacionamento(Request $request)
    {
        try {
            if (empty($request->grupo))
                return array();

            $placas = array();
            $collectionObject = $this->grupocercaService->getAllGrupoCercaSantanderParameters($request->grupo);
            $result = $this->apiFleetLargeSantanderService->groupSelected($collectionObject);
            // foreach ($resultsGrupo as $resultGrupo) {
            //     foreach ($resultGrupo->grupoCercaRelacionamento as $grupoCercaRelacionamento) {
            //         $placa = $this->grupocercaService->findByChassi($grupoCercaRelacionamento->chassis);
            //         $placas[] = $placa->placa;
            //     }
            // }
            return response()->json(['status' => 'success', 'data' =>  $result], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }

    public function getAllGrupo()
    {
        try {
            $placas = array();
            $resultsGrupo = $this->grupocercaService->getGrupoCercaSantander();
            foreach ($resultsGrupo as $resultGrupo) {
                foreach ($resultGrupo->grupoCercaRelacionamento as $grupoCercaRelacionamento) {
                    $placa = $this->grupocercaService->findByChassi($grupoCercaRelacionamento->chassis);
                    $placas[] = $placa->placa;
                }
            }
            return response()->json(['status' => 'success', 'data' =>  $placas], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }


    public function allGrupoT()
    {
        try {
            $fleetslargeSantander = $this->grupocercaService->allGroup(); 
            // dd($fleetslargeSantander);
            return response()->json(['status' => 'success', 'data' =>  $fleetslargeSantander], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
