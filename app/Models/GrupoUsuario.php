<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoUsuarioRelacionamento;

class GrupoUsuario extends Model
{


    /**
     * @var string
     */
    protected $table = 'grupos_usuarios';


    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['id', 'nome', 'id_usuario', 'status'];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                 => $this->id,
            'id_usuario'         => $this->id_usuario,
            'nome'               => $this->nome,
            'status'             => $this->status
        ];
    }

    public function grupoUsuarioRelacionamento(){
        return $this->hasMany(GrupoUsuarioRelacionamento::class, 'id', 'id_grupo');
    }
}