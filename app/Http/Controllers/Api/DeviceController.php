<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{

    /**
     * @return false|string
     */
    public function getEmbedded()
    {

        $return[] = [
            'isca' => 'aaa',
            'dispositivo' => 'bbbb'
        ];

        return json_encode($return);


    }
}
