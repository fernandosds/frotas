<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'permissions';


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
            'id'               => $this->id,
            'type'             => $this->type,

        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function users()
    {
        return $this->HasMany('App\Models\User');
    }
    
}
