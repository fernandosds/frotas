<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{

    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'devices';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'type_of_device_id',
        'model',
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                 => $this->id,
            'type_of_device_id'  => $this->type_of_device_id,
            'model'              => $this->model,
            
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function Logs()
    {
        return $this->HasMany('App\Models\Log');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeofdevice()
    {
        return $this->BelongsTo('App\Models\TypeOfDevice');
    }

}
