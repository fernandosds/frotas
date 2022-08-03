<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoGaragem;
use App\Models\BancoSantander;

class GrupoGaragemRelacionamento extends Model
{
    protected $table = 'grupos_garagem_relacionamento';

    protected $fillable = [
        'grupo_id',
        'chassis',
        'dispositivo',
        'created_at'
    ];

    public function grupoGaragem(){
        return $this->hasOne(GrupoGaragem::class, 'id', 'grupo_id');
    }


    public function santander(){
        return $this->hasOne(BancoSantander::class, 'chassis', 'chassis');
    }

}
