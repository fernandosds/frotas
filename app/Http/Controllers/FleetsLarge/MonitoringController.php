<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\FleetLargeMovidaService;
use App\Services\FleetsLarge\SantanderService;
use App\Services\FleetsLarge\AlfaService;
use App\Services\FleetsLarge\BvService;
use App\Services\ApiDeviceService;
use App\Services\CustomerService;
use App\Services\LogService;
use App\Services\FleetsLarge\PsaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Repositories\LogRepository;
use Carbon\Carbon;
use stdClass;

class MonitoringController extends Controller
{
    /**
     * @var $apiFleetLargeService
     * @var ApiFleetLargeService
     * @var SantanderService
     * @var AlfaService
     * @var BvService
     */
    private $apiFleetLargeService;
    private $santanderService;

    /**
     * @var ApiDeviceService
     * @var CustomerService
     * @var PsaService
     */
    private $apiDeviceServic;
    private $psaService;
    private $logService;
    private $alfaService;
    private $bvService;
    /**
     * BoardingController constructor.
     * @param DashboardController $apiFleetLargeService
     * @param ApiDeviceService $apiDeviceServic
     * @var LogService
     */
    public function __construct(
        ApiFleetLargeService $apiFleetLargeService,
        FleetLargeMovidaService $fleetLargeMovidaService,
        ApiDeviceService $apiDeviceServic,
        CustomerService $customerService,
        LogRepository $log,
        PsaService $psaService,
        LogService $logService,
        SantanderService $santanderService,
        AlfaService $alfaService,
        BvService $bvService
    ) {
        $this->apiFleetLargeService = $apiFleetLargeService;
        $this->fleetLargeMovidaService = $fleetLargeMovidaService;
        $this->apiDeviceServic = $apiDeviceServic;
        $this->customerService = $customerService;
        $this->log = $log;
        $this->psaService = $psaService;
        $this->logService = $logService;
        $this->santanderService = $santanderService;
        $this->alfaService = $alfaService;
        $this->bvService = $bvService;

        $this->data = [
            'icon' => 'fa-car-alt',
            'title' => 'Monitoramento Grandes Frotas',
            'menu_open_fleetslarges' => 'kt-menu__item--open'
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($chassi = 0)
    {
        if (Auth::user()->customer_id == 7) {
            $this->logService->saveLog(strval(Auth::user()->name), 'Dashboard: Acessou o monitoramento do veículo chassi: ' . $chassi);
            saveLog(['value' => $chassi, 'type' => 'Monitorou o veiculo', 'local' => 'MonitoringController', 'funcao' => 'index']);
            return view('fleetslarge.monitoring.index_movida', ['chassi' => $chassi]);
        }

        if (Auth::user()->customer_id == 8 || Auth::user()->customer_id == 13) {
            $this->logService->saveLog(strval(Auth::user()->name), 'Dashboard: Acessou o monitoramento do veículo chassi: ' . $chassi);
            saveLog(['value' => $chassi, 'type' => 'Monitorou o veiculo', 'local' => 'MonitoringController', 'funcao' => 'index']);
            return view('fleetslarge.monitoring.index', ['chassi' => $chassi]);
        }

        if (Auth::user()->customer_id == 14) {
            saveLog(['value' => $chassi, 'type' => 'Monitorou o veiculo', 'local' => 'MonitoringController', 'funcao' => 'index']);
            return view('fleetslarge.monitoring.index_banco_psa', ['chassi' => $chassi]);
        }
        if (Auth::user()->customer_id == 11) {
            saveLog(['value' => $chassi, 'type' => 'Monitorou o veiculo', 'local' => 'MonitoringController', 'funcao' => 'index']);
            return view('fleetslarge.monitoring.index_mapfre', ['chassi' => $chassi]);
        }
        if (Auth::user()->customer_id == 6) {
            saveLog(['value' => $chassi, 'type' => 'Monitorou o veiculo', 'local' => 'MonitoringController', 'funcao' => 'index']);
            return view('fleetslarge.monitoring.sompo.index', ['chassi' => $chassi]);
        }

        if (Auth::user()->customer_id == 16) {
            saveLog(['value' => $chassi, 'type' => 'Monitorou o veiculo', 'local' => 'MonitoringController', 'funcao' => 'index']);
            return view('fleetslarge.monitoring.index_alfa', ['chassi' => $chassi]);
        }
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
        $chassi = $this->santanderService->findByChassi($chassi);
        $endereco = $this->apiDeviceServic->getAddress($chassi->lp_latitude, $chassi->lp_longitude);

        $data = [
            "chassi" => $chassi->chassis,
            "categoria_veiculo" => $chassi->categoria_veiculo,
            "cidade" => $chassi->cidade,
            "end_bairro" => $chassi->end_bairro,
            "end_cep" => $chassi->end_cep,
            "end_cidade" => $chassi->end_cidade,
            "end_logradouro" => $chassi->end_logradouro,
            "end_uf" => $chassi->end_uf,
            "estado" => $chassi->estado,
            "iccid" => $chassi->iccid,
            "lp_ignicao" => $chassi->lp_ignicao,
            "lp_latitude" => $chassi->lp_latitude,
            "lp_longitude" => $chassi->lp_longitude,
            "data_instalacao" => $chassi->data_instalacao,
            "codigo_fipe" => $chassi->codigo_fipe,
            "cod_empresa" => $chassi->cod_empresa,
            "lp_ultima_transmissao" => $chassi->lp_ultima_transmissao,
            "lp_velocidade" => $chassi->lp_velocidade,
            "lp_voltagem" => $chassi->lp_voltagem,
            "modelo" => $chassi->modelo,
            "modelo_veiculo" => $chassi->modelo_veiculo,
            "operadora" => $chassi->operadora,
            "placa" => $chassi->placa,
            "qtd_dispositivos" => $chassi->qtd_dispositivos,
            "sinistrado" => $chassi->sinistrado,
            "status" => $chassi->status,
            "telefone" => $chassi->telefone,
            "versao" => $chassi->versao,
            "endereco" => $endereco,
        ];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function lastPositionAlfa(String $chassi)
    {
        $customer   = $this->customerService->show(Auth::user()->customer_id);
        $chassi     = $this->alfaService->findByChassi($chassi);
        $endereco   = $this->apiDeviceServic->getAddress($chassi->lp_latitude, $chassi->lp_longitude);

        $data = [
            "chassi" => $chassi->chassis,
            "categoria_veiculo" => $chassi->categoria_veiculo,
            "cidade" => $chassi->cidade,
            "end_bairro" => $chassi->end_bairro,
            "end_cep" => $chassi->end_cep,
            "end_cidade" => $chassi->end_cidade,
            "end_logradouro" => $chassi->end_logradouro,
            "end_uf" => $chassi->end_uf,
            "estado" => $chassi->estado,
            "iccid" => $chassi->iccid,
            "lp_ignicao" => $chassi->lp_ignicao,
            "lp_latitude" => $chassi->lp_latitude,
            "lp_longitude" => $chassi->lp_longitude,
            "data_instalacao" => $chassi->data_instalacao,
            "codigo_fipe" => $chassi->codigo_fipe,
            "cod_empresa" => $chassi->cod_empresa,
            "lp_ultima_transmissao" => $chassi->lp_ultima_transmissao,
            "lp_velocidade" => $chassi->lp_velocidade,
            "lp_voltagem" => $chassi->lp_voltagem,
            "modelo" => $chassi->modelo,
            "modelo_veiculo" => $chassi->modelo_veiculo,
            "operadora" => $chassi->operadora,
            "placa" => $chassi->placa,
            "qtd_dispositivos" => $chassi->qtd_dispositivos,
            "sinistrado" => $chassi->sinistrado,
            "status" => $chassi->status,
            "telefone" => $chassi->telefone,
            "versao" => $chassi->versao,
            "endereco" => $endereco,
        ];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function lastPositionBv(String $chassi)
    {
        $customer   = $this->customerService->show(Auth::user()->customer_id);
        $chassi     = $this->bvService->findByChassi($chassi);
        $endereco   = $this->apiDeviceServic->getAddress($chassi->lp_latitude, $chassi->lp_longitude);

        $data = [
            "chassi" => $chassi->chassis,
            "categoria_veiculo" => $chassi->categoria_veiculo,
            "cidade" => $chassi->cidade,
            "end_bairro" => $chassi->end_bairro,
            "end_cep" => $chassi->end_cep,
            "end_cidade" => $chassi->end_cidade,
            "end_logradouro" => $chassi->end_logradouro,
            "end_uf" => $chassi->end_uf,
            "estado" => $chassi->estado,
            "iccid" => $chassi->iccid,
            "lp_ignicao" => $chassi->lp_ignicao,
            "lp_latitude" => $chassi->lp_latitude,
            "lp_longitude" => $chassi->lp_longitude,
            "data_instalacao" => $chassi->data_instalacao,
            "codigo_fipe" => $chassi->codigo_fipe,
            "cod_empresa" => $chassi->cod_empresa,
            "lp_ultima_transmissao" => $chassi->lp_ultima_transmissao,
            "lp_velocidade" => $chassi->lp_velocidade,
            "lp_voltagem" => $chassi->lp_voltagem,
            "modelo" => $chassi->modelo,
            "modelo_veiculo" => $chassi->modelo_veiculo,
            "operadora" => $chassi->operadora,
            "placa" => $chassi->placa,
            "qtd_dispositivos" => $chassi->qtd_dispositivos,
            "sinistrado" => $chassi->sinistrado,
            "status" => $chassi->status,
            "telefone" => $chassi->telefone,
            "versao" => $chassi->versao,
            "endereco" => $endereco,
        ];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function lastPositionMovida(String $chassi)
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
                    "modelo_fipe_tab"           => $dat['BI_FIPE_TAB → modelo'] ?? '',
                    "endereco"                  => $this->apiDeviceServic->getAddress($dat['lp_latitude'], $dat['lp_longitude'])
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
        ini_set('max_execution_time', 300);

        if (Carbon::parse($request->last_date)->diffInDays(Carbon::parse($request->first_date)) > 11) {
            return response()->json(['status' => 'validation_error', 'errors' => "Período superior a 10 dias"], 404);
        };

        if ($request->first_date > $request->last_date) {
            $this->logService->saveLog(strval(Auth::user()->name), 'Histórico de posições:   Data invalida, data de inicio maior que a data final, ou diferença entre data superior a 5 dias para o chassi: ' . $request->chassis);
            return response()->json(['status' => 'validation_error', 'errors' => "Data invalida, data de inicio maior que a data final, ou diferença entre data superior a 5 dias"], 404);
        }

        $data['positions'] = $this->apiFleetLargeService->getGridModel($request->first_date, $request->last_date, $request->modelo);

        if (in_array("Nenhum registro encontrado", $data['positions'])) {
            $this->logService->saveLog(strval(Auth::user()->name), 'Histórico de posições: Não localizou registro para o chassi: ' . $request->chassis);
            return response()->json(['status' => 'validation_error', 'errors' => "Nenhum registro encontrado."], 404);
        };

        if (Auth::user()->customer_id == 8) {
            $this->logService->saveLog(strval(Auth::user()->name), 'Histórico de posições: Verificou o histórico de posições do chassi: ' . $request->chassis . ' no período de: ' . Carbon::parse($request->first_date)->format('d/m/Y') . ' até ' .  Carbon::parse($request->last_date)->format('d/m/Y') . '.');
        }

        return response()->view('fleetslarge.monitoring.list', $data);
    }

    public function route(Request $request)
    {
        $positions = $this->apiFleetLargeService->getRoutePath($request->start_date, $request->last_date, $request->modelo);
        return response()->json(['status' => 'success', 'positions' => $positions], 200);
    }

    //Dashboard de todos os carros

    public function events()
    {
        //Eventos Movida
        if (Auth::user()->customer_id == 7) {
            $fleetslarge = $this->apiFleetLargeService->events('3e808287-c81f-402e-b681-252e9a834d4a');
        }

        //Eventos Mapfre
        if (Auth::user()->customer_id == 11) {
            $fleetslarge = $this->apiFleetLargeService->events('425e18d1-407b-4cee-ac8e-fa4d20604f8a');
        }
        return response()->json($fleetslarge, 200);
    }

    public function allCars()
    {
        // Entrar no Mapa todos os carros Movida
        if (Auth::user()->customer_id == 7) {
            return view('fleetslarge.monitoring.allcarsMovida');
        }

        // Entrar no Mapa todos os carros Santander
        if (Auth::user()->customer_id == 8 || Auth::user()->customer_id == 13) {
            $this->logService->saveLog(strval(Auth::user()->name), 'Mapa Geral: Acessou o menu Mapa Geral ');
            return view('fleetslarge.monitoring.allcars');
        }

        // Entrar no Mapa todos os carros Mapfre
        if (Auth::user()->customer_id == 11) {
            return view('fleetslarge.monitoring.mapfre.allcarsMapfre');
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
        $filter = ['ignicao' => $ignition == 1 ? 'ON' : 'OFF'];
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
            "t_instalacao"              => $dat['t_instalacao'] ?? ''
        ]);
        return $arr;
    }

    /**
     * @param String $device
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function lastPositionPSA(String $chassi)
    {
        try {
            $fleetslarges = $this->psaService->findByChassi($chassi);
            return response()->json(['status' => 'success', 'data' => $fleetslarges], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
