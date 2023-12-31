<?php


namespace App\Services;

use Illuminate\Support\Carbon;
use stdClass;
use Illuminate\Support\Facades\Auth;


class ApiFleetLargeService
{


    /**
     * @var string
     *
     */
    protected $host;

    /**
     * ApiDeviceService constructor.
     */
    public function __construct()
    {
        $this->host = "https://bi.satcompany.com.br/public/question";
        $this->host_apis = "https://api.satcompany.com.br/";
    }

    public function allCars($hash)
    {
        $url = $this->host . "/" . $hash . ".json";
        return ClientHttp($url);
    }

    public function events($hash)
    {
        $url = $this->host . "/" . $hash . ".json";
        return ClientHttp($url);
    }

    /**
     * @return array
     */
    public function allCarsDashboard($hash, $filter = [])
    {
        $applyFilter = false;
        if (count($filter) > 0) {
            $applyFilter = true;
        }

        $url = curl_init($this->host . "/" . $hash . ".json");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, true);

        $json = curl_exec($url);
        curl_close($url);

        $geojson = new stdClass();
        $geojson->type = "FeatureCollection";
        $geojson->features = [];

        $items = json_decode($json);

        foreach ($items as $item) {
            $feature = new stdClass();
            $feature->type = "Feature";
            $feature->properties = new stdClass();
            $feature->properties->id = $item->modelo;
            $feature->properties->ignicao = $item->lp_ignicao == '1' ? 'ON' : 'OFF';
            $feature->properties->qtd_contrato = $item->qtd_contrato ?? 0;
            $feature->properties->chassis = $item->chassis;
            $feature->properties->modelo_veiculo = $item->modelo_veiculo;
            $feature->properties->placa = $item->placa;
            $feature->properties->lp_velocidade = $item->lp_velocidade;
            $feature->properties->deliver = false;
            if (Auth::user()->customer_id == 7) {

                $feature->properties->status_veiculo = $item->status_veiculo;
                $feature->properties->cliente_local_retirada = $item->cliente_local_retirada;
                $feature->properties->filial = $item->filial;
                $feature->properties->cliente_localdev = $item->cliente_localdev;
                $feature->properties->cliente_datadev = $item->cliente_datadev;
                $feature->properties->cliente_dataretirada = $item->cliente_dataretirada;
                if (!empty($item->cliente_datadev)) {
                    $feature->properties->cliente_datadev = (Carbon::parse($item->cliente_datadev))->subHours(3)->format('d/m/Y H:i:s');
                    if ((Carbon::parse($item->cliente_datadev))->subHours(3)->isSameDay()) {
                        $feature->properties->deliver = true;
                    }
                }
                if (!empty($item->cliente_dataretirada)) {
                    $feature->properties->cliente_dataretirada = (Carbon::parse($item->cliente_dataretirada))->subHours(3)->format('d/m/Y H:i:s');
                }
                $feature->properties->cliente_distancia_endereco_residencial = $item->cliente_distancia_endereco_residencial;
                $feature->properties->cliente_distancia_local_retirada = $item->cliente_distancia_local_retirada;
                $feature->properties->cliente_distancia_local_devolucao = $item->cliente_distancia_local_devolucao;
                $feature->properties->cliente_data_posicao = $item->lp_ultima_transmissao;
                $diffTime = $this->checkTimePosition($item->lp_ultima_transmissao);
                $feature->properties->cliente_posicao_recente = $diffTime['recente'];
                $feature->properties->cliente_posicao_diff = $diffTime['diff'];
            }
            if (Auth::user()->customer_id == 11) {
                $feature->properties->categoria_veiculo = $item->categoria_veiculo;
                $feature->properties->lp_ultima_transmissao = $item->lp_ultima_transmissao = (Carbon::parse($item->lp_ultima_transmissao))->subHours(3)->format('d/m/Y H:i:s');
                $feature->properties->data_instalacao = $item->data_instalacao = (Carbon::parse($item->data_instalacao))->subHours(3)->format('d/m/Y H:i:s');
            }
            $geometry = new stdClass();
            $geometry->type = "Point";
            $geometry->coordinates = [(float)$item->lp_longitude, (float) $item->lp_latitude];
            $feature->geometry = $geometry;

            if ($applyFilter) {
                if ($this->applyFilter($filter, $feature)) {
                    $geojson->features[] = $feature;
                }
            } else {
                $geojson->features[] = $feature;
            }
        }
        return $geojson;
    }

    private function checkTimePosition($time)
    {
        $now = new Carbon();
        $to = Carbon::parse($time);
        $diff_in_minutes = $to->diffInMinutes($now);
        return ['recente' => $diff_in_minutes <= 180, 'diff' => $diff_in_minutes];
    }

    private function applyFilter($filters, $data)
    {
        $filtered = true;
        foreach ($filters as $filter => $value) {
            if ($filter === 'ignicao' && $data->properties->ignicao !== $value) {
                $filtered = false;
            } elseif (
                $filter == 'cliente_datadev' &&
                (!empty($data->properties->{$filter}) && Carbon::createFromFormat('d/m/Y H:i:s', $data->properties->{$filter})->isSameDay() != $value) ||
                empty($data->properties->{$filter})
            ) {
                $filtered = false;
            } elseif (
                $filter == 'qtd_contrato' && $data->properties->{$filter} > $value
            ) {
                $filtered = false;
            }
        }
        return $filtered;
    }

    /**
     * @return array
     */
    public function mediaHours()
    {
        $url = $this->host . "/4aa29189-387b-401b-94b9-24312a8477ca.json";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @param Int $minutes
     * @return array
     */
    public function getGridModel(String $dateStart, String $dateEnd, String $device)
    {
        /**
         * Exemplo URL: https://api.satcompany.com.br/movida_positions/?start=2021-08-01&end=2021-08-20&id=99372114
         */
        $url = $this->host_apis . "movida_positions/?start={$dateStart}&end={$dateEnd}&id={$device}";
        return ClientHttp($url);
    }

    public function getRoutePath(String $dateStart, String $dateEnd, String $device)
    {
        $positions = collect($this->getGridModel($dateStart, $dateEnd, $device));
        $sorted = $positions->sortBy('data_gps', SORT_NATURAL);
        return $sorted->values()->all();
    }

    public function fixPlate($plate)
    {
        $plate = strtoupper($plate);
        $placa = array('old' => $plate, 'new' => $plate);
        if (strlen($plate) === 7) {
            if (!is_numeric(substr($plate, 4, 1))) {
                $stringConvertida = array_search(substr($plate, 4, 1), array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'));
                $placa['old'] = substr($plate, 0, 4) . $stringConvertida . substr($plate, 5, 2);
            } else {
                $stringConvertida = array_search(substr($plate, 4, 1), array('A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9));
                $placa['new'] = substr($plate, 0, 4) . $stringConvertida . substr($plate, 5, 2);
            }
        }
        return $placa['new'];
    }
}
