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
        'monitoring',
        'dashboard',
        'driver',
        'fleet_car',
        'card',
        'cost'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'monitoring'       => $this->monitoring,
            'dashboard'        => $this->dashboard,
            'driver'           => $this->driver,
            'fleet_car'        => $this->fleet_car,
            'card'             => $this->card,
            'cost'             => $this->cost,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
