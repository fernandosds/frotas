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
     * @var string
     */
    protected $with = ["boardings"];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'model',
        'uniqid',
        'technologie_id',
        'tipo',
        'contract_id',
        'type_id',
        'customer_id',
        'status',
        'deleted_at',
        'created_at',
        'updated_at'
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
            'technologie_id'    => $this->technologie_id,
            'tipo'              => $this->tipo,
            'contract_id'       => $this->contract_id,
            'type_id'           => $this->type_id,
            'customer_id'       => $this->customer_id,
            'status'            => $this->status,

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
    public function contracts()
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technologie()
    {
        return $this->belongsTo('App\Models\Technologie');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contractdevice()
    {
        return $this->HasMany('App\Models\ContractDevice', ContractDevice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boardings()
    {
        return $this->HasMany('App\Models\Boarding')
            ->orderBy('created_at', 'desc');
    }
}
