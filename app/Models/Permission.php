<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * @var string
     */
    protected $table = 'permissions';

     /**
     * @var string
     */
    protected $with = ["users"];


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
