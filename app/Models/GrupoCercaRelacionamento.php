<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoCerca;
use App\Models\BancoSantander;

class GrupoCercaRelacionamento extends Model
{
    protected $table = 'grupos_cercas_relacionamento';

    protected $fillable = [
        'grupo_id',
        'chassis',
        'created_at'
    ];

    public function grupoCerca(){
        return $this->hasOne(GrupoCerca::class, 'id', 'grupo_id');
    }

}
