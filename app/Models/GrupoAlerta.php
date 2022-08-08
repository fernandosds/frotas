<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\GrupoCercaRelacionamentos;

use App\Models\GrupoAlertaRelacionamento;


class GrupoAlerta extends Model
{


    /**
     * @var string
     */
    protected $table = 'grupos_alerta';


    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['id', 'nome', 'id_usuario', 'telephone', 'email','status'];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                 => $this->id,
            'nome'               => $this->nome,
            'id_usuario'         => $this->id_usuario,
            'telephone'          => $this->telephone,
            'email'              => $this->email,
            'status'             => $this->status
        ];
    }

    public function grupoAlertaRelacionamento(){
        return $this->hasMany(GrupoAlertaRelacionamento::class, 'id_grupo', 'id');
    }

    public function grupoUsuarioRelacionamento(){
        return $this->hasMany(GrupoUsuarioRelacionamento::class, 'id_grupo', 'id');
    }
}
