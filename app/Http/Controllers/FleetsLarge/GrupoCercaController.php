<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Models\GrupoCerca;
use App\Models\GrupoCercaRelacionamento;
use App\Models\BancoSantander;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GrupoCercaController extends Controller
{

    /**
     * FleetController constructor.
     */
    public function __construct(GrupoCercaService $grupocercaService)
    {
        $this->grupocercaService = $grupocercaService;
    }

    public function index()
    {
        $grupos = GrupoCerca::all();
        return view('fleetslarge.cercas.list', $grupos);
    }

    public function new()
    {
        $data['cars'] = $this->grupocercaService->getPlate();

        return view('fleetslarge.cercas.new', $data);
    }

    public function save(Request $request)
    {
        $placas = $request->placas;

        $grupoCerca = new GrupoCerca();
        $grupoCerca->nome       = $request->name;
        $grupoCerca->user_id    = Auth::user()->id;
        $grupoCerca->created_at = Carbon::now();

        if($grupoCerca->save()){
            $arrGrupoCercaRelacionamento = [];
            foreach($placas as $placa){
                $car = BancoSantander::where('placa', $placa)->first();
                $arrMontagem = [
                    'grupo_id'      => $grupoCerca->id,
                    'chassis'        => $car->chassis,
                    'created_at'    => Carbon::now()
                ];

                $arrGrupoCercaRelacionamento[] = $arrMontagem;

                //COMENTAR ESSAS DUAS LINHAS
                $grupoRelacionamento  =  new GrupoCercaRelacionamento();
                $result = $grupoRelacionamento->insert($arrMontagem) ? true : false;
            }

            try {
                $this->grupocercaService->saveCercaGrupo($grupoCerca->id, $arrGrupoCercaRelacionamento);
                return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
            }
        }
    }
}