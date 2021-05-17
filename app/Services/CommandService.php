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

        if( true ){
            $this->host = "http://10.20.3.36:6523";
        }else{
            $this->host = "http://189.16.50.195:6523";
        }

    }

    /**
     * @param String $card
     * @param String $device
     * @return bool
     */
    public function addCardToDevice(String $card, String $device)
    {

        $url = $this->host . "/addcard&{$device}[{$card}]";
        $a = ClientHttp($url);
        return $a[0]['TOKEN'];
    }

    /**
     * @param String $card
     * @param String $device
     * @return bool
     */
    public function removeCartToDevice(String $card, String $device)
    {

        $url = $this->host . "/removecard&{$device}[{$card}]";
        $a = ClientHttp($url);
        return $a[0]['TOKEN'];
    }

    /**
     * @param String $device
     * @return bool
     */
    public function acceptAllCards(String $device)
    {
        //$url = $this->host . "/accept-all-cards/$device";
        //return ClientHttp($url);
    }

    /**
     * @param String $device
     * @return bool
     */
    public function removeAllCards(String $device)
    {
        $url = $this->host . "/clearcard&{$device}";
        $a = ClientHttp($url);
        return $a[0]['TOKEN'];
    }

    /**
     * @param String $token
     * @return array
     */
    public function checkStatus(String $token)
    {
        $url = $this->host . "/listjson&grid_comandos+token=$token";
        return ClientHttp($url);
    }

}