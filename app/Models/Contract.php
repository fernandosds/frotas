<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{

    use Notifiable, SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'contracts';

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'customer_id',       
        'user_id',
        'validity'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'            => $this->id,
            'customer_id'   => $this->customer_id,
            'user_id'       => $this->user_id,
            'validity'      => $this->validity,
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log()
    {
        return $this->belongsTo('App\Models\Log');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractdevice()
    {
        return $this->HasMany('App\Models\ContractDevice', ContractDevice::class);
    }
}
