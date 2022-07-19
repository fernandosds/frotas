<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoCerca;
use App\Models\GrupoUsuarioRelacionamento;
use App\Models\BancoSantander;

class GrupoCercaRelacionamento extends Model
{
    protected $table = 'grupos_cercas_relacionamento';

    protected $fillable = [
        'grupo_id',
        'chassis',
        'dispositivo',
        'created_at'
    ];

    public function grupoCerca(){
        return $this->hasOne(GrupoCerca::class, 'id', 'grupo_id');
    }

    public function grupoUsuario(){
        return $this->hasOne(GrupoUsuarioRelacionamento::class, 'id', 'id_grupo');
    }

    public function santander(){
        return $this->hasOne(BancoSantander::class, 'chassis', 'chassis');
    }

}
