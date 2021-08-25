<div class="modal fade" id="modalVehicle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-personalizado" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Registro do veículo <span id="modelo_veiculo_span"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="kt-portlet__body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Cliente</label>
                            <input type="text" id="cliente" name="cliente" class="form-control cliente" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Empresa</label>
                            <input type="text" id="empresa" name="empresa" class="form-control empresa" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Filial</label>
                            <input type="text" id="filial" name="filial" class="form-control filial" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Cód. Empresa</label>
                            <input type="text" id="cod_empresa" name="cod_empresa" class="form-control cod_empresa" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group  col-md-3">
                            <label for="inputName">Placa</label>
                            <input type="text" id="placa" name="placa" class="form-control placa" maxlength="17" readonly>
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="inputName">Chassis</label>
                            <input type="text" id="chassis" name="chassis" class="form-control chassis" maxlength="17" readonly>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="inputName">Data status do veículo</label>
                            <input type="text" id="status_veiculo_dt" name="status_veiculo_dt" class="form-control status_veiculo_dt" maxlength="17" readonly>
                        </div>
                        <div class="form-group  col-md-2">
                            <label for="inputName">Status do veículo</label>
                            <input type="text" id="status_veiculo" name="status_veiculo" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Veículo em loja</label>
                            <input type="text" id="veiculo_em_loja" name="veiculo_em_loja" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputCpfCnpj">Modelo do Veículo</label>
                            <input type="text" id="modelo_veiculo" name="modelo_veiculo" class="form-control modelo_veiculo" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Categoria do Veículo</label>
                            <input type="text" id="categoria_veiculo" name="categoria_veiculo" class="form-control categoria_veiculo" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Código FIPE</label>
                            <input type="text" id="codigo_fipe" name="codigo_fipe" class="form-control codigo_fipe" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="inputCpfCnpj">Sinistrado</label>
                            <input type="text" id="sinistrado" name="sinistrado" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Qtde. Dispositivo</label>
                            <input type="text" id="qtd_dispositivos" name="qtd_dispositivos" class="form-control qtd_dispositivos" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Operadora</label>
                            <input type="text" id="operadora" name="operadora" class="form-control operadora" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputAddress">Data de Instalação</label>
                            <input type="text" id="data_instalacao" name="data_instalacao" class="form-control data_instalacao" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">ICCID</label>
                            <input type="text" id="iccid" name="iccid" class="form-control iccid" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control telefone" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control modelo" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Última Transmissão</label>
                            <input type="text" id="lp_ultima_transmissao" name="lp_ultima_transmissao" class="form-control lp_ultima_transmissao" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">Versão</label>
                            <input type="text" id="versao" name="versao" class="form-control versao" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">Status</label>
                            <input type="text" id="status" name="status" class="form-control status" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Velocidade</label>
                            <input type="text" id="lp_velocidade" name="lp_velocidade" class="form-control lp_velocidade" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Point</label>
                            <input type="text" id="point" name="point" class="form-control point" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Voltagem</label>
                            <input type="text" id="lp_voltagem" name="lp_voltagem" class="form-control lp_voltagem" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">R12 próximos</label>
                            <input type="text" id="r12s_proximos" name="r12s_proximos" class="form-control r12s_proximos" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">LP ignição</label>
                            <input type="text" id="lp_ignicao" name="lp_ignicao" class="form-control lp_ignicao" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">LP satélite</label>
                            <input type="text" id="lp_satelite" name="lp_satelite" class="form-control lp_satelite" maxlength="17" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Cidade</label>
                            <input type="text" id="cidade" name="cidade" class="form-control cidade" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Estado</label>
                            <input type="text" id="estado" name="estado" class="form-control estado" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Latitude</label>
                            <input type="text" id="lp_latitude" name="lp_latitude" class="form-control lp_latitude" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Longitude</label>
                            <input type="text" id="lp_longitude" name="lp_longitude" class="form-control lp_longitude" maxlength="17" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Endereço veículo</label>
                            <input type="text" id="end_logradouro" name="end_logradouro" class="form-control end_logradouro" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Bairro</label>
                            <input type="text" id="end_bairro" name="end_bairro" class="form-control end_bairro" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">UF</label>
                            <input type="text" id="end_uf" name="end_uf" class="form-control end_uf" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">CEP</label>
                            <input type="text" id="end_cep" name="end_cep" class="form-control end_cep" maxlength="17" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalClient" id="btn_cliente">Dados do cliente</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-personalizado" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dados do Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Dados do Cliente</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3"><iframe style="height:200px;width:300px;" title="Iframe Example" class="cliente_foto" name="cliente_foto"></iframe></div>
                    <div class="col-8">
                        <h4>Dados Pessoais</h4>
                        <br />
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Nome</h5>
                                <input type="text" id="cliente_nome" name="cliente_nome" class="form-control" readonly>
                            </div>
                            <div class="col-4">
                                <h5>CPF</h5>
                                <input type="text" class="form-control" id="cliente_cpf" name="cliente_cpf" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Celular</h5>
                                <input type="text" class="form-control" id="cliente_celular" name="cliente_celular" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-2">
                                <h5>CNH</h5>
                                <input type="text" class="form-control" id="cliente_cnh" name="cliente_cnh" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Email</h5>
                                <input type="text" class="form-control" id="cliente_email" name="cliente_email" readonly>
                            </div>
                            <div class="col-6">
                                <h5>Endereço</h5>
                                <input type="text" class="form-control" id="cliente_endereco" name="cliente_endereco" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <br />
                <br />
                <div class="row">
                    <div class="col-12">
                        <h4>Dados da Locação</h4>
                        <br />
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>Contrato</h5>
                                <input type="text" class="form-control" id="cliente_contrato" name="cliente_contrato" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Filial</h5>
                                <input type="text" id="filial" name="filial" class="form-control filial" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Local de Retirada</h5>
                                <input type="text" class="form-control" id="cliente_local_retirada" name="cliente_local_retirada" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Data de Retirada</h5>
                                <input type="text" class="form-control cliente_dataretirada" id="cliente_dataretirada" name="cliente_dataretirada" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Endereço</h5>
                                <input type="text" class="form-control end_logradouro" id="end_logradouro" name="end_logradouro" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Bairro</h5>
                                <input type="text" class="form-control end_bairro" id="end_bairro" name="end_bairro" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Cidade</h5>
                                <input type="text" class="form-control end_cidade" id="end_cidade" name="end_cidade" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-6">
                                <h5>Estado</h5>
                                <input type="text" class="form-control estado" id="estado" name="estado" readonly>
                            </div>
                            <div class="col-6">
                                <h5>UF</h5>
                                <input type="text" class="form-control end_uf" id="end_uf" name="end_uf" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-6">
                                <h5>Data devolução</h5>
                                <input type="text" class="form-control cliente_datadev" id="cliente_datadev" name="cliente_datadev" readonly>
                            </div>
                            <div class="col-6">
                                <h5>Loja devolução</h5>
                                <input type="text" class="form-control cliente_localdev" id="cliente_localdev" name="cliente_localdev" readonly>
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
                        <div class="row">
                            <div class="col-5">
                                <h5>Modelo</h5>
                                <input type="text" class="form-control modelo_veiculo" id="modelo_veiculo" name="modelo_veiculo" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Placa</h5>
                                <input type="text" id="placa" name="placa" class="form-control placa" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Chassis</h5>
                                <input type="text" class="form-control chassis" id="chassis" name="chassis" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-4">
                                <h5>Odômetro</h5>
                                <input type="text" class="form-control veiculo_odometro" id="veiculo_odometro" name="veiculo_odometro" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Categoria</h5>
                                <input type="text" class="form-control categoria_veiculo" id="categoria_veiculo" name="categoria_veiculo" readonly>
                            </div>
                            <div class="col-4">
                                <h5>Código FIPE</h5>
                                <input type="text" class="form-control codigo_fipe" id="codigo_fipe" name="codigo_fipe" readonly>
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
                            <div class="col-3">
                                <h5>Latitude</h5>
                                <input type="text" class="form-control lp_latitude" id="lp_latitude" name="lp_latitude" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Longitude</h5>
                                <input type="text" id="lp_longitude" name="lp_longitude" class="form-control lp_longitude" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Qtde dispositivo</h5>
                                <input type="text" class="form-control qtd_dispositivos" id="qtd_dispositivos" name="qtd_dispositivos" readonly>
                            </div>
                            <div class="col-3">
                                <h5>Data instalação</h5>
                                <input type="text" class="form-control data_instalacao" id="data_instalacao" name="data_instalacao" readonly>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>Operadora</h5>
                                <input type="text" class="form-control operadora" id="operadora" name="operadora" readonly>
                            </div>
                            <div class="col-3">
                                <h5>ICCID</h5>
                                <input type="text" class="form-control iccid" id="iccid" name="iccid" readonly>
                            </div>
                            <div class="col-2">
                                <h5>Status</h5>
                                <input type="text" class="form-control status" id="status" name="status" readonly>
                            </div>
                            <div class="col-2">
                                <h5>Velocidade</h5>
                                <input type="text" class="form-control lp_velocidade" id="lp_velocidade" name="lp_velocidade" readonly>
                            </div>
                            <div class="col-2">
                                <h5>Voltagem</h5>
                                <input type="text" class="form-control lp_voltagem" id="lp_voltagem" name="lp_voltagem" readonly>
                            </div>
                        </div>
                        <br />
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-12">
                        <h4>Anexos</h4>
                        <br />
                        <div class="row">
                            <div class="col-3">
                                <h5>Foto - Selfie</h5>
                                <a href="" class="btn btn-brand btn-icon cliente_foto" target="_blank"><span class="fa fa-camera-retro"></span></a>
                            </div>
                            <div class="col-3">
                                <h5>Foto - Habilitação</h5>
                                <a href="" class="btn btn-brand btn-icon" id="cliente_foto_cnh" target="_blank"><span class="fa fa-address-card"></span></a>
                            </div>
                        </div>
                        <br />
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
