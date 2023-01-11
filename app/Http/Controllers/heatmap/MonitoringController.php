<?php

namespace App\Http\Controllers\heatmap;

use App\Http\Controllers\Controller;
use App\Models\ActiveBase;
use Carbon\Carbon;
use stdClass;

class MonitoringController extends Controller
{
    public function heatmap(){
        return view('monitoring.heatmap');
    }
    public function heatMapLastPositon(){
        
        $activeBase = ActiveBase::all('latitude as lat', 'longitude as lng', 'modelo');

        $collectionLatLng = array();
        foreach($activeBase as $index => $latlng){
            // if($index <= 1000){
                $collectionLatLng[] = array($latlng->lat, $latlng->lng);
            // }
        }
        return $collectionLatLng;
    }
}
