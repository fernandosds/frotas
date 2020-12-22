<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccommodationLocation extends Model
{ 

    use Notifiable, SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'accommodation_locations';

   

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


}
