<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technologie extends Model
{
    
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
