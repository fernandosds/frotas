<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\GrupoCercaRelacionamentos;


class GrupoCerca extends Model
{


    /**
     * @var string
     */
    protected $table = 'grupos_cercas';


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

    public function grupoCercaRelacionamento(){
        return $this->hasMany(GrupoCercaRelacionamento::class, 'grupo_id', 'id');
    }
}
