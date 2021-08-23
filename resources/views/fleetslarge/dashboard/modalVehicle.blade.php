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

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
