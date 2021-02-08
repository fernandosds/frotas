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
    protected $host = "";
    protected $host_posititions = "https://api.satcompany.com.br";

    // Siscon
    protected $host_siscon = "";

    /**
     * ApiDeviceService constructor.
     */
    public function __construct()
    {

        if( $_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "localhost" ){
            $this->host_siscon = "http://10.20.3.84:83/siscon/new-siscon/public/";
            $this->host = "http://10.20.3.36:6524";
        }else{
            $this->host_siscon = "http://201.91.1.155:83/siscon/new-siscon/public/";
            $this->host = "http://189.16.50.195:6524";
        }

    }

    /**
     * @param String $device
     * @return mixed
     */
    public function testDevice(String $device)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=LAST,time=100D,rssi=60-100]";
        //echo $url;die;
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @return array
     */
    public function getLastPosition(String $device)
    {
        $url = $this->host_posititions . "/devices/grid/1/{$device}";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @return array
     */
    public function getHeatPositions(String $device)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=LIST,time=100D,rssi=60-1000]";
        return ClientHttp($url);
    }

    /**
     * @param String $placa
     * @return array
     */
    public function getDevice(String $placa)
    {
        //OTP7935
        $url = $this->host_siscon . "/api-iscas/get-placa/{$placa}";
        return ClientHttp($url);

    }

    public function alertParing(String $device, String $pair_device)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=PAR,time=10M,rssi=60-100,HOSP={$pair_device}]";
    }

}