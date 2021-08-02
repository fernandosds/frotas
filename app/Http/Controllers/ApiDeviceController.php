<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 16:41
 */

namespace App\Http\Controllers;


use App\Services\ApiDeviceService;
use App\Http\Controllers\Iscas\BoardingController;

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
    public function __construct(ApiDeviceService $apiDeviceService, BoardingController $boardingController)
    {
        $this->apiDeviceService = $apiDeviceService;
        $this->boardingController = $boardingController;
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
        if ($last_position['status'] == "sucesso") {

            $return["status"] = "sucesso";
            $return["Atualizado"] =      isset($last_position['body'][0]["Atualizado"]) ? $last_position['body'][0]["Atualizado"] : '';
            $return["Bateria_Violada"] = isset($last_position['body'][0]["Bateria_Violada"]) ? $last_position['body'][0]["Bateria_Violada"] : '';
            $return["CODIGO"] =          isset($last_position['body'][0]["CODIGO"]) ? $last_position['body'][0]["CODIGO"] : '';
            $return["Chave"] =           isset($last_position['body'][0]["Chave"]) ? $last_position['body'][0]["Chave"] : '';
            $return["Color"] =           isset($last_position['body'][0]["Color"]) ? $last_position['body'][0]["Color"] : '';
            $return["Data_GPS"] =        isset($last_position['body'][0]["Data_GPS"]) ? $last_position['body'][0]["Data_GPS"] : '';
            $return["Data_Rec"] =        isset($last_position['body'][0]["Data_Rec"]) ? $last_position['body'][0]["Data_Rec"] : '';
            $return["ENDERECO"] =        isset($last_position['body'][0]["ENDERECO"]) ? $last_position['body'][0]["ENDERECO"] : '';
            $return["Evt"] =             isset($last_position['body'][0]["Evt"]) ? $last_position['body'][0]["Evt"] : '';
            $return["ID"] =              isset($last_position['body'][0]["ID"]) ? $last_position['body'][0]["ID"] : '';
            $return["Latitude"] =        isset($last_position['body'][0]["Latitude"]) ? $last_position['body'][0]["Latitude"] : '';
            $return["Longitude"] =       isset($last_position['body'][0]["Longitude"]) ? $last_position['body'][0]["Longitude"] : '';
            $return["Modo"] =            isset($last_position['body'][0]["Modo"]) ? $last_position['body'][0]["Modo"] : '';
            $return["PT_ID"] =           isset($last_position['body'][0]["PT_ID"]) ? $last_position['body'][0]["PT_ID"] : '';
            $return["Satelites"] =       isset($last_position['body'][0]["Satelites"]) ? $last_position['body'][0]["Satelites"] : '';
            $return["Sinal"] =           isset($last_position['body'][0]["Sinal"]) ? $last_position['body'][0]["Sinal"] : '';
            $return["Temp"] =            isset($last_position['body'][0]["Temp"]) ? $last_position['body'][0]["Temp"] : '';
            $return["Tensão"] =          isset($last_position['body'][0]["Tensão"]) ? $last_position['body'][0]["Tensão"] : '';
            $return["Velocidade"] =      isset($last_position['body'][0]["Velocidade"]) ? $last_position['body'][0]["Velocidade"] : '';
            $return["jammer"] =          isset($last_position['body'][0]["jammer"]) ? $last_position['body'][0]["jammer"] : '';

            if (isset($last_position['body'][0]["Latitude"]) && isset($last_position['body'][0]["Longitude"])) {
                $return["last_address"] = $this->apiDeviceService->getAddress($last_position['body'][0]["Latitude"], $last_position['body'][0]["Longitude"]);
            } else {
                $return["last_address"] = '';
            }

            return $return;
        } else {
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
