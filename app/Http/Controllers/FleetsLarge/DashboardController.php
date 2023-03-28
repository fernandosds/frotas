<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\FleetLargeMovidaService;
use App\Services\FleetLargeMapfreService;
use App\Services\FleetLargeSompoService;
use App\Services\ApiDeviceService;
use App\Services\CustomerService;
use App\Services\LogService;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use stdClass;

// Conectando o fleetslarge através do banco
use App\Services\FleetsLarge\AlfaService;
use App\Services\FleetsLarge\PsaService;
use App\Services\FleetsLarge\BvService;
use App\Services\FleetsLarge\SantanderService;


class DashboardController extends Controller
{

    private $fleetLargeMapfreService;

    private $fleetLargeSompoService;

    private $fleetLargeMovidaService;

    private $fleetLargeAlfaService;

    private $fleetslargeDashboardService;

    private $logService;

    /**
     * @var $apiFleetLargeService
     */
    private $apiFleetLargeService;

    /**
     * @var ApiDeviceService
     * @var CustomerService
     * @var PsaService
     * @var LogService
     * @var SantanderService
     * @var BvService
     */
    private $apiDeviceServic;

    /**
     * BoardingController constructor.
     * @param DashboardController $apiFleetLargeService
     * @param ApiDeviceService $apiDeviceServic
     */
    public function __construct(
        ApiFleetLargeService $apiFleetLargeService,
        FleetLargeMovidaService $fleetLargeMovidaService,
        FleetLargeMapfreService $fleetLargeMapfreService,
        FleetLargeSompoService $fleetLargeSompoService,
        ApiDeviceService $apiDeviceServic,
        CustomerService $customerService,
        PsaService $psaService,
        LogService $logService,
        SantanderService $santanderService,
        BvService $bvService,
        AlfaService $alfaService

    ) {
        $this->apiFleetLargeService = $apiFleetLargeService;
        $this->fleetLargeMovidaService = $fleetLargeMovidaService;
        $this->fleetLargeMapfreService = $fleetLargeMapfreService;
        $this->fleetLargeSompoService = $fleetLargeSompoService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->customerService = $customerService;
        $this->psaService = $psaService;
        $this->logService = $logService;
        $this->santanderService = $santanderService;
        $this->bvService = $bvService;
        $this->alfaService = $alfaService;

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
    public function index(Request $request)
    {

        ini_set('memory_limit', '2048M');
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
            return response()->view('fleetslarge.dashboard.santander');
        }

        // Entrar no dashboard BV
        if (Auth::user()->customer_id == 15) {
            return response()->view('fleetslarge.dashboard.bv');
        }

        // Entrar no dashboard Alfa
        if (Auth::user()->customer_id == 16) {
            return response()->view('fleetslarge.dashboard.alfa');
        }
        


        // TESTE PARA O ITAU
        // Entrar no dashboard Itau
        if (Auth::user()->customer_id == 13) {

            $data['fleetslarge'] = $this->apiFleetLargeService->allCars($customer->hash);


            $carros = new stdClass();
            $jsonString = json_encode($data['fleetslarge']);
            $items = collect(json_decode($jsonString));

            foreach ($items as $item) {
                $item->placa_mercosul =  $this->apiFleetLargeService->fixPlate($item->placa);
            }
            $result = $items->all();
            $mediaHora = $this->apiFleetLargeService->mediaHours();
            $jsonString = json_encode($mediaHora);
            $items = collect(json_decode($jsonString));

            foreach ($items as $mh) {
                $inicioServico          = explode(".", $mh->tempo_inicio_servico);
                $acionamentoTecnico     = explode(".", $mh->tempo_acionamento_tecnico);
                $instalacao             = explode(".", $mh->tempo_instalacao);
                $solicitacao            = explode(".", $mh->tempo_solicitado_instalado);

                $ttlInicioServico       = $inicioServico[0];
                $ttlAcionamentoTecnico  = $acionamentoTecnico[0];
                $ttlInstalacao          = $instalacao[0];
                $ttlSolicInstalado      = $solicitacao[0];
            }
            $dashboardInstalado =  $this->situacaoInstalado($result);
            $instalado = $dashboardInstalado[0];
            $agendado = $dashboardInstalado[1];
            $total = $instalado + $agendado;
            $dataMin = $request->min;
            $dataMax = $request->max;

            $carros = $result;

            return response()->view(
                'fleetslarge.dashboard.itau',
                compact('carros', 'ttlInicioServico', 'ttlAcionamentoTecnico', 'ttlInstalacao', 'ttlSolicInstalado', 'instalado', 'agendado', 'total', 'dataMin', 'dataMax')
            );
        }

        // FIM DO TESTE ITAU

        // Entrar no dashboard Mapfre
        if (Auth::user()->customer_id == 11) {
            $data['fleetslarge'] = $this->fleetLargeMapfreService->allCars($customer->hash);

            $carros = [];

            foreach ($data['fleetslarge'] as $data => $dat) {
                $arr[] = $this->resultJsonSeguradora($dat);
                $carros = $arr;
            }
            return response()->view('fleetslarge.dashboard.mapfre', compact('carros'));
        }

        // Entrar no dashboard SOMPO
        if (Auth::user()->customer_id == 6) {
            $data['fleetslarge'] = $this->fleetLargeSompoService->allCars($customer->hash);

            $carros = [];

            foreach ($data['fleetslarge'] as $data => $dat) {
                $arr[] = $this->resultJsonSeguradora($dat);
                $carros = $arr;
            }
            return response()->view('fleetslarge.dashboard.sompo.sompo', compact('carros'));
        }

        // Entrar no dashboard banco PSA
        if (Auth::user()->customer_id == 14) {
            $data['carros'] = $this->psaService->all();
            return response()->view('fleetslarge.dashboard.bancopsa', $data);
        }

        // Entrar no dashboard banco BV
        if (Auth::user()->customer_id == 15) {
            $data['carros'] = $this->bvService->all();
            return response()->view('fleetslarge.dashboard.bv', $data);
        }

        // Entrar no dashboard Alfa
        if (Auth::user()->customer_id == 16) {
            $data['carros'] = $this->alfaService->all();
            return response()->view('fleetslarge.dashboard.alfa', $data);
        }
    }

    public function dataSantander()
    {
        ini_set('memory_limit', '-1');
        $data = $this->santanderService->all();
        return response()->json($data);
    }

    public function databv()
    {
        ini_set('memory_limit', '-1');
        $data = $this->bvService->all();
        return response()->json($data);
    }

    public function dataAlfa()
    {
        ini_set('memory_limit', '-1');
        $data = $this->alfaService->all();
        return response()->json($data);
    }
    public function situacaoInstalado($items)
    {

        $situacoesDeInstalado =  ['INSTALADO', 'OS ABERTA DE RETIRADA', 'RETIRADO'];
        $situacoesDeAgendado =  ['OS ABERTA DE INSTALAçãO', 'REAGENDAMENTO', 'VEICULO INDISPONIVEL'];

        $totalInstalado = 0;
        $totalAgendado = 0;
        foreach ($items as $data => $dat) {
            if (in_array($dat->situacao, $situacoesDeInstalado)) {
                $totalInstalado = $totalInstalado + 1;
            }
            if (in_array($dat->situacao, $situacoesDeAgendado)) {
                $totalAgendado = $totalAgendado + 1;
            }
        }
        return  [$totalInstalado, $totalAgendado];
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findByChassi()
    {
        $customer = $this->customerService->show(Auth::user()->customer_id);
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];

        $this->logService->saveLog(strval(Auth::user()->name), 'Dashboard: Verificou o registro do veículo chassi: ' . $chassis);
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

    public function findByChassiAlfa()
    {
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];
        $this->logService->saveLog(strval(Auth::user()->name), 'Dashboard: Verificou o registro do veículo chassi: ' . $chassis);
        try {
            $data = $this->alfaService->findByChassi($chassis);
            saveLog(['value' => $chassis, 'type' => 'Verificou o chassi', 'local' => 'DashboardController', 'funcao' => 'findByChassi']);
            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    public function findByChassiBv()
    {
        $chassis = Route::getCurrentRoute()->parameters()['chassis'];
        $this->logService->saveLog(strval(Auth::user()->name), 'Dashboard: Verificou o registro do veículo chassi: ' . $chassis);
        try {
            $data = $this->bvService->findByChassi($chassis);
            saveLog(['value' => $chassis, 'type' => 'Verificou o chassi', 'local' => 'DashboardController', 'funcao' => 'findByChassi']);
            return response()->json(['status' => 'success', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
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
            $this->logService->saveLog(strval(Auth::user()->name), 'Análise: Acessou a análise de instalações.');
            $data['hash'] = '519a68a7-1b0b-4f38-901c-d602a203a21e';
        }

        // Iframe com os dados do veículo -- SANTANDER
        if (Route::currentRouteName() == 'fleetslarges.analyzeCar') {
            $this->logService->saveLog(strval(Auth::user()->name), 'Análise: Acessou a análise de Veículos (Telemetria).');
            $data['hash'] = 'd1c7e435-37ef-46aa-9105-4a2a957edc3e';
        }

        // Iframe com os dados da base -- SANTANDER
        if (Route::currentRouteName() == 'fleetslarges.analyzeBase') {
            $this->logService->saveLog(strval(Auth::user()->name), 'Análise: Acessou a análise de Base.');
            $data['hash'] = 'ec4820de-0ecb-43f3-942e-532760810a85';
        }

        if (Route::currentRouteName() == 'fleetslarges.analyzeSla') {
            $this->logService->saveLog(strval(Auth::user()->name), 'Análise: Acessou o dashboard sla santander.');
            $data['hash'] = 'de49d52c-3c2b-4250-8ed5-2622c5c310c8';
        }

        // Iframe com os dados da base -- MOVIDA
        if (Route::currentRouteName() == 'fleetslarges.analyzeFrota') {
            $data['hash'] = '71f1dfc6-4d1c-451a-aa52-47cfbd54cb33';
        }

        // Iframe com os Eventos -- MOVIDA
        if (Route::currentRouteName() == 'fleetslarges.analyzeEventos') {
            $data['hash'] = 'a139e839-e5d0-480c-b3cd-6a01d37b8927';
        }

        // Iframe com os Eventos -- SOMPO
        if (Route::currentRouteName() == 'fleetslarges.analyzeFrotaSompo') {
            $data['hash'] = '277a22c0-5a64-46bc-93f1-832cfa7b46b9';
        }

        if (Route::currentRouteName() == 'fleetslarges.analyzeSlaPSA') {
            $this->logService->saveLog(strval(Auth::user()->name), 'Análise: Acessou o dashboard SLA Psa.');
            $data['hash'] = 'a4b01f55-2d8a-42f0-96af-64b10da9d187';
        }

        return response()->view('fleetslarge.iframe.dashboardSantander', $data);
    }


    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    function resultJsonSeguradora($dat)
    {
        $arr = ([
            "lp_satelite"               => $dat['lp_satelite'] ?? '',
            "placa"                     => $dat['placa'] ?? '',
            "placa_mercosul"            => $this->apiFleetLargeService->fixPlate($dat['placa']),
            "lp_ignicao"                => $dat['lp_ignicao'] ?? '',
            "empresa"                   => $dat['empresa'] ?? '',
            "estado"                    => $dat['estado'] ?? '',
            "tecnologia"                => $dat['tecnologia'] ?? '',
            "lp_longitude"              => $dat['lp_longitude'] ?? '',
            "BI_FIPE_TAB → modelo"      => $dat['BI_FIPE_TAB → modelo'] ?? '',
            "end_logradouro"            => $dat['end_logradouro'] ?? '',
            "status_veiculo_dt"         => $dat['status_veiculo_dt'] ?? '',
            "lp_voltagem"               => $dat['lp_voltagem'] ?? '',
            "end_bairro"                => $dat['end_bairro'] ?? '',
            "status"                    => $dat['status'] ?? '',
            "end_cep"                   => $dat['end_cep'] ?? '',
            "chassis"                   => $dat['chassis'] ?? '',
            "end_cidade"                => $dat['end_cidade'] ?? '',
            "qtd_dispositivos"          => $dat['qtd_dispositivos'] ?? '',
            "end_uf"                    => $dat['end_uf'] ?? '',
            "cidade"                    => $dat['cidade'] ?? '',
            "lp_ultima_transmissao"     => $dat['lp_ultima_transmissao'] ?? '',
            "cliente"                   => $dat['cliente'] ?? '',
            "data_instalacao"           => $dat['data_instalacao'] ?? '',
            "cod_empreesa"              => $dat['cod_empreesa'] ?? '',
            "lp_latitude"               => $dat['lp_latitude'] ?? '',
            "lp_velocidade"             => $dat['lp_velocidade'] ?? '',
            "modelo"                    => $dat['modelo'] ?? '',
            "versao"                    => $dat['versao'] ?? '',
            "BI_FIPE_TAB → tipo"        => $dat['BI_FIPE_TAB → tipo'] ?? '',
        ]);
        return $arr;
    }

    public function logTelemetria()
    {
        return  $this->logService->saveLog(strval(Auth::user()->name), 'Telemetria: Gerou relatório de Telemetria.');
    }
}
