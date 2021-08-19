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
    }

    /**
     * @return array
     */
    public function allCars()
    {
        $url = $this->host . "/1a3961bd-cdf3-4b2b-8e7a-df362d33eaba.json";
        return ClientHttp($url);
    }
}
