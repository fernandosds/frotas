<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 13/04/2021
 * Time: 11:09
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CardCar extends Model
{

    /**
     * @var string
     */
    protected $table = 'card_car';


    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'card_id',
        'car_id',
        'customer_id',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car()
    {
        return $this->belongsTo('App\Models\Car');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo('App\Models\Card');
    }

}
