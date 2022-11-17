<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:26
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispositivos extends Model
{

    protected $connection = 'telemil';

    protected $table = 'dispositivos';

    protected $fillable = [
        'SERIE',
        'CODIGO_PRODUTO',
        'MODELO'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->BelongsTo('App\Models\Device');
    }

}
