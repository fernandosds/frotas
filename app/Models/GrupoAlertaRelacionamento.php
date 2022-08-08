<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoAlerta;

class GrupoAlertaRelacionamento extends Model
{
    protected $table = 'grupos_alerta_relacionamento';

    protected $fillable = [
        'id_grupo',
        'id_usuario',
        'nome_usuario',
        'created_at',
        'updated_at'
    ];

    public function grupoAlerta(){
        return $this->hasMany(GrupoAlerta::class, 'id_grupo', 'id');
    }
}