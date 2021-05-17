<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use Notifiable, SoftDeletes;


    /**
     * @var string
     */
    protected $table = 'drivers';

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'admission',
        'cpf',
        'cnh',
        'customer_id',
        'address',
        'phone',
        'email',
        'status',
        'card_id'

    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'admission'   => $this->admission,
            'cpf'         => $this->cpf,
            'cnh'         => $this->cnh,
            'customer_id' => $this->customer_id,
            'address'     => $this->address,
            'phone'       => $this->phone,
            'email'       => $this->email,
            'status'      => $this->status,
            'card_id'     => $this->card_id,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Models\Card');
    }
}
