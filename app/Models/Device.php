<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{

    use Notifiable, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'devices';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'type_id',
        'model',
        'contract_id',
        'uniqid',
        'contract_id',
        'tecnology_id'
    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                => $this->id,
            'type_id'           => $this->type_id,
            'model'             => $this->model,
            'contract_id'       => $this->contract_id,
            'uniqid'            => $this->uniqid,
            'contract_id'       => $this->contract_id,
            'tecnology_id'      => $this->tecnology_id,

        ];
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Logs()
    {
        return $this->HasMany('App\Models\Log');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeofdevice()
    {
        return $this->BelongsTo('App\Models\TypeOfDevice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contracts()
    {
        return $this->HasMany('App\Models\Contract');
    }
}
