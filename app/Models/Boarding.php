<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:26
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boarding extends Model
{

    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'boardings';

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'type_of_load_id',
        'contract_id',
        'log_id',
        'device_id',
        'accommodation_location_id',        
        'source',
        'destiny',
        'transporter',
        'telephone',
        'board',
        'chassis',
        'carts_plates',
        'transport_order',
        'amount_carried',
        'cpf_cnpj',
        'cell_phone',
        'brand',
        'model',
        'redundant_technologie',
        'test',
        'active',
        'finished_at'

    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'user_id'                   => $this->user_id,
            'customer_id'               => $this->customer_id,
            'contract_id'               => $this->contract_id,
            'log_id'                    => $this->log_id,
            'device_id'                 => $this->device_id,
            'type_of_load_id'           => $this->type_of_load_id,
            'accommodation_location_id' => $this->accommodation_location_id,
            'source'                    => $this->source,
            'destiny'                   => $this->destiny,
            'transporter'               => $this->transporter,
            'telephone'                 => $this->telephone,
            'board'                     => $this->board,
            'chassis'                   => $this->chassis,
            'carts_plates'              => $this->carts_plates,
            'transport_order'           => $this->transport_order,
            'amount_carried'            => $this->amount_carried,
            'cpf_cnpj'                  => $this->cpf_cnpj,
            'cell_phone'                => $this->cell_phone,
            'brand'                     => $this->brand,
            'model'                     => $this->model,
            'redundant_technologie'     => $this->redundant_technologie,
            'test'                      => $this->test,
            'active'                    => $this->active,
            'finished_at'               => $this->finished_at,

        ];
    }

}