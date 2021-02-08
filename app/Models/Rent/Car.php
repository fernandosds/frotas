<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
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
        'type'
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
            'automaker'     => $this->automaker,
            'year'          => $this->year,
            'color'         => $this->color,
            'type'          => $this->type,
            
        ];
    }
}
