<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Access extends Model
{

    
    /**
     * @var string
     */
    protected $table = 'accesses';

   

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['user_id', 'customer_id', 'device_id', 'description', 'contract_id'];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'user_id'                   => $this->user_id,
            'customer_id'               => $this->customer_id,
            'device_id'                 => $this->device_id,
            'description'               => $this->description,
            'contract_id'               => $this->contract_id,
            

        ];
    }

}
