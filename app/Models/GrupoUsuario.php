<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function grupoCercaRelacionamento(){
        return $this->belongsToMany(GrupoCercaRelacionamento::class, 'id', 'grupo_id');
    }
}