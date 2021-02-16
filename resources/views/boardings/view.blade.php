@extends('layouts.app')

@section('content')


    <div class="kt-portlet" id="">

        <div class="kt-portlet kt-portlet--mobile">

                <div class="kt-portlet__body">

                    <div class="row">

                        <div class="col-sm-12">

                            <h5>
                                <b>ID:</b> {{$boarding->id}} &nbsp; | &nbsp;
                                <b>Usuário:</b> {{$boarding->user->name}} &nbsp; | &nbsp;
                                <b>Data:</b> {{date_format($boarding->created_at, "d/m/Y")}} &nbsp; | &nbsp;
                                <b>Status:</b> @if($boarding->active == 0) Finalizado @else Ativo @endif |
                                <a href="{{url('monitoring')}}/{{$boarding->device->model}}"><i class="fa fa-map-marker"></i> Monitorar no Mapa</a>
                            </h5>
                            <hr />

                            <h5><i class="fa fa-truck"></i> Transportadora</h5><hr />

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inpuCity">CPF/CNPJ</label>
                                    <input type="text" class="form-control input_cpf_cnpj" name="cpf_cnpj" value="{{ $boarding->cpf_cnpj ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Nome da Transportador</label>
                                    <input type="text" class="form-control" name="transporter" value="{{ $boarding->transporter ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputAddress">Telefone</label>
                                    <input type="text" id="input_cep_customers" class="form-control mask_input_contact" name="telephone" value="{{ $boarding->telephone ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputState">Tel. Cel:</label>
                                    <input type="text" class="form-control mask_input_contact" name="cell_phone" value="{{ $boarding->cell_phone ?? '' }}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12">

                            <h5><i class="fa fa-info-circle"></i> Dados do Transporte</h5><hr />

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputName">Origem</label>
                                    <input type="text" name="source" class="form-control" value="{{ $boarding->source ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Destino</label>
                                    <input type="text" class="form-control" name="destiny" value="{{ $boarding->destiny ?? '' }}" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="inputState">Duração aproximada (Horas)</label>
                                    <input type="number" max="1" min="50" class="form-control" name="duration" value="{{ $boarding->duration ?? '3' }}" readonly>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="inputState">Nº Ordem de Transporte</label>
                                    <input type="text" class="form-control" name="transport_order" value="{{ $boarding->transport_order ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputNeighborhood">Valor Transportado</label>
                                    <input type="text" class="form-control" name="amount_carried" value="{{ $boarding->amount_carried ?? '' }}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12">

                            <h5><i class="fa fa-box"></i> Carga</h5><hr />

                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="inputComplement">Placa</label>
                                    <input type="text" class="form-control" name="board" maxlength="7" value="{{ $boarding->board ?? '' }}" id="input-placa"  readonly>
                                    <span id="search-placa"></span>
                                </div>

                                <div class="form-group col-md-2">
                                    <!--<input type="text" name="device_paring" id="hidden_device_paring" />-->
                                    <label for="inputComplement">Dispositivo</label>
                                    <input type="text" class="form-control" name="pair_device" value="{{ $boarding->pair_device ?? '' }}" id="input_pair_device" readonly="readonly"  readonly>
                                    <span id="search-placa"></span>
                                </div>

                                <div class="col-md-8" id="div-paring">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputComplement">Pareado</label>
                                            <input type="text" class="form-control" name="paring" value=" @if($boarding->paring) == 1 ) Sim @else Nao @endif " id="paring" readonly="readonly"  readonly>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputNeighborhood">Marca</label>
                                    <input type="text" class="form-control" name="brand" id="brand" value="{{ $boarding->brand ?? '' }}" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputNumber">Chassis</label>
                                    <input type="text" class="form-control" name="chassis" id= "chassi" value="{{ $boarding->chassis ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inpuCity">Modelo</label>
                                    <input type="text" class="form-control" name="model" id= "model" value="{{ $boarding->model ?? '' }}" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="inputType">Tipo de Carga</label>
                                    <input type="text" class="form-control" name="model" id= "model" value="{{ $boarding->type_of_load_id ?? '' }}" readonly>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="inputType">Local de Acomodação</label>
                                    <input type="text" class="form-control" name="model" id= "model" value="{{ $boarding->accommodation_location_id ?? '' }}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 center">
                            <hr />
                            <div class="col-lg-12 ml-lg-auto">
                                <a href="{{url('boardings')}}" class="btn btn-secondary">Voltar</a>
                            </div>
                        </div>

                    </div>

                </div>

        </div>

    </div>

@endsection

