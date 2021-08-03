<?php

namespace App\Http\Controllers\Iscas;

use App\Http\Controllers\Controller;
use App\Services\Iscas\BoardingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FunctionController extends Controller
{

    /**
     * @var BoardingService
     */
    private $boardingService;

    /**
     * BoardingController constructor.
     * @param BoardingService $boardingService
     */
    public function __construct(BoardingService $boardingService)
    {
        $this->boardingService = $boardingService;
    }

    public function getStatus($bateriaReal, $dt_posicao, $date_embarque)
    {
        //$dt_embarque = Carbon::createFromFormat('d/m/Y H:i:s', $date_embarque)->format('Y-m-d H:i:s');
        $dt_posicao = Carbon::createFromFormat('d/m/Y H:i:s', $dt_posicao)->format('Y-m-d H:i:s');

        $dif = abs(strtotime($date_embarque) - strtotime($dt_posicao)) / (60 * 60);
        $x = ($dif * 0.50);
        $y = 100 - $x;

        preg_match('/@(.*)/', Auth::user()->email, $out);
        if ($out[1] == 'satcompany.com.br') {
            return 'R: ' . $bateriaReal . ' | P: ' . number_format($y, 2, '.', '') . '%';
        } else {
            return number_format($y, 2, '.', '') . '%';
        }
    }

    public function formatDate($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i:s');
    }
}
