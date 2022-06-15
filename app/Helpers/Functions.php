<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 05/02/2021
 * Time: 15:07
 */

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @param $start
 * @param $end
 * @return mixed
 */
function hoursDiff($start, $end)
{
    if (isset($start) && isset($end)) {
        $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $end);
        $value = $date2->diffInHours($date1);
        return $value;
    }
}

/**
 * @param $final
 * @return string
 */
function timeLeft($final)
{

    $final =  Carbon::parse($final);
    return $final->diff(Carbon::now())->format('%d dia(s) %H Hrs e %i min');
}

/**
 * @param $to
 * @param $from
 * @return float|int
 */
function minLeftChart($to, $from)
{

    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $to);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $from);
    $total_minutes = $to->diffInMinutes($from);

    $from =  Carbon::parse($from);
    $past_minutes = $from->diffInMinutes(Carbon::now());

    return ($total_minutes > $past_minutes) ? ceil(($past_minutes / $total_minutes) * 100) : 0;
}

/**
 * @param $arr
 * @return bool
 */
function saveLog($data)
{

    try {
        $message['user'] = Auth::user()->id;
        $message['name'] = Auth::user()->name;
        $message['ip'] = $_SERVER['REMOTE_ADDR'];
        $message['value'] = $data['value'];
        $message['type'] = $data['type'];
        $message['local'] = $data['local'];
        $message['funcao'] = $data['funcao'];

        $post = array(
            'component' => 'Iscas', 'level' => 5,
            'customer' => Auth::user()->customer->id, 'message' => json_encode($message)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.satcompany.com.br/log/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}

function fixPlate($plate)
{
    $plate = strtoupper($plate);
    $placa = array('old' => $plate, 'new' => $plate);
    if (strlen($plate) === 7) {
        if (!is_numeric(substr($plate, 4, 1))) {
            $stringConvertida = array_search(substr($plate, 4, 1), array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'));
            $placa['old'] = substr($plate, 0, 4) . $stringConvertida . substr($plate, 5, 2);
        } else {
            $stringConvertida = array_search(substr($plate, 4, 1), array('A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9));
            $placa['new'] = substr($plate, 0, 4) . $stringConvertida . substr($plate, 5, 2);
        }
    }
    return $placa['new'];
}
