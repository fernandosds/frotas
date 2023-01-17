<?php

namespace App\Http\Controllers\heatmap;

use App\Http\Controllers\Controller;
use App\Models\ActiveBase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;
use App\Http\Controllers\heatmap\GeojsonController;

class MonitoringController extends Controller
{
    public $pointOnVertex = '';
    public function heatmap(){
        return view('monitoring.heatmap');
    }
    public function heatMapLastPositon(Request $request){
        set_time_limit(0);
        $geojson_states = new GeojsonController();
        $states = $geojson_states->states();
        $filter = isset($request->filter) ? $request->filter : 10000;
        if($filter == "true"){
            $activeBase = ActiveBase::whereIn('versao',['H12 RF 1.0', 'R12 RF PROT SAT','R12 RF MOTO SAT'])->select('latitude as lat', 'longitude as lng')->get();
        }else{
            $activeBase = ActiveBase::whereIn('versao',['H12 RF 1.0', 'R12 RF PROT SAT','R12 RF MOTO SAT'])->select('latitude as lat', 'longitude as lng')
            ->limit($filter)->get();
        }
        $collectionLatLng = array();
        foreach($activeBase as $index => $latlng){
            $collectionLatLng[] = array($latlng->lat, $latlng->lng);
        }

        return $collectionLatLng;
    }

    public function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
    
        // Transform string coordinates into arrays with x and y values
        $point = $point;//$this->pointStringToCoordinates($point);
        $vertices = array(); 
        // foreach ($polygon as $vertex) {
            $vertices = $polygon;//$this->pointStringToCoordinates($vertex); 
        // }
        // Check if the lat lng sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
    
        // Check if the lat lng is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
    
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if lat lng is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
    
    public function pointOnVertex($point, $vertices) {
      foreach($vertices as $vertex) {
          if ($point == $vertex) {
              return true;
          }
      }
    
    }
    
    public function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
    // Function to check lat lng
    public function check(){
        $points = array("22.367582 70.711816", "21.43567582 72.5811816","22.367582117085913 70.71181669186944","22.275334996986643 70.88614147123701","22.36934302329968 70.77627818998701"); // Array of latlng which you want to find
        $polygon = array(
            "22.367582117085913 70.71181669186944",
            "22.225161442616514 70.65582486840117",
            "22.20736264867434 70.83229276390898",
            "22.18701840565626 70.9867880031668",
            "22.22452581029355 71.0918447658621",
            "22.382709129816103 70.98884793969023",
            "22.40112042636022 70.94078275414336",
            "22.411912121843205 70.7849142238699",
            "22.367582117085913 70.71181669186944"
        );
        // The last lat lng must be the same as the first one's, to "close the loop"
        foreach($points as $key => $point) {
            echo "(Lat Lng) " . ($key+1) . " ($point): " . $this->pointInPolygon($point, $polygon) . "<br>";
        }
    }
}
