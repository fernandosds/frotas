<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoCercaRelacionamento extends Model
{
    protected $table = 'grupos_cercas_relacionamento';

    protected $fillable = [
        'grupo_id',
        'chassis',
        'created_at'
    ];
}
