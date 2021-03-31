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
     *
     */
    protected $host = "";
    protected $host_siscon = "";
    protected $host_apis = "";

    /**
     * ApiDeviceService constructor.
     */
    public function __construct()
    {

        if( true ){
            $this->host_siscon = "http://10.20.3.84:83/siscon/new-siscon/public/";
            $this->host = "http://10.20.3.36:6524";
            $this->host_apis = "https://api.satcompany.com.br";
        }else{

            $this->host_siscon = "http://201.91.1.155:83/siscon/new-siscon/public/";
            $this->host = "http://189.16.50.195:6524";
            $this->host_apis = "https://api.satcompany.com.br";
        }
    }

    /**
     * @param String $device
     * @return mixed
     */
    public function testDevice(String $device)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=LAST,time=120M,rssi=60-100]";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @return array
     */
    public function getLastPosition(String $device)
    {
        $url = $this->host . "/listjson&grid_rastreamento[*]+id='{$device}'+limit+1";
        return ClientHttp($url);

        /*
        $arr = ClientHttp($url);
        dd($arr);
        $url = $this->host_apis . "/devices/grid/last/$device";
        $arr = ClientHttp($url);

        $arr = [
            'body' => [[
                "ID" => $device,
                "Prd" => $arr[0]['MARC_CODIGO'],
                "Batt/St" => "",
                "Tensão" => $arr[0]['TENSAO'],
                "Ign" => "",
                "Data_Rec" => $arr[0]['DATA_REC'],
                "Data_GPS" => $arr[0]['DH_GPS'],
                "Latitude" => $arr[0]['LATITUDE'],
                "Longitude" => $arr[0]['LONGITUDE'],
                "ST" => "",
                "Satelites" => $arr[0]['QT_SATELITE'],
                "Sinal" => "",
                "JM" => "",
                "Temp" => "",
                "Vel." => "",
                "Evt" => $arr[0]['PT_ID'],
                "Modo" => $arr[0]['MODO'],
            ]],
            "code" => 200,
            "status" => "success"
        ];
        dd($arr);
        return $arr;
        */
    }


    /**
     * @param String $device
     * @return array
     */
    public function getHeatPositions(String $device, Int $minutes)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=LIST,time={$minutes}M,rssi=60-1000]";
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

    /**
     * @param String $device
     * @param String $pair_device
     * @return array
     */
    public function getPairing(String $device, String $pair_device)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=PAR,time=10M,rssi=60-100,HOSP={$pair_device}]";
        return ClientHttp($url);
    }

    /**
     * @param String $lat
     * @param String $lon
     * @return array
     */
    public function getAddress(String $lat, String $lon)
    {
        $url = $this->host_apis . "/geo-to-address/v1/latlon/{$lat},{$lon}";
        $address = ClientHttp($url);

        return  $address[0]['LOGRADOURO'].", ".$address[0]['BAIRRO'].", ".$address[0]['CIDADE']." - ".$address[0]['UF'].", CEP: ".$address[0]['CEP'];

    }

    /**
     * @param String $device
     * @param String $pair_device
     * @return array
     */
    public function checkPairing(String $device, String $pair_device)
    {

        $url = $this->host_apis . "/checkpareamento/isca/{$device}/r12/{$pair_device}";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @param Int $minutes
     * @return array
     */
    public function getGrid(String $device, Int $minutes)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=LIST,time={$minutes}M,rssi=60-1000]";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @param Int $minutes
     * @return array
     */
    public function printGrid(String $device, String $from, String $to)
    {
        $url = $this->host . "/hospedeiros&{$device}[type=ADDR,PER='{$from}/{$to}']";
        return ClientHttp($url);
    }




}
