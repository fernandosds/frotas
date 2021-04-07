<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'permissions';


    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'monitoring_id',
        'dashboard_id',
        'driver_id',
        'fleet_car_id',
        'card_id',
        'cost_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                  => $this->id,
            'user_id'             => $this->user_id,
            'monitoring_id'       => $this->monitoring_id,
            'dashboard_id'        => $this->dashboard_id,
            'driver_id'           => $this->driver_id,
            'fleet_car_id'        => $this->fleet_car_id,
            'card_id'             => $this->card_id,
            'cost_id'             => $this->cost_id,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function listMenu()
    {
        return $this->belongsTo('App\Models\ListMenu');
    }
}
