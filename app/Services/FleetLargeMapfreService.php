<?php


namespace App\Services;

use Illuminate\Support\Carbon;
use stdClass;
use Illuminate\Support\Facades\Auth;


class FleetLargeMapfreService
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


    public function allCars($hash)
    {
        $data = $this->getByHash($hash);
        return $data;
    }


    private function getByHash($hash)
    {
        $url = $this->host . "/" . $hash . ".json";
        return ClientHttp($url);
    }
}
