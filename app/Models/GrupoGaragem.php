<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\GrupoGaragemRelacionamentos;
use App\Models\GrupoAlertaGaragem;


class GrupoGaragem extends Model
{


    /**
     * @var string
     */
    protected $table = 'grupos_garagem';


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
            'nome'               => $this->nome,
            'id_usuario'         => $this->id_usuario,
            'status'             => $this->status
        ];
    }

    public function grupoGaragemRelacionamento(){
        return $this->hasMany(GrupoGaragemRelacionamento::class, 'grupo_id', 'id');
    }

    public function grupoAlertaGaragem(){
        return $this->hasMany(GrupoAlertaGaragem::class , 'id_grupo_garagem', 'id');
    }

}
