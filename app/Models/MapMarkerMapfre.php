<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MapMarkerMapfre extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'Movida_Polygons';

    protected $fillable = [
        'name',
        'markers',
        'type',
        'user_id',
        'customer'
    ];
}
