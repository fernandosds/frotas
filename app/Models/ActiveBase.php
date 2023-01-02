<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveBase extends Model
{
    protected $connection = 'bi';
    protected $table = 'BI_ACTIVE_BASE';

    protected $fillable = [
        'cliente',
        'data_instalacao',
        'chassis',
        'cod_empresa',
        'cidade',
        'estado',
        'empresa',
        'versao',
        'ultima_transmissao',
        'latitude',
        'longitude',
        'point',
        'iccid',
        'telefone',
        'placa',
        'status',
        'modelo',
        'operadora',
        'qtd_dispositivos',
        'categoria_veiculo',
        'dif_date',
        'r12s_proximos',
        'modelo_veiculo_aprimorado',
        'codigo_fipe',
        'modelo_veiculo',
        'frota',
    ];
}
