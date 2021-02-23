<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Iscas\BoardingService;


class DeviceController extends Controller
{

    /**
     * @var
     */
    protected $boardingService;

    /**
     * DeviceController constructor.
     * @param BoardingService $boardingService
     */
    public function __construct(BoardingService $boardingService)
    {
        $boardingService = $this->boardingService = $boardingService;
    }

    /**
     * @return false|string
     */
    public function getEmbedded()
    {

        $boardings = $this->boardingService->getAllPairActive();

        $return = [];
        foreach( $boardings as $boarding ){
            $return[] = [
                'ISCA' => $boarding->device->model,
                'R12' => $boarding->pair_device
            ];

        };

        return response()->json($return);

    }

}
