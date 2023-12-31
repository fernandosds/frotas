<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracker extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'trackers';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'model',
        'uniqid',
        'status',
        'contract_id',
        'customer_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                => $this->id,
            'model'             => $this->model,
            'uniqid'            => $this->uniqid,
            'status'            => $this->status,
            'contract_id'       => $this->contract_id,
            'customer_id'       => $this->customer_id,
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contracts()
    {
        return $this->HasMany('App\Models\Contract');
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
    public function contractdevice()
    {
        return $this->HasMany('App\Models\ContractDevice', ContractDevice::class);
    }
}
