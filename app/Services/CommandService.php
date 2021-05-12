<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 11/05/2021
 * Time: 14:44
 */

namespace App\Services;


use App\Repositories\CommandRepository;

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
    }

    /**
     * @param String $card
     * @param String $device
     * @return bool
     */
    public function addCardToDevice(String $card, String $device)
    {
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

}