<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\ApiDeviceService;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Print_;

class DashboardController extends Controller
{


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
    public function __construct(ApiFleetLargeService $apiFleetLargeService, ApiDeviceService $apiDeviceServic, CustomerService $customerService)
    {
        $this->apiFleetLargeService = $apiFleetLargeService;
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
        $data['fleetslarge'] = $this->apiFleetLargeService->allCars($customer->hash);
        $data['totalJson'] = count($data['fleetslarge']);

        return response()->view('fleetslarge.dashboard.list', $data);
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
    public function showAllStatus()
    {
        $customer = $this->customerService->show(Auth::user()->customer_id);
        $data['fleetslarge'] = $this->apiFleetLargeService->allCars($customer->hash);

        try {
            if ($data['fleetslarge'][0]['empresa'] == 'Movida') {
                $empresa = 'Movida';
                foreach ($data['fleetslarge'] as $data => $dat) {

                    if ($dat['sinistrado'] == "FALSE" && Carbon::parse($dat['lp_ultima_transmissao'])->diffInDays(Carbon::now()) < 7) {
                        $arr[] = $this->resultJson($dat);
                        $grid01 = $arr;
                    }

                    if ($dat['status_veiculo'] != "LOCACAO") {
                        $arr2[] = $this->resultJson($dat);
                        $grid02 = $arr2;
                    }

                    if ($dat['sinistrado'] == "TRUE") {
                        $arr3[] = $this->resultJson($dat);
                        $grid03 = $arr3;
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
                    "grid05"   => $grid05 ?? ''
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
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
    function resultJson($dat)
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
