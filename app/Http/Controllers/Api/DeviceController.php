<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{

    /**
     * @return false|string
     */
    public function getEmbedded()
    {

        $return[] = [
            'ISCA' => '99A00105',
            'R12' => '99112275'
        ];

        return json_encode($return);


    }



}
