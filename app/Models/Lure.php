<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lure extends Model
{

    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'lures';

    /**
     * @var string
     */
    protected $with = ["stocks"];


    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'type_of_lure_id',
        'serial_number',
        'batery_level',        
        'validation'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'               => $this->id,
            'type_of_lure_id'  => $this->type_of_lure_id,
            'serial_number'    => $this->serial_number,
            'batery_level'     => $this->batery_level,
            'validation'       => $this->date,
            
        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function stocks()
    {
        return $this->HasMany('App\Models\Stock');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeoflure()
    {
        return $this->BelongsTo('App\Models\TypeOfLure');
    }

}
