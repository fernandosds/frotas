<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 16:49
 */

namespace App\Services;


class ApiDeviceService
{

    /**
     * @var string
     */
    //protected $host = "https://api.satcompany.com.br";
    protected $host = "http://10.20.3.36:6524";

    /**
     * @param String $device
     * @return mixed
     */
    public function testDevice(String $device)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=LAST,time=100D,rssi=60-100]";
        return ClientHttp($url);
    }

}