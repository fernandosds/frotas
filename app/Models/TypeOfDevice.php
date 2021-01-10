<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class TypeOfDevice extends Model
{

    use Notifiable, SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'device_types';

    /**
     * @var string
     */
    protected $with = ["devices"];

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'technologie_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                            => $this->id,
            'technologie_id'                => $this->technologie_id,
            
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function devices()
    {
        return $this->HasMany('App\Models\Device');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technologie()
    {
        return $this->BelongsTo('App\Models\Technologie');
    }
}
