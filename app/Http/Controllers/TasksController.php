<?php

namespace App\Http\Controllers;

use App\Services\Iscas\BoardingService;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    /**
     * @var
     */
    private $boardingService;

    /**
     * TasksController constructor.
     * @param BoardingService $boardingService
     */
    public function __construct( BoardingService $boardingService)
    {
        $this->boardingService = $boardingService;
    }

    /**
     *
     */
    public function autoFinatlizeBoardings()
    {
        return $this->boardingService->autoFinatlizeBoardings();
    }
}
