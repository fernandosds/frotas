<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoUsuario;
use App\Models\GrupoCerca;

class GrupoUsuarioRelacionamento extends Model
{
    protected $table = 'grupos_usuario_relacionamento';

    protected $fillable = [
        'id_grupo',
        'id_usuario',
        'nome_usuario',
        'created_at',
        'updated_at'
    ];

    public function grupoCerca(){
        return $this->hasMany(GrupoCerca::class, 'id_grupo', 'id');
    }
}