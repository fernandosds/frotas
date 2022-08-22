<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoAlerta;
use App\Models\GrupoGaragem;

class GrupoAlertaGaragem extends Model
{
    protected $table = 'grupos_alerta_garagem';

    protected $fillable = [
        'id_grupo_alerta',
        'id_grupo_alerta',
        'created_at',
        'updated_at'
    ];

    public function grupoAlerta(){
        return $this->hasMany(GrupoAlerta::class, 'id', 'id_grupo_alerta');
    }

    public function grupoGaragem(){
        return $this->hasMany(GrupoGaragem::class, 'id', 'id_grupo_garagem');
    }
}