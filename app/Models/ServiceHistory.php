<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceHistory extends Model
{

    /**
     * @var string
     */
    protected $table = 'service_history';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'customer_id',
        'user_id',
        'device_id',
        'contract_id',
        'message'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'               => $this->id,
            'customer_id'      => $this->customer_id,
            'user_id'          => $this->user_id,
            'device_id'        => $this->device_id,
            'contract_id'      => $this->contract_id,
            'message'          => $this->message,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->BelongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }
}
