<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\FleetLargeMovidaService;
use App\Services\ApiDeviceService;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use stdClass;

class MonitoringController extends Controller
{
    /**
     * @var $apiFleetLargeService
     * @var ApiFleetLargeService
     */
    private $apiFleetLargeService;

    /**
     * @var ApiDeviceService
     * @var CustomerService
     */
    private $apiDeviceServic;

    /**
     * BoardingController constructor.
     * @param DashboardController $apiFleetLargeService
     * @param ApiDeviceService $apiDeviceServic
     */
    public function __construct(ApiFleetLargeService $apiFleetLargeService, FleetLargeMovidaService $fleetLargeMovidaService, ApiDeviceService $apiDeviceServic, CustomerService $customerService)
    {
        $this->apiFleetLargeService = $apiFleetLargeService;
        $this->fleetLargeMovidaService = $fleetLargeMovidaService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->customerService = $customerService;

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
    public function movidaPosition()
    {
        $lojasMovida = $this->fleetLargeMovidaService->getLojaMovida();
        foreach ($lojasMovida as $data => $dat) {
            $arr = ([
                "operacao"                    => $dat['Tem Operacao?'],
                "lp_longitude"                => substr($dat['Longitude'], 0, -4),
                "lp_latitude"                 => substr($dat['Latitude'], 0, -4),
                "sigla"                       => $dat['Sigla'],
                "complemento"                 => $dat['Complemento'],
                "status"                      => $dat['Status'],
                "cep"                         => $dat['CEP'],
                "endereco"                    => $dat['Endereço'],
                "uf"                          => $dat['UF'],
                "numero"                      => $dat['Número'],
                "horario_atendimento"         => $dat['Horário de Atendimento'],
                "_id"                         => $dat['_id'],
                "bairro"                      => $dat['Bairro'],
                "tipo_filial"                 => $dat['Tipo Filial'],
                "regiao"                      => $dat['Região'],
                "loja"                        => $dat['Loja'],
                "mapa"                        => $dat['Mapa'],
                "cidade"                      => $dat['Cidade'],
                "referencias"                 => $dat['Referencias'],
            ]);
            $lojaMovida[] = $arr;
        }

        return response()->json([
            'status' => 'success',
            'data' =>  $lojaMovida
        ], 200);
    }


    /**
     * @param String $device
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function lastPosition(String $chassi)
    {
        $customer = $this->customerService->show(Auth::user()->customer_id);

        $fleetslarge = $this->apiFleetLargeService->allCars($customer->hash);
        $veiculo[] = '';
        foreach ($fleetslarge as $data => $dat) {
            if ($chassi == $dat['chassis']) {
                return  $arr = ([
                    "lp_satelite"               => $dat['lp_satelite'] ?? '',
                    "lp_ignicao"                => $dat['lp_ignicao'] ?? '',
                    "dif_date"                  => $dat['dif_date'] ?? '',
                    "status_veiculo"            => $dat['status_veiculo'] ?? '',
                    "lp_voltagem"               => $dat['lp_voltagem'] ?? '',
                    "sinistrado"                => $dat['sinistrado'] ?? '',
                    "filial"                    => $dat['filial'] ?? '',
                    "status_veiculo"            => $dat['status_veiculo'] ?? '',
                    "status_veiculo_dt"         => $dat['status_veiculo_dt'] ?? '',
                    "modelo_veiculo_aprimorado" => $dat['modelo_veiculo_aprimorado'] ?? '',
                    "placa"                     => $dat['placa'] ?? '',
                    "empresa"                   => $dat['empresa'] ?? '',
                    "r12s_proximos"             => $dat['r12s_proximos'] ?? '',
                    "dif_date"                  => $dat['dif_date'] ?? '',
                    "lp_longitude"              => $dat['lp_longitude'] ?? '',
                    "estado"                    => $dat['estado'] ?? '',
                    "lp_latitude"               => $dat['lp_latitude'] ?? '',
                    "telefone"                  => $dat['telefone'] ?? '',
                    "status"                    => $dat['status'] ?? '',
                    "iccid"                     => $dat['iccid'] ?? '',
                    "chassis"                   => $dat['chassis'] ?? '',
                    "modelo_veiculo"            => $dat['modelo_veiculo'] ?? '',
                    "qtd_dispositivos"          => $dat['qtd_dispositivos'] ?? '',
                    "categoria_veiculo"         => $dat['categoria_veiculo'] ?? '',
                    "cidade"                    => $dat['cidade'] ?? '',
                    "end_cidade"                => $dat['end_cidade'] ?? '',
                    "end_logradouro"            => $dat['end_logradouro'] ?? '',
                    "end_bairro"                => $dat['end_bairro'] ?? '',
                    "end_cep"                   => $dat['end_cep'] ?? '',
                    "end_uf"                    => $dat['end_uf'] ?? '',
                    "operadora"                 => $dat['operadora'] ?? '',
                    "cliente"                   => $dat['cliente'] ?? '',
                    "data_instalacao"           => $dat['data_instalacao'] ?? '',
                    "cod_empresa"               => $dat['cod_empresa'] ?? '',
                    "codigo_fipe"               => $dat['codigo_fipe'] ?? '',
                    "modelo"                    => $dat['modelo'] ?? '',
                    "point"                     => $dat['point'] ?? '',
                    "lp_ultima_transmissao"     => $dat['lp_ultima_transmissao'] ?? '',
                    "versao"                    => $dat['versao'] ?? '',
                    "cliente_foto"              => $dat['cliente_foto'] ?? '',
                    "cliente_cpf"               => $dat['cliente_cpf'] ?? '',
                    "cliente_nome"              => $dat['cliente_nome'] ?? '',
                    "cliente_datadev"           => $dat['cliente_datadev'] ?? '',
                    "cliente_celular"           => $dat['cliente_celular'] ?? '',
                    "cliente_localdev"          => $dat['cliente_localdev'] ?? '',
                    "cliente_local_retirada"    => $dat['cliente_local_retirada'] ?? '',
                    "cliente_contrato"          => $dat['cliente_contrato'] ?? '',
                    "cliente_dataretirada"      => $dat['cliente_dataretirada'] ?? '',
                    "cliente_email"             => $dat['cliente_email'] ?? '',
                    "cliente_endereco"          => $dat['cliente_endereco'] ?? '',
                    "cliente_foto_cnh"          => $dat['cliente_foto_cnh'] ?? '',
                    "cliente_cnh"               => $dat['cliente_cnh'] ?? '',
                    "veiculo_odometro"          => $dat['veiculo_odometro'] ?? '',
                    "lp_velocidade"             => $dat['lp_velocidade'] ?? '',
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

        if (in_array("Nenhum registro encontrado", $data['positions'])) {
            return response()->json(['status' => 'validation_error', 'errors' => "Nenhum registro encontrado."], 404);
        };

        if (Carbon::parse($request->last_date)->diffInDays(Carbon::parse($request->first_date)) > 31) {
            return response()->json(['status' => 'validation_error', 'errors' => "Período superior a 30 dias"], 404);
        };

        if ($request->first_date > $request->last_date) {
            return response()->json(['status' => 'validation_error', 'errors' => "Data invalida, data de inicio maior que a data final, ou diferença entre data superior a 5 dias"], 404);
        }

        return response()->view('fleetslarge.monitoring.list', $data);
    }

    //Dashboard de todos os carros

    public function events()
    {
        $fleetslarge = $this->apiFleetLargeService->events('3e808287-c81f-402e-b681-252e9a834d4a');
        return response()->json($fleetslarge, 200);
    }

    public function allCars()
    {
        // Entrar no Mapa todos os carros Movida
        if (Auth::user()->customer_id == 7) {
            return view('fleetslarge.monitoring.allcarsMovida');
        }

        // Entrar no Mapa todos os carros Santander
        if (Auth::user()->customer_id == 8) {
            return view('fleetslarge.monitoring.allcars');
        }
    }

    public function getGeoJson($filter)
    {
        $customer = $this->customerService->show(Auth::user()->customer_id);
        $fleetslarge = $this->apiFleetLargeService->allCarsDashboard($customer->hash, $filter);

        return response()->json($fleetslarge, 200);
    }

    public function carsPosition($ignition = '')
    {
        $filter = ['ignicao' => $ignition];
        return $this->getGeoJson($filter);
    }



    public function carsForDeliver($now = '')
    {
        $filter = [];
        if ($now === '0' || $now === '1') {
            $filter = ['cliente_datadev' => $now];
        }

        return $this->getGeoJson($filter);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resultJson($dat)
    {
        $arr[] = ([
            "lp_satelite"               => $dat['lp_satelite'] ?? '',
            "lp_ignicao"                => $dat['lp_ignicao'] ?? '',
            "dif_date"                  => $dat['dif_date'] ?? '',
            "status_veiculo"            => $dat['status_veiculo'] ?? '',
            "lp_voltagem"               => $dat['lp_voltagem'] ?? '',
            "sinistrado"                => $dat['sinistrado'] ?? '',
            "filial"                    => $dat['filial'] ?? '',
            "status_veiculo"            => $dat['status_veiculo'] ?? '',
            "status_veiculo_dt"         => $dat['status_veiculo_dt'] ?? '',
            "modelo_veiculo_aprimorado" => $dat['modelo_veiculo_aprimorado'] ?? '',
            "placa"                     => $dat['placa'] ?? '',
            "empresa"                   => $dat['empresa'] ?? '',
            "r12s_proximos"             => $dat['r12s_proximos'] ?? '',
            "dif_date"                  => $dat['dif_date'] ?? '',
            "lp_longitude"              => $dat['lp_longitude'] ?? '',
            "estado"                    => $dat['estado'] ?? '',
            "lp_latitude"               => $dat['lp_latitude'] ?? '',
            "telefone"                  => $dat['telefone'] ?? '',
            "status"                    => $dat['status'] ?? '',
            "iccid"                     => $dat['iccid'] ?? '',
            "chassis"                   => $dat['chassis'] ?? '',
            "modelo_veiculo"            => $dat['modelo_veiculo'] ?? '',
            "qtd_dispositivos"          => $dat['qtd_dispositivos'] ?? '',
            "categoria_veiculo"         => $dat['categoria_veiculo'] ?? '',
            "cidade"                    => $dat['cidade'] ?? '',
            "operadora"                 => $dat['operadora'] ?? '',
            "cliente"                   => $dat['cliente'] ?? '',
            "data_instalacao"           => $dat['data_instalacao'] ?? '',
            "cod_empresa"               => $dat['cod_empresa'] ?? '',
            "codigo_fipe"               => $dat['codigo_fipe'] ?? '',
            "modelo"                    => $dat['modelo'] ?? '',
            "point"                     => $dat['point'] ?? '',
            "lp_ultima_transmissao"     => $dat['lp_ultima_transmissao'] ?? '',
            "versao"                    => $dat['versao'] ?? '',
            "cliente_foto"              => $dat['cliente_foto'] ?? '',
            "cliente_cpf"               => $dat['cliente_cpf'] ?? '',
            "cliente_nome"              => $dat['cliente_nome'] ?? '',
            "cliente_datadev"           => $dat['cliente_datadev'] ?? '',
            "cliente_celular"           => $dat['cliente_celular'] ?? '',
            "cliente_localdev"          => $dat['cliente_localdev'] ?? '',
            "cliente_local_retirada"    => $dat['cliente_local_retirada'] ?? '',
            "cliente_contrato"          => $dat['cliente_contrato'] ?? '',
            "cliente_dataretirada"      => $dat['cliente_dataretirada'] ?? '',
            "cliente_email"             => $dat['cliente_email'] ?? '',
            "cliente_endereco"          => $dat['cliente_endereco'] ?? '',
            "cliente_foto_cnh"          => $dat['cliente_foto_cnh'] ?? '',
            "cliente_cnh"               => $dat['cliente_cnh'] ?? '',
            "t_acionamento_tecnico"     => $dat['t_acionamento_tecnico'] ?? '',
            "dt_termino_instalacao"     => $dat['dt_termino_instalacao'] ?? '',
            "dt_entrada"                => $dat['dt_entrada'] ?? '',
            "t_solicitado_instalado"    => $dat['t_solicitado_instalado'] ?? '',
            "t_inicio_servico"          => $dat['t_inicio_servico'] ?? '',
            "dt_inicio_instalacao"      => $dat['dt_inicio_instalacao'] ?? '',
            "dt_tecnico_acionado"       => $dat['dt_tecnico_acionado'] ?? '',
            "t_instalacao"              => $dat['t_instalacao'] ?? '',

        ]);
        return $arr;
    }
}
