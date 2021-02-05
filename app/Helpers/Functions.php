<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 05/02/2021
 * Time: 15:07
 */

function hoursDiff($start, $end)
{
    if( isset($start) && isset( $end ) ){
        $date1 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $date2 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $end);
        $value = $date2->diffInHours($date1);
        return $value;
    }

}