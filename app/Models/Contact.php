<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'phone',
        'custumer_id',
        'email'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'            => $this->id,
            'phone'         => $this->phone,
            'customer_id'   => $this->customer_id,
            'email'         => $this->email,
            
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->BelongsTo('App\Models\Customer');
    }


}
