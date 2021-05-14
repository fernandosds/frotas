<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 11/05/2021
 * Time: 14:44
 */

namespace App\Services;


use App\Repositories\CommandRepository;
use http\Env\Response;

class CommandService
{

    /**
     * @var
     */
    protected $host;


    /**
     * CommandService constructor.
     */
    public function __construct()
    {
        $this->host = "http://201.91.1.155:83/api-envio-comandos/api";
        $this->host = "http://10.20.3.84:83/api-envio-comandos/api";
        $this->host = "http://10.20.3.36:6525";
    }

    /**
     * @param String $card
     * @param String $device
     * @return bool
     */
    public function addCardToDevice(String $card, String $device)
    {

        return 'token: '.$card.' - '.$device;



        $url = $this->host . "/add-card-to-device/$card/$device";
        return ClientHttp($url);
    }

    /**
     * @param String $card
     * @param String $device
     * @return bool
     */
    public function removeCartToDevice(String $card, String $device)
    {
        $url = $this->host . "/remove-card-to-device/$card/$device";

        return 'aaaaaaa';


        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @return bool
     */
    public function acceptAllCards(String $device)
    {
        $url = $this->host . "/accept-all-cards/$device";
        return ClientHttp($url);
    }

    /**
     * @param String $device
     * @return bool
     */
    public function removeAllCards(String $device)
    {

        $url = $this->host . "/remove-all-cards/$device";
        return ClientHttp($url);
    }

    /**
     * @param String $token
     * @return array
     */
    public function checkStatus(String $token)
    {

        $url = $this->host . "/listjson&grid_comandos+token='{".$token."}'";
        return ClientHttp($url);
    }

}