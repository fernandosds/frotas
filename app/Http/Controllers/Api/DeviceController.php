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

        $return = [
            [
                'ISCA' => '99A00105',
                'R12' => '99112276'
            ],[
                'ISCA' => '99A00106',
                'R12' => '99112277'
            ],[
                'ISCA' => '99A00107',
                'R12' => '99112278'
            ],[
                'ISCA' => '99A00108',
                'R12' => '99112279'
            ],[
                'ISCA' => '99A00109',
                'R12' => '99112271'
            ],[
                'ISCA' => '99A00110',
                'R12' => '99112272'
            ]
        ];
        
        return response()->json($return);


    }



}
