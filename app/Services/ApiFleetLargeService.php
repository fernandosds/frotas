<?php


namespace App\Services;


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

    /**
     * @return array
     */
    public function allCars()
    {
        $url = $this->host . "/9859d7fe-6cbc-4546-83be-ae0d41f30449.json";
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
