<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technologie extends Model
{
    
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'technologies';

    /**
     * @var string
     */
    protected $with = ["typeoflure"];

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
            'id'        => $this->id,
            'type'      => $this->type,
            
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function typeoflure()
    {
        return $this->HasMany('App\Models\TypeOfLure');
    }

}
