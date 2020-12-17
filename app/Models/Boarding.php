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
        'contract_id',
        'log_id',
        'device_id',
        'accommodation_location_id',
        'test',
        'active',
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
            'accommodation_location_id' => $this->accommodation_location_id,
        ];
    }

}