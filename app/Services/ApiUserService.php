<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 15/02/2021
 * Time: 15:53
 */

namespace App\Services;


class ApiUserService
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

        $this->host = "https://api.satcompany.com.br";

    }

    /**
     * @return array
     */
    public function newSecret()
    {
        $url = $this->host . "/otp/newsecret";
        return ClientHttp($url);
    }

    /**
     * @param String $secret
     * @return array
     */
    public function generateQRCode(String $secret)
    {
        $url = $this->host . "/otp/qrcode/secret/{$secret}";
        return ClientHttpImg($url);
    }

    /**
     * @param String $secret
     * @return array
     */
    public function genearteToken(String $secret)
    {
        $url = $this->host . "/otp/newcode/secret/{$secret}";
        return ClientHttp($url);
    }

    /**
     * @param String $secret
     * @param String $token
     * @return array
     */
    public function tokenValidation(String $secret, String $token)
    {
        $url = $this->host . "/otp/check/secret/{$secret}/token/{$token}";
        return ClientHttp($url);
    }

}