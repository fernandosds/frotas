<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationLocation extends Model
{ 
    /**
     * @var string
     */
    protected $table = 'accommodation_locations';

    /**
     * @var string
     */
    protected $with = ["shipments"];


    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'id',
        'type'

    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                    => $this->id,
            'type'                  => $this->name,
            

        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function shipments()
    {
        return $this->HasMany('App\Models\Shipment');
    }

}
