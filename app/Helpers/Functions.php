<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 05/02/2021
 * Time: 15:07
 */
use Carbon\Carbon;

/**
 * @param $start
 * @param $end
 * @return mixed
 */
function hoursDiff($start, $end)
{
    if( isset($start) && isset( $end ) ){
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
 * @return array
 */
function minLeftChart($to, $from)
{

    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $to);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $from);
    $total_minutes = $to->diffInMinutes($from);

    $from =  Carbon::parse($from);
    $past_minutes = $from->diffInMinutes(Carbon::now());

    return ( $total_minutes > $past_minutes ) ? ceil(($past_minutes / $total_minutes) * 100) : 0;


}