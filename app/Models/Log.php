<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Log extends Model
{

    use Notifiable;

    
    /**
     * @var string
     */
    protected $table = 'logs';

    
    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'datetime',
        'customer_id',
        'device_id',
        'description',
        'contract_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'customer_id'      => $this->customer_id,
            'device_id'        => $this->device_id,
            'contract_id'      => $this->contract_id,
            'datetime'         => $this->datetime,
            
        ];
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   // public function user()
   // {
   //     return $this->belongsTo('App\Models\User');
   // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
}
