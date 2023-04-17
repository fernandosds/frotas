<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BancoPSA extends Model
{


    /**
     * @var string
     */
    protected $table = 'BI_BASE_PSA';
    protected $connection = 'bi';

    protected $fillable = [
        'contrato',
        'cliente',
        'data_instalacao',
        'chassis',
        'cod_empresa',
        'cidade',
        'estado',
        'empresa',
        'versao',
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
        'sinistrado',
        'status_veiculo',
        'veiculo_em_loja',
        'filial',
        'lp_ignicao',
        'lp_ultima_transmissao',
        'lp_latitude',
        'lp_longitude',
        'lp_velocidade',
        'lp_satelite',
        'lp_voltagem',
        'status_veiculo_dt',
        'end_logradouro',
        'end_bairro',
        'end_cidade',
        'end_uf',
        'end_cep',
        'dt_entrada',
        'dt_tecnico_acionado',
        'dt_inicio_instalacao',
        'dt_termino_instalacao',
        't_acionamento_tecnico',
        't_inicio_servico',
        't_instalacao',
        't_solicitado_instalado',
        'projeto',
        'situacao',
        'lp_ultima_transmissao_real',
        'event_violacao',
        'event_encerrado',
        'manutencao'


    ];

    /**
     * @return array
     */
    public function format()
    {
        return [
            'contrato'                          => $this->contrato,
            'cliente'                           => $this->cliente,
            'data_instalacao'                   => $this->data_instalacao,
            'chassis'                           => $this->chassis,
            'cod_empresa'                       => $this->cod_empresa,
            'cidade'                            => $this->cidade,
            'estado'                            => $this->estado,
            'empresa'                           => $this->empresa,
            'versao'                            => $this->versao,
            'point'                             => $this->point,
            'iccid'                             => $this->iccid,
            'telefone'                          => $this->telefone,
            'placa'                             => $this->placa,
            'status'                            => $this->status,
            'modelo'                            => $this->modelo,
            'operadora'                         => $this->operadora,
            'qtd_dispositivos'                  => $this->qtd_dispositivos,
            'categoria_veiculo'                 => $this->categoria_veiculo,
            'dif_date'                          => $this->dif_date,
            'r12s_proximos'                     => $this->r12s_proximos,
            'modelo_veiculo_aprimorado'         => $this->modelo_veiculo_aprimorado,
            'codigo_fipe'                       => $this->codigo_fipe,
            'modelo_veiculo'                    => $this->modelo_veiculo,
            'sinistrado'                        => $this->sinistrado,
            'status_veiculo'                    => $this->status_veiculo,
            'veiculo_em_loja'                   => $this->veiculo_em_loja,
            'filial'                            => $this->filial,
            'lp_ignicao'                        => $this->lp_ignicao,
            'lp_ultima_transmissao'             => $this->lp_ultima_transmissao,
            'lp_latitude'                       => $this->lp_latitude,
            'lp_longitude'                      => $this->lp_longitude,
            'lp_velocidade'                     => $this->lp_velocidade,
            'lp_satelite'                       => $this->lp_satelite,
            'lp_voltagem'                       => $this->lp_voltagem,
            'status_veiculo_dt'                 => $this->status_veiculo_dt,
            'end_logradouro'                    => $this->end_logradouro,
            'end_bairro'                        => $this->end_bairro,
            'end_cidade'                        => $this->end_cidade,
            'end_uf'                            => $this->end_uf,
            'end_cep'                           => $this->end_cep,
            'dt_entrada'                        => $this->dt_entrada,
            'dt_tecnico_acionado'               => $this->dt_tecnico_acionado,
            'dt_inicio_instalacao'              => $this->dt_inicio_instalacao,
            'dt_termino_instalacao'             => $this->dt_termino_instalacao,
            't_acionamento_tecnico'             => $this->t_acionamento_tecnico,
            't_inicio_servico'                  => $this->t_inicio_servico,
            't_instalacao'                      => $this->t_instalacao,
            't_solicitado_instalado'            => $this->t_solicitado_instalado,
            'projeto'                           => $this->projeto,
            'situacao'                          => $this->situacao,
        ];
    }
}
