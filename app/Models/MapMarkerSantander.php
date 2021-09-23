<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MapMarkerSantander extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'Movida_Polygons';

    protected $fillable = [
        'name', 'markers', 'type'
    ];

    /*public function create($data)
    //{

    }*/
}
