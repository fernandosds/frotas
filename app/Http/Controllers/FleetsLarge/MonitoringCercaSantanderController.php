<?php

namespace App\Http\Controllers\FleetsLarge;

use App\Http\Controllers\Controller;
use App\Services\ApiFleetLargeService;
use App\Services\FleetsLarge\GrupoCercaService;
use App\Services\ApiDeviceService;
use App\Services\CustomerService;
use App\Services\LogService;
use App\Services\FleetsLarge\PsaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Repositories\LogRepository;
use Carbon\Carbon;
use stdClass;

class MonitoringCercaSantanderController extends Controller
{

    /**
     * @var GrupoCercaService
     */
    private $grupoCercaService;

    /**
     * MonitoringCercaSantanderController constructor.
     * @param GrupoCercaService $grupoCercaService
     */
    public function __construct(GrupoCercaService $grupoCercaService)
    {
        $this->grupoCercaService = $grupoCercaService;

        $this->data = [
            'icon' => 'fa-car-alt',
            'title' => 'Monitoramento Grandes Frotas',
            'menu_open_fleetslarges' => 'kt-menu__item--open'
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        try {
            $data['grupos'] = $this->grupoCercaService->allGroup();
            return response()->json(['statusText' => 'ok', 'isConfirmed' => true, 'result' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['statusText' => 'error', 'isConfirmed' => false, 'error' => $e->getMessage()], 400);
        }
    }
}
