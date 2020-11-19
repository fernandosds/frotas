<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{

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
        'stock_id',
        'shipment_id',
        'custumer_id',       
        'type',
        'validity'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'            => $this->id,
            'stock_id'      => $this->stock_id,
            'shipment_id'   => $this->shipment_id,
            'costumer_id'   => $this->costumer_id,
            'type'          => $this->type,
            'validity'      => $this->validity,
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->BelongsTo('App\Models\Customer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shipment()
    {
        return $this->belongsTo('App\Models\Shipment');
    }
}
