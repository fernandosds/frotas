<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListMenu extends Model
{
    /**
     * @var string
     */
    protected $table = 'list_menu';

    const monitoring = 'monitoring';
    const dashboard = 'dashboard';
    const driver = 'driver';
    const fleet_car = 'fleet_car';
    const card = 'card';
    const cost = 'cost';

    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
