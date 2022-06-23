<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Log extends Model
{


    /**
     * @var string
     */
    protected $table = 'logs';



    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['user_id', 'customer_id', 'device_id', 'user_name', 'description', 'host_ip', 'contract_id'];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'user_id'                   => $this->user_id,
            'customer_id'               => $this->customer_id,
            'device_id'                 => $this->device_id,
            'user_name'                 => $this->user_name,
            'description'               => $this->description,
            'host_ip'                   => $this->host_ip,
            'contract_id'               => $this->contract_id,


        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
