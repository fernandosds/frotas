<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 16:41
 */

namespace App\Http\Controllers;


use App\Services\ApiDeviceService;

class ApiDeviceController
{

    /**
     * @var BoardingService
     */
    private $apiDeviceService;

    /**
     * BoardingController constructor.
     * @param ApiDeviceService $apiDeviceService
     */
    public function __construct(ApiDeviceService $apiDeviceService)
    {
        $this->apiDeviceService = $apiDeviceService;
    }

    /**
     * @param String $device
     * @return mixed
     */
    public function testDevice(String $device)
    {
        return $this->apiDeviceService->testDevice($device);
    }

    /**
     * @param String $device
     * @return mixed
     */
    public function getLastPosition(String $device)
    {
        $last_position = $this->apiDeviceService->getLastPosition($device);

        $return = [];
        if( $last_position['status'] == "sucesso" ){

            $return["status"] = "sucesso";
            $return["Atualizado"] =      $last_position['body'][0]["Atualizado"];
            $return["Bateria_Violada"] = $last_position['body'][0]["Bateria_Violada"];
            $return["CODIGO"] =          $last_position['body'][0]["CODIGO"];
            $return["Chave"] =           $last_position['body'][0]["Chave"];
            $return["Color"] =           $last_position['body'][0]["Color"];
            $return["Data_GPS"] =        $last_position['body'][0]["Data_GPS"];
            $return["Data_Rec"] =        $last_position['body'][0]["Data_Rec"];
            $return["ENDERECO"] =        $last_position['body'][0]["ENDERECO"];
            $return["Evt"] =             $last_position['body'][0]["Evt"];
            $return["ID"] =              $last_position['body'][0]["ID"];
            $return["Latitude"] =        $last_position['body'][0]["Latitude"];
            $return["Longitude"] =       $last_position['body'][0]["Longitude"];
            $return["Modo"] =            $last_position['body'][0]["Modo"];
            $return["PT_ID"] =           $last_position['body'][0]["PT_ID"];
            $return["Satelites"] =       $last_position['body'][0]["Satelites"];
            $return["Sinal"] =           $last_position['body'][0]["Sinal"];
            $return["Temp"] =            $last_position['body'][0]["Temp"];
            $return["Tensão"] =          $last_position['body'][0]["Tensão"];
            $return["Velocidade"] =      $last_position['body'][0]["Velocidade"];
            $return["jammer"] =          $last_position['body'][0]["jammer"];
            $return["last_address"] =    $this->apiDeviceService->getAddress($last_position['body'][0]["Latitude"], $last_position['body'][0]["Longitude"]);

            return $return;
        }else{
            return $last_position;
        }

    }

    /**
     * @param String $placa
     * @return mixed
     */
    public function getDevice(String $placa)
    {

        return $this->apiDeviceService->getDevice($placa);
    }

}