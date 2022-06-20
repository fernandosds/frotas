<div class="modal fade" id="modalVehiclePSA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-personalizado" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Registro do veículo <span id="modelo_veiculo_span"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4>Dados da Proposta</h4>
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Nº proposta PSA</h5>
                                <input type="text" id="contrato" name="proposta" class="form-control contrato" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                        <br />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4>Dados da Loja</h4>
                        <br />
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Nome</h5>
                                <input type="text" id="cliente" name="cliente" class="form-control cliente" maxlength="17" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Empresa</h5>
                                <input type="text" id="empresa" name="empresa" class="form-control empresa" maxlength="17" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Filial</h5>
                                <input type="text" id="filial" name="filial" class="form-control filial" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-2">
                                <h5>Cód. Empresa</h5>
                                <input type="text" id="cod_empresa" name="cod_empresa" class="form-control cod_empresa" maxlength="17" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Cidade</h5>
                                <input type="text" id="cidade" name="cidade" class="form-control cidade" maxlength="17" readonly>
                            </div>
                            <div class="col-6">
                                <h5>Estado</h5>
                                <input type="text" id="estado" name="estado" class="form-control estado" maxlength="17" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <br />
                <br />
                <div class="row">
                    <div class="col-12">
                        <h4>Dados do veículo</h4>
                        <br />
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Placa</h5>
                                <input type="text" id="placa" name="placa" class="form-control placa" maxlength="17" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Chassis</h5>
                                <input type="text" id="chassis" name="chassis" class="form-control chassis" maxlength="17" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Modelo do Veículo</h5>
                                <input type="text" id="modelo_veiculo" name="modelo_veiculo" class="form-control modelo_veiculo" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>Categoria do Veículo</h5>
                                <input type="text" id="categoria_veiculo" name="categoria_veiculo" class="form-control categoria_veiculo" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Status do veículo</h5>
                                <input type="text" id="status_veiculo" name="status_veiculo" class="form-control" maxlength="17" readonly>
                            </div>
                            <div class="col-6">
                                <h5>Data status do veículo</h5>
                                <input type="text" id="status_veiculo_dt" name="status_veiculo_dt" class="form-control status_veiculo_dt" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-6">
                                <h5>Endereço veículo</h5>
                                <input type="text" id="end_logradouro" name="end_logradouro" class="form-control end_logradouro" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Bairro</h5>
                                <input type="text" id="end_bairro" name="end_bairro" class="form-control end_bairro" maxlength="17" readonly>
                            </div>
                            <div class="col-2">
                                <h5>UF</h5>
                                <input type="text" id="end_uf" name="end_uf" class="form-control end_uf" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>CEP</h5>
                                <input type="text" id="end_cep" name="end_cep" class="form-control end_cep" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Veículo em loja</h5>
                                <input type="text" id="veiculo_em_loja" name="veiculo_em_loja" class="form-control" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Código FIPE</h5>
                                <input type="text" id="codigo_fipe" name="codigo_fipe" class="form-control codigo_fipe" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Sinistrado</h5>
                                <input type="text" id="sinistrado" name="sinistrado" class="form-control" maxlength="17" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <div class="col-12">
                        <h4>Dados do Rastreador</h4>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>Qtde. Dispositivo</h5>
                                <input type="text" id="qtd_dispositivos" name="qtd_dispositivos" class="form-control qtd_dispositivos" maxlength="17" readonly>
                            </div>
                            <div class="col-5">
                                <h5>Modelo</h5>
                                <input type="text" id="modelo" name="modelo" class="form-control modelo" maxlength="17" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Operadora</h5>
                                <input type="text" id="operadora" name="operadora" class="form-control operadora" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>ICCID</h5>
                                <input type="text" id="iccid" name="iccid" class="form-control iccid" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Telefone</h5>
                                <input type="text" id="telefone" name="telefone" class="form-control telefone" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Data de Instalação</h5>
                                <input type="text" id="data_instalacao" name="data_instalacao" class="form-control data_instalacao" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Status</h5>
                                <input type="text" id="status" name="status" class="form-control status" maxlength="17" readonly>
                            </div>
                        </div>
                        <br />
                    </div>
                </div>

                <br />
                <br />
                <div class="row">
                    <div class="col-12">
                        <h4>Dados de posicionamento</h4>
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Última Transmissão</h5>
                                <input type="text" id="lp_ultima_transmissao" name="lp_ultima_transmissao" class="form-control lp_ultima_transmissao" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Latitude</h5>
                                <input type="text" id="lp_latitude" name="lp_latitude" class="form-control lp_latitude" maxlength="17" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Longitude</h5>
                                <input type="text" id="lp_longitude" name="lp_longitude" class="form-control lp_longitude" readonly>
                            </div>
                            <div class="col-2">
                                <h5>Voltagem</h5>
                                <input type="text" class="form-control lp_voltagem" id="lp_voltagem" name="lp_voltagem" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>Operadora</h5>
                                <input type="text" class="form-control operadora" id="operadora" name="operadora" readonly>
                            </div>
                            <div class="col-4">
                                <h5>ICCID</h5>
                                <input type="text" class="form-control iccid" id="iccid" name="iccid" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Status</h5>
                                <input type="text" class="form-control status" id="status" name="status" readonly>
                            </div>
                            <div class="col-2">
                                <h5>Velocidade</h5>
                                <input type="text" class="form-control lp_velocidade" id="lp_velocidade" name="lp_velocidade" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row hidden" id="timeline">
                            <div class="col-12">
                                <br />
                                <h4>Timeline da solicitação</h4>
                                <section class="time-line-box">
                                    <div class="swiper-container text-center">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="timestamp"><span id="dt_entrada"></span></div>
                                                <div id="status_dt_entrada" class="status"><span>Entrada</span></div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="timestamp"><span id="dt_tecnico_acionado"></span></div>
                                                <div id="status_dt_tecnico_acionado" class="status"><span>Técnico acionado</span></div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="timestamp"><span id="dt_inicio_instalacao"></span></div>
                                                <div id="status_dt_inicio_instalacao" class="status"><span>Inicio instalação</span></div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="timestamp"><span id="dt_termino_instalacao"></span></div>
                                                <div id="status_dt_termino_instalacao" class="status"><span>Término instalação</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <br />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
