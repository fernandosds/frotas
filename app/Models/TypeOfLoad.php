<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeOfLoad extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'types_of_loads';

    
    /**
     * @var array
     */
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
            'id'                            => $this->id,
            'type'                          => $this->type,
            
        ];
    }

}
