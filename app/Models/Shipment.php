<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{

    use Notifiable, SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'shipments';


    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'customer_id',
        'contract_id',
        'log_id',
        'device_id',
        'accommodation_location_id',
        'test',
        'active'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                            => $this->id,
            'user_id'                       => $this->user_id,
            'customer_id'                   => $this->customer_id,
            'contract_id'                   => $this->contract_id,
            'log_id'                        => $this->log_id,
            'device_id'                     => $this->device_id,
            'accommodation_location_id'     => $this->accommodation_location_id,
            'test'                          => $this->test,
            'active'                        => $this->active,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function User()
    {
        return $this->BelongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->BelongsTo('App\Models\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->BelongsTo('App\Models\Contract');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Log()
    {
        return $this->BelongsTo('App\Models\Log');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->BelongsTo('App\Models\Device');
    }
}
