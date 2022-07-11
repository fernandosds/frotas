<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\FleetsLarge\GrupoCercaRelacionamentoService;
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
    public function __construct(GrupoCercaService $grupocercaService, GrupoCercaRelacionamentoService $grupocercaRelacionamentoService)
    {
        $this->grupocercaService = $grupocercaService;
        $this->grupocercaRelacionamentoService = $grupocercaRelacionamentoService;
    }

    public function index()
    {
        $data['grupos'] = GrupoCerca::with('grupoCercaRelacionamento')->get();
        return view('fleetslarge.cercas.list', $data);
    }

    public function new(Request $request)
    {

        $data['cars'] = $this->grupocercaService->getPlate();
        if (!isset($request->id)) {
            return view('fleetslarge.cercas.new', $data);
        } else {

            $gruposCerca = GrupoCerca::with('grupoCercaRelacionamento')->where('id', $request->id)->first();
            $placas = $this->grupocercaService->getPlaceGroupAll($gruposCerca->grupoCercaRelacionamento);
            $data['grupo']  = $gruposCerca;
            $data['placas'] = $placas;
            return view('fleetslarge.cercas.new', $data);
        }
    }

    public function save(Request $request)
    {

        $placas = $request->placas;
        // dd(count($placas));

        if(count($placas) > 50){
            return response()->json(['status' => 'error', 'errors' => 'Não é permitido adicionar mais de 50 placas no grupo'], 400);
        }

        //SE ID GRUPO FOR NULL ENTÃO É CADASTRO
        if (is_null($request->id_grupo)) {
            $grupoCerca = new GrupoCerca();
            $grupoCerca->created_at = Carbon::now();
        } else {
            $grupoCerca = GrupoCerca::find($request->id_grupo);
            $grupoCerca->updated_at = Carbon::now();
        }

        $grupoCerca->nome       = $request->name;
        $grupoCerca->user_id    = Auth::user()->id;

        if ($grupoCerca->save()) {
            $arrGrupoCercaRelacionamento = [];
            $arrMontagem = [];
            if (!$placas) {
                return response()->json(['status' => 'error', 'errors' => 'Necessário adicionar uma placa para gravar o grupo de cerca'], 400);
            }
            foreach ($placas as $placa) {
                $car = BancoSantander::where('placa', $placa)->first();
                $arrMontagem[] = [
                    'grupo_id'      => $grupoCerca->id,
                    'chassis'       => $car->chassis,
                    'created_at'    => Carbon::now()
                ];
                $arrGrupoCercaRelacionamento[] = $arrMontagem;
            }
            if (is_null($request->id_grupo)) {
                $grupoRelacionamento  =  new GrupoCercaRelacionamento();
                return $grupoRelacionamento->insert($arrMontagem)
                    ? response()->json(['status' => 'success'], 200)
                    : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
            } else {
                if (GrupoCercaRelacionamento::where('grupo_id', $grupoCerca->id)->delete()) {
                    $grupoRelacionamento  =  new GrupoCercaRelacionamento();
                    return $grupoRelacionamento->insert($arrMontagem)
                        ? response()->json(['status' => 'success'], 200)
                        : response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
                }
            }
        }
    }

    public function destroy(Int $id)
    {
        return $this->grupocercaService->destroy($id);
    }
}
