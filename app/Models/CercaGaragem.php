<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GrupoAlertaGaragem;

class CercaGaragem extends Model
{
    
    protected $table = 'cerca_garagem_relacionamento';

    protected $fillable = [
        'id',
        'id_garagem',
        'id_cerca',
        'created_at',
        'updated_at'
    ];

    public function grupoAlertaGaragem(){
        return $this->hasMany(GrupoAlertaGaragem::class, 'id_grupo_garagem', 'id_garagem');
    }

}