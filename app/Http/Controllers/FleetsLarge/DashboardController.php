<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\FleetLargeMovidaService;
use App\Services\FleetLargeSantanderService;
use App\Services\ApiDeviceService;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Print_;

class DashboardController extends Controller
{

    private $fleetLargeSantanderService;

    private $fleetLargeMovidaService;

    /**
     * @var $apiFleetLargeService
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
    public function __construct(ApiFleetLargeService $apiFleetLargeService, FleetLargeMovidaService $fleetLargeMovidaService, FleetLargeSantanderService $fleetLargeSantanderService, ApiDeviceService $apiDeviceServic, CustomerService $customerService)
    {
        $this->apiFleetLargeService = $apiFleetLargeService;
        $this->fleetLargeMovidaService = $fleetLargeMovidaService;
        $this->fleetLargeSantanderService = $fleetLargeSantanderService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->customerService = $customerService;

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
        $customer = $this->customerService->show(Auth::user()->customer_id);
        if (empty($customer->hash)) {
            return redirect('access_denied');
        }

        // Entrar no dashboard Movida
        if (Auth::user()->customer_id == 7) {
            $data['fleetslarge'] = $this->fleetLargeMovidaService->allCars($customer->hash);
            $data['totalJson'] = count($data['fleetslarge']);
            return response()->view('fleetslarge.dashboard.movida', $data);
        }
        // Entrar no dashboard Santander
        if (Auth::user()->customer_id == 8) {
            $data['fleetslarge'] = $this->apiFleetLargeService->allCars($customer->hash);

            $carros = [];

            foreach ($data['fleetslarge'] as $data => $dat) {
                $arr[] = $this->resultJson($dat);
                $carros = $arr;
            }
            return response()->view('fleetslarge.dashboard.santander', compact('carros'));
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findByChassi()
    {
        $customer = $this->customerService->show(Auth::user()->customer_id);
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];

        try {

            $fleetslarge = $this->apiFleetLargeService->allCars($customer->hash);
            $arr[] = '';
            foreach ($fleetslarge as $data => $dat) {
                if ($chassis == $dat['chassis']) {
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
                        "t_acionamento_tecnico"     => $dat['t_acionamento_tecnico'] ?? '',
                        "dt_termino_instalacao"     => $dat['dt_termino_instalacao'] ?? '',
                        "dt_entrada"                => $dat['dt_entrada'] ?? '',
                        "t_solicitado_instalado"    => $dat['t_solicitado_instalado'] ?? '',
                        "t_inicio_servico"          => $dat['t_inicio_servico'] ?? '',
                        "dt_inicio_instalacao"      => $dat['dt_inicio_instalacao'] ?? '',
                        "dt_tecnico_acionado"       => $dat['dt_tecnico_acionado'] ?? '',
                        "t_instalacao"              => $dat['t_instalacao'] ?? '',
                    ]);
                }
            }
            saveLog(['value' => $chassis, 'type' => 'Verificou o chassi', 'local' => 'DashboardController', 'funcao' => 'findByChassi']);
            return response()->json(['stat' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['stat' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOcorrenceStatus()
    {
        $data['ocorrences'] = $this->fleetLargeMovidaService->getEventCar('c58de3ae-f519-4ec6-bd87-4e011c1cb2ea');

        $grid06 = [];

        foreach ($data['ocorrences'] as $data => $dat) {
            if (!is_null($dat['data_recuperacao'])) {
                $arr[] = $dat;
                $grid06 = $arr;
            }
        }

        try {
            return response()->json([
                'status' => 'success',
                'data' => [
                    "grid06"   => $grid06 ?? ''
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAllStatus()
    {
        $customer = $this->customerService->show(Auth::user()->customer_id);
        $data['fleetslarge'] = $this->apiFleetLargeService->allCars($customer->hash);
        $data['ocorrences'] = $this->fleetLargeMovidaService->getEventCar('c58de3ae-f519-4ec6-bd87-4e011c1cb2ea');

        try {
            if ($data['fleetslarge'][0]['empresa'] == 'Movida') {
                $empresa = 'Movida';

                $arr3 = $data['ocorrences'];
                $grid03 = $arr3;

                foreach ($data['fleetslarge'] as $data => $dat) {

                    if ($dat['sinistrado'] == "FALSE" && Carbon::parse($dat['lp_ultima_transmissao'])->diffInDays(Carbon::now()) < 8) {
                        $arr[] = $this->resultJson($dat);
                        $grid01 = $arr;
                    }

                    if ($dat['status_veiculo'] != "LOCACAO") {
                        $arr2[] = $this->resultJson($dat);
                        $grid02 = $arr2;
                    }

                    if (Carbon::parse($dat['lp_ultima_transmissao'])->diffInDays(Carbon::now()) > 7) {
                        $arr4[] = $this->resultJson($dat);
                        $grid04 = $arr4;
                    }

                    if ($dat['status_veiculo'] == "AVARIA") {
                        $arr5[] = $this->resultJson($dat);
                        $grid05 = $arr5;
                    }
                }
            }

            if ($data['fleetslarge'][0]['empresa'] == 'Santander') {
                $empresa = 'Santander';

                $customer = $this->customerService->show(Auth::user()->customer_id);

                $instalado = $this->apiFleetLargeService->allCars($customer->hash);
                foreach ($instalado as $data => $dat) {
                    if ($dat['situacao'] == "INSTALADO") {
                        $arr3[] = $this->resultJson($dat);
                        $grid03 = $arr3;
                    }
                }

                $mediaHora = $this->apiFleetLargeService->mediaHours();
                foreach ($mediaHora as $data => $dat) {
                    $grid05 = $dat['tempo_inicio_servico'];
                    $grid04 = $dat['tempo_solicitado_instalado'];
                    $grid02 = $dat['tempo_acionamento_tecnico'];
                    $grid01 =  $dat['tempo_instalacao'];
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    "empresa"  => $empresa ?? '',
                    "grid01"   => $grid01 ?? '',
                    "grid02"   => $grid02 ?? '',
                    "grid03"   => $grid03 ?? '',
                    "grid04"   => $grid04 ?? '',
                    "grid05"   => $grid05 ?? '',
                    "grid06"   => $grid06 ?? ''
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param CarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showEventPlaca($placa)
    {
        $data['ocorrences'] = $this->fleetLargeMovidaService->getEventCar('c58de3ae-f519-4ec6-bd87-4e011c1cb2ea');
        $events = [];
        foreach ($data['ocorrences'] as $data => $dat) {
            if ($dat['placa_veiculo'] == $placa) {
                $events[] = $dat;
            }
        }
        return response()->view('fleetslarge.dashboard.event_movida.list', compact('events'));
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    function resultJson($dat)
    {
        // $arr[]
        $arr = ([
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
            "placa_mercosul"            => $this->apiFleetLargeService->fixPlate($dat['placa']),
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
            "contrato"                  => $dat['contrato'] ?? '',
            "t_acionamento_tecnico"     => $dat['t_acionamento_tecnico'] ?? '',
            "dt_termino_instalacao"     => $dat['dt_termino_instalacao'] ?? '',
            "dt_entrada"                => $dat['dt_entrada'] ?? '',
            "t_solicitado_instalado"    => $dat['t_solicitado_instalado'] ?? '',
            "t_inicio_servico"          => $dat['t_inicio_servico'] ?? '',
            "dt_inicio_instalacao"      => $dat['dt_inicio_instalacao'] ?? '',
            "dt_tecnico_acionado"       => $dat['dt_tecnico_acionado'] ?? '',
            "t_instalacao"              => $dat['t_instalacao'] ?? '',
            "lp_velocidade"             => $dat['lp_velocidade'] ?? '',
            "situacao"                  => $dat['situacao'] ?? '',

        ]);
        return $arr;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function analyze()
    {
        $data = [
            'icon' => 'fa-car-alt',
            'title' => 'Grandes Frotas',
            'menu_open_fleetslarges_iframe' => 'kt-menu__item--open'
        ];

        // Iframe com os dados de instalação -- SANTANDER
        if (Route::currentRouteName() == 'fleetslarges.analyzeInstallation') {
            $data['hash'] = '519a68a7-1b0b-4f38-901c-d602a203a21e';
        }

        // Iframe com os dados do veículo -- SANTANDER
        if (Route::currentRouteName() == 'fleetslarges.analyzeCar') {
            $data['hash'] = 'd1c7e435-37ef-46aa-9105-4a2a957edc3e';
        }

        // Iframe com os dados da base -- SANTANDER
        if (Route::currentRouteName() == 'fleetslarges.analyzeBase') {
            $data['hash'] = 'ec4820de-0ecb-43f3-942e-532760810a85';
        }

        // Iframe com os dados da base -- MOVIDA
        if (Route::currentRouteName() == 'fleetslarges.analyzeFrota') {
            $data['hash'] = '71f1dfc6-4d1c-451a-aa52-47cfbd54cb33';
        }

        // Iframe com os Eventos -- MOVIDA
        if (Route::currentRouteName() == 'fleetslarges.analyzeEventos') {
            $data['hash'] = 'a139e839-e5d0-480c-b3cd-6a01d37b8927';
        }

        return response()->view('fleetslarge.iframe.dashboardSantander', $data);
    }
}
