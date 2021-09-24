<?php


namespace App\Services;

use stdClass;


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

    /**
     * @return array
     */
    public function allCarsDashboard($hash, $ignition = '')
    {
        $filter = '';
        if ($ignition === '1') {
            $filter = 1;
        }

        if ($ignition === '0') {
            $filter = 0;
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
            $feature->properties->ignicao = $item->lp_ignicao;
            $feature->properties->chassis = $item->chassis;
            $feature->properties->modelo_veiculo = $item->modelo_veiculo;
            $feature->properties->placa = $item->placa;
            $feature->properties->filial = $item->filial;
            $feature->properties->cliente_local_retirada = $item->cliente_local_retirada;
            $feature->properties->cliente_datadev = $item->cliente_datadev;
            $feature->properties->cliente_dataretirada = $item->cliente_dataretirada;
            $feature->properties->cliente_distancia_endereco_residencial = $item->cliente_distancia_endereco_residencial;
            $feature->properties->cliente_distancia_local_retirada = $item->cliente_distancia_local_retirada;
            $feature->properties->cliente_distancia_local_devolucao = $item->cliente_distancia_local_devolucao;
            $feature->properties->cliente_data_posicao = $item->lp_ultima_transmissao;
            $geometry = new stdClass();
            $geometry->type = "Point";
            $geometry->coordinates = [(float)$item->lp_longitude, (float) $item->lp_latitude];
            $feature->geometry = $geometry;

            if ($filter === '') {
                $geojson->features[] = $feature;
            } else {
                if ($filter == $feature->properties->ignicao) {
                    $geojson->features[] = $feature;
                }
            }
        }
        return $geojson;
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
}
