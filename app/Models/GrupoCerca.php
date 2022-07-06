<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


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

    protected $fillable = ['id', 'nome', 'id_usuario'];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'id'                 => $this->id,
            'nome'               => $this->nome,
            'id_usuario'         => $this->id_usuario
        ];
    }
}
