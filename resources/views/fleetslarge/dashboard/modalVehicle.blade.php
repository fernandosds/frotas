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
                            <input type="text" id="cliente" name="cliente" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Empresa</label>
                            <input type="text" id="empresa" name="empresa" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Filial</label>
                            <input type="text" id="filial" name="filial" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Cód. Empresa</label>
                            <input type="text" id="cod_empresa" name="cod_empresa" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group  col-md-3">
                            <label for="inputName">Placa</label>
                            <input type="text" id="placa" name="placa" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group  col-md-4">
                            <label for="inputName">Chassis</label>
                            <input type="text" id="chassis" name="chassis" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group  col-md-3">
                            <label for="inputName">Data status do veículo</label>
                            <input type="text" id="status_veiculo_dt" name="status_veiculo_dt" class="form-control" maxlength="17" readonly>
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
                            <input type="text" id="modelo_veiculo" name="modelo_veiculo" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Categoria do Veículo</label>
                            <input type="text" id="categoria_veiculo" name="categoria_veiculo" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Código FIPE</label>
                            <input type="text" id="codigo_fipe" name="codigo_fipe" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="inputCpfCnpj">Sinistrado</label>
                            <input type="text" id="sinistrado" name="sinistrado" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCpfCnpj">Qtde. Dispositivo</label>
                            <input type="text" id="qtd_dispositivos" name="qtd_dispositivos" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Operadora</label>
                            <input type="text" id="operadora" name="operadora" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputAddress">Data de Instalação</label>
                            <input type="text" id="data_instalacao" name="data_instalacao" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">ICCID</label>
                            <input type="text" id="iccid" name="iccid" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Modelo</label>
                            <input type="text" id="modelo" name="modelo" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Última Transmissão</label>
                            <input type="text" id="lp_ultima_transmissao" name="lp_ultima_transmissao" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">Versão</label>
                            <input type="text" id="versao" name="versao" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">Status</label>
                            <input type="text" id="status" name="status" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Velocidade</label>
                            <input type="text" id="lp_velocidade" name="lp_velocidade" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputAddress">Point</label>
                            <input type="text" id="point" name="point" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Voltagem</label>
                            <input type="text" id="lp_voltagem" name="lp_voltagem" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">R12 próximos</label>
                            <input type="text" id="r12s_proximos" name="r12s_proximos" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">LP ignição</label>
                            <input type="text" id="lp_ignicao" name="lp_ignicao" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">LP satélite</label>
                            <input type="text" id="lp_satelite" name="lp_satelite" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Cidade</label>
                            <input type="text" id="cidade" name="cidade" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputAddress">Estado</label>
                            <input type="text" id="estado" name="estado" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Latitude</label>
                            <input type="text" id="lp_latitude" name="lp_latitude" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputComplement">Longitude</label>
                            <input type="text" id="lp_longitude" name="lp_longitude" class="form-control" maxlength="17" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Endereço veículo</label>
                            <input type="text" id="end_logradouro" name="end_logradouro" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputAddress">Bairro</label>
                            <input type="text" id="end_bairro" name="end_bairro" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">UF</label>
                            <input type="text" id="end_uf" name="end_uf" class="form-control" maxlength="17" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputComplement">CEP</label>
                            <input type="text" id="end_cep" name="end_cep" class="form-control" maxlength="17" readonly>
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
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Foto</label>
                        <iframe style="height:400px;width:600px;" title="Iframe Example" id="cliente_foto" name="cliente_foto"></iframe>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Nome</label>
                        <input type="text" id="cliente_nome" name="cliente_nome" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">CPF</label>
                        <input type="text" class="form-control" id="cliente_cpf" name="cliente_cpf" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Celular</label>
                        <input type="text" class="form-control" id="cliente_celular" name="cliente_celular" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Data Devolução</label>
                        <input type="text" id="cliente_datadev" name="cliente_datadev" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Local Devolução</label>
                        <input type="text" class="form-control" id="cliente_localdev" name="cliente_localdev" readonly>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputPassword4">Local de Retirada</label>
                        <input type="text" class="form-control" id="cliente_local_retirada" name="cliente_local_retirada" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">CNH</label>
                        <input type="text" class="form-control" id="cliente_cnh" name="cliente_cnh" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPassword4">Email</label>
                        <input type="text" class="form-control" id="cliente_email" name="cliente_email" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputEmail4">Foto CNH</label>
                        <iframe style="height:400px;width:600px;" title="Iframe Example" id="cliente_foto_cnh" name="cliente_foto_cnh"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
