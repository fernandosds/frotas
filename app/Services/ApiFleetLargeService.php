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
        $url = $this->host . "/9859d7fe-6cbc-4546-83be-ae0d41f30449.json";
        return ClientHttp($url);
    }
}
