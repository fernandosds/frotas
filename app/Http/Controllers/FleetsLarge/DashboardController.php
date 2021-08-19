<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;





class DashboardController extends Controller
{


    /**
     * @var $apiFleetLargeService
     */
    private $apiFleetLargeService;

    /**
     * BoardingController constructor.
     * @param DashboardController $apiFleetLargeService
     */
    public function __construct(ApiFleetLargeService $apiFleetLargeService)
    {
        $this->apiFleetLargeService = $apiFleetLargeService;

        $this->data = [
            'icon' => 'fa-car-alt',
            'title' => 'Grandes Frotas',
            'menu_open_fleetslarges' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['fleetslarge'] = $this->apiFleetLargeService->allCars();

        $data['totalJson'] = count($data['fleetslarge']);

        return response()->view('fleetslarge.dashboard.list', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findByChassi()
    {
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];

        try {

            $fleetslarge = $this->apiFleetLargeService->allCars();
            $arr[] = '';
            foreach ($fleetslarge as $data => $dat) {
                if ($chassis == $dat['chassis']) {
                    return  $arr = ([
                        "modelo_veiculo_aprimorado" => $dat['modelo_veiculo_aprimorado'],
                        "placa"                     => $dat['placa'],
                        "empresa"                   => $dat['empresa'],
                        "r12s_proximos"             => $dat['r12s_proximos'],
                        "dif_date"                  => $dat['dif_date'],
                        "longitude"                 => $dat['longitude'],
                        "estado"                    => $dat['estado'],
                        "latitude"                  => $dat['latitude'],
                        "telefone"                  => $dat['telefone'],
                        "status"                    => $dat['status'],
                        "iccid"                     => $dat['iccid'],
                        "chassis"                   => $dat['chassis'],
                        "modelo_veiculo"            => $dat['modelo_veiculo'],
                        "qtd_dispositivos"          => $dat['qtd_dispositivos'],
                        "categoria_veiculo"         => $dat['categoria_veiculo'],
                        "cidade"                    => $dat['cidade'],
                        "operadora"                 => $dat['operadora'],
                        "cliente"                   => $dat['cliente'],
                        "data_instalacao"           => $dat['data_instalacao'],
                        "cod_empresa"               => $dat['cod_empresa'],
                        "codigo_fipe"               => $dat['codigo_fipe'],
                        "modelo"                    => $dat['modelo'],
                        "point"                     => $dat['point'],
                        "ultima_transmissao"        => $dat['ultima_transmissao'],
                        "versao"                    => $dat['versao'],
                    ]);
                }
            }
            return response()->json(['stat' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['stat' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function save()
    {
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {
    }

    /**
     * @param CarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
    }
}
