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
        $bateriaReal = $this->removePercent($bateriaReal);

        $dt_posicao = Carbon::createFromFormat('d/m/Y H:i:s', $dt_posicao)->format('Y-m-d H:i:s');

        $dif = abs(strtotime($date_embarque) - strtotime($dt_posicao)) / (60 * 60);
        $x = ($dif * 0.40);
        $y = 100 - $x;


        preg_match('/@(.*)/', Auth::user()->email, $out);
        // Condição adaptada temporariamente para que os usuários abaixo, não vejam o nível real da bateria, apenas o Promédio
        if ($out[1] == 'satcompany.com.br') {
            if(Auth::user()->id != 133){
                if(Auth::user()->id != 102){
                    if(Auth::user()->id != 88){
                        return 'R: ' . $bateriaReal . '% | P: ' . round($y, 0) . '%';
                    }else{
                        return 'P: ' . round($y, 0) . '%';
                    }
                }else{
                    return 'P: ' . round($y, 0) . '%';
                }
            } else {
                return 'P: ' . round($y, 0) . '%';
            }
        } else {
            return round($y, 0) . '%';
        }
    }

    public function formatDate($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y H:i:s');
    }

    function removePercent($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }
}
