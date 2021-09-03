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
    public function allCars($hash)
    {
        $url = $this->host . "/" . $hash . ".json";
        return ClientHttp($url);
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
