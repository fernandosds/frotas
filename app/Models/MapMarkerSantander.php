<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MapMarkerSantander extends Eloquent
{

    protected $connection = 'mongodb';
    protected $collection = 'Santander_Polygons';

    protected $fillable = [
        'name', 
        'markers',
        'type', 
        'user_id'
    ];

}
