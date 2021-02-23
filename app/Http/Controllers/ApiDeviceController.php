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
            $return["Atualizado"] =      isset( $last_position['body'][0]["Atualizado"] ) ? : '';
            $return["Bateria_Violada"] = isset( $last_position['body'][0]["Bateria_Violada"] ) ? : '';
            $return["CODIGO"] =          isset( $last_position['body'][0]["CODIGO"] ) ? : '';
            $return["Chave"] =           isset( $last_position['body'][0]["Chave"] ) ? : '';
            $return["Color"] =           isset( $last_position['body'][0]["Color"] ) ? : '';
            $return["Data_GPS"] =        isset( $last_position['body'][0]["Data_GPS"] ) ? : '';
            $return["Data_Rec"] =        isset( $last_position['body'][0]["Data_Rec"] ) ? : '';
            $return["ENDERECO"] =        isset( $last_position['body'][0]["ENDERECO"] ) ? : '';
            $return["Evt"] =             isset( $last_position['body'][0]["Evt"] ) ? : '';
            $return["ID"] =              isset( $last_position['body'][0]["ID"] ) ? : '';
            $return["Latitude"] =        isset( $last_position['body'][0]["Latitude"] ) ? : '';
            $return["Longitude"] =       isset( $last_position['body'][0]["Longitude"] ) ? : '';
            $return["Modo"] =            isset( $last_position['body'][0]["Modo"] ) ? : '';
            $return["PT_ID"] =           isset( $last_position['body'][0]["PT_ID"] ) ? : '';
            $return["Satelites"] =       isset( $last_position['body'][0]["Satelites"] ) ? : '';
            $return["Sinal"] =           isset( $last_position['body'][0]["Sinal"] ) ? : '';
            $return["Temp"] =            isset( $last_position['body'][0]["Temp"] ) ? : '';
            $return["Tensão"] =          isset( $last_position['body'][0]["Tensão"] ) ? : '';
            $return["Velocidade"] =      isset( $last_position['body'][0]["Velocidade"] ) ? : '';
            $return["jammer"] =          isset( $last_position['body'][0]["jammer"] ) ? : '';

            if(isset( $last_position['body'][0]["Latitude"] ) && isset( $last_position['body'][0]["Longitude"] ) ){
                $return["last_address"] = $this->apiDeviceService->getAddress($last_position['body'][0]["Latitude"], $last_position['body'][0]["Longitude"]);
            }else{
                $return["last_address"] = '';
            }


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