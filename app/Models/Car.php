<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     *
     */
    protected $table = 'cars';

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'placa',
        'chassi',
        'model',
        'automaker',
        'year',
        'color',
        'customer_id',
        'type',
        'device'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'            => $this->id,
            'placa'         => $this->placa,
            'chassi'        => $this->chassi,
            'model'         => $this->model,
            'customer_id'   => $this->customer_id,
            'automaker'     => $this->automaker,
            'year'          => $this->year,
            'color'         => $this->color,
            'type'          => $this->type,
            'device'        => $this->device,
        ];
    }
}
