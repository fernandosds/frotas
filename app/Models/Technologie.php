<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technologie extends Model
{

    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'technologies';

    /**
     * @var string
     */
    protected $with = ["typeofdevice"];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'price'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'        => $this->id,
            'type'      => $this->type,
            'price'     => $this->price,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function typeofdevice()
    {
        return $this->HasMany('App\Models\TypeOfDevice');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractdevice()
    {
        return $this->HasMany('App\Models\ContractDevice', ContractDevice::class, 'technologie_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function devices()
    {
        return $this->HasMany('App\Models\Device', Device::class);
    }
}
