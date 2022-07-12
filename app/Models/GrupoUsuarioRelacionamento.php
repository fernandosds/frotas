<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoUsuario;

class GrupoUsuarioRelacionamento extends Model
{
    protected $table = 'grupos_usuario_relacionamento';

    protected $fillable = [
        'id_grupo',
        'id_usuario',
        'created_at'
    ];

    public function grupoUsuario(){
        return $this->hasMany(GrupoUsuario::class, 'id_grupo', 'id');
    }
}