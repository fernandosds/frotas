<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use Notifiable, SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var string
     */
    protected $with = ["contracts", "stocks", "shipments", "contacts"];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'contract_id',
        'stock_id',
        'shipment_id',
        'name',
        'cpf_cnpj',
        'type',
        'cep',
        'address',
        'complement',
        'number',
        'city',
        'neighborhood',
        'state'

    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'cpf_cnpj'              => $this->cpf_cnpj,
            'type'                  => $this->type,
            'cep'                   => $this->cep,
            'address'               => $this->address,
            'complement'            => $this->complement,
            'number'                => $this->number,
            'city'                  => $this->city,
            'neighborhood'          => $this->neighborhood,
            'state'                 => $this->state,

        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function contracts()
    {
        return $this->HasMany('App\Models\Contract');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function stocks()
    {
        return $this->HasMany('App\Models\Stock');
    }

    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function shipments()
    {
        return $this->HasMany('App\Models\Shipment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function contacts()
    {
        return $this->HasMany('App\Models\Contact');
    }
}
