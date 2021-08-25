<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\ApiDeviceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * @var $apiFleetLargeService
     */
    private $apiFleetLargeService;

    /**
     * @var ApiDeviceService
     */
    private $apiDeviceServic;

    /**
     * BoardingController constructor.
     * @param DashboardController $apiFleetLargeService
     * @param ApiDeviceService $apiDeviceServic
     */
    public function __construct(ApiFleetLargeService $apiFleetLargeService, ApiDeviceService $apiDeviceServic)
    {
        $this->apiFleetLargeService = $apiFleetLargeService;
        $this->apiDeviceServic = $apiDeviceServic;

        $this->data = [
            'icon' => 'fa-car-alt',
            'title' => 'Monitoramento Grandes Frotas',
            'menu_open_fleetslarges' => 'kt-menu__item--open'
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('fleetslarge.monitoring.index');
    }

    /**
     * @param String $device
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function lastPosition(String $chassi)
    {
        $fleetslarge = $this->apiFleetLargeService->allCars();
        $veiculo[] = '';
        foreach ($fleetslarge as $data => $dat) {
            if ($chassi == $dat['chassis']) {
                return  $arr = ([
                    "lp_satelite"               => $dat['lp_satelite'],
                    "lp_ignicao"                => $dat['lp_ignicao'],
                    "dif_date"                  => $dat['dif_date'],
                    "status_veiculo"            => $dat['status_veiculo'],
                    "lp_voltagem"               => $dat['lp_voltagem'],
                    "sinistrado"                => $dat['sinistrado'],
                    "filial"                    => $dat['filial'],
                    "status_veiculo"            => $dat['status_veiculo'],
                    "status_veiculo_dt"         => $dat['status_veiculo_dt'],
                    "modelo_veiculo_aprimorado" => $dat['modelo_veiculo_aprimorado'],
                    "placa"                     => $dat['placa'],
                    "empresa"                   => $dat['empresa'],
                    "r12s_proximos"             => $dat['r12s_proximos'],
                    "dif_date"                  => $dat['dif_date'],
                    "lp_longitude"              => $dat['lp_longitude'],
                    "estado"                    => $dat['estado'],
                    "lp_latitude"               => $dat['lp_latitude'],
                    "telefone"                  => $dat['telefone'],
                    "status"                    => $dat['status'],
                    "iccid"                     => $dat['iccid'],
                    "chassis"                   => $dat['chassis'],
                    "modelo_veiculo"            => $dat['modelo_veiculo'],
                    "qtd_dispositivos"          => $dat['qtd_dispositivos'],
                    "categoria_veiculo"         => $dat['categoria_veiculo'],
                    "cidade"                    => $dat['cidade'],
                    "end_cidade"                => $dat['end_cidade'],
                    "end_logradouro"            => $dat['end_logradouro'],
                    "end_bairro"                => $dat['end_bairro'],
                    "end_cep"                   => $dat['end_cep'],
                    "end_uf"                    => $dat['end_uf'],
                    "operadora"                 => $dat['operadora'],
                    "cliente"                   => $dat['cliente'],
                    "data_instalacao"           => $dat['data_instalacao'],
                    "cod_empresa"               => $dat['cod_empresa'],
                    "codigo_fipe"               => $dat['codigo_fipe'],
                    "modelo"                    => $dat['modelo'],
                    "point"                     => $dat['point'],
                    "lp_ultima_transmissao"     => $dat['lp_ultima_transmissao'],
                    "versao"                    => $dat['versao'],
                    "cliente_foto"              => $dat['cliente_foto'],
                    "cliente_cpf"               => $dat['cliente_cpf'],
                    "cliente_nome"              => $dat['cliente_nome'],
                    "cliente_datadev"           => $dat['cliente_datadev'],
                    "cliente_celular"           => $dat['cliente_celular'],
                    "cliente_localdev"          => $dat['cliente_localdev'],
                    "cliente_local_retirada"    => $dat['cliente_local_retirada'],
                    "cliente_contrato"          => $dat['cliente_contrato'],
                    "cliente_dataretirada"      => $dat['cliente_dataretirada'],
                    "cliente_email"             => $dat['cliente_email'],
                    "cliente_endereco"          => $dat['cliente_endereco'],
                    "cliente_foto_cnh"          => $dat['cliente_foto_cnh'],
                    "cliente_cnh"               => $dat['cliente_cnh'],
                    "veiculo_odometro"          => $dat['veiculo_odometro'],
                    "lp_velocidade"             => $dat['lp_velocidade'],
                ]);
                $veiculo = $arr;
            }
        }
        return response()->json(['status' => 'success'], 200);
    }
    /**
     * @param null $chassis
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function grid(Request $request)
    {
        $data['positions'] = $this->apiFleetLargeService->getGridModel($request->first_date, $request->last_date, $request->modelo);

        if (Carbon::parse($request->last_date)->diffInDays(Carbon::parse($request->first_date)) > 31) {
            return response()->json(['status' => 'validation_error', 'errors' => "Período superior a 30 dias"], 404);
        };

        if ($request->first_date > $request->last_date) {
            return response()->json(['status' => 'validation_error', 'errors' => "Data invalida, data de inicio maior que a data final, ou diferença entre data superior a 5 dias"], 404);
        }

        return response()->view('fleetslarge.monitoring.list', $data);
    }
}
