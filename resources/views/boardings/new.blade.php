@extends('layouts.app')

@section('styles')
    <style>
        #div-paring{
            display: none;
        }
    </style>
@endsection

@section('content')

    <div class="kt-portlet">

        <!-- HEADER -->
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand {{$icon}}"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{$title}} <small>Novo</small>
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="">Isca <small>99A00105</small></label>
                    <input type="text" name="device_number" id="device_number" class="form-control" maxlength="20" placeholder="Nº da Ísca">
                </div>
                <div class="form-group col-md-2">
                    <label for="">&nbsp;</label><br />
                    <button type="button" class="btn btn-primary" id="btn-find-device"><i class="fa fa-search"></i> Pesquisar </button>
                </div>

                <div class="form-group col-xs-6 col-md-2">
                    <i class="fa fa-2x fa-microchip"></i><br />
                    <label for="">Isca</label><br />
                    <h4 for="" id="test-device-code">---</h4>
                </div>
                <div class="form-group col-xs-6 col-md-2">
                    <i class="fa fa-2x fa-signal"></i><br />
                    <label for="">Última Transmissão</label><br />
                    <h4 for="" id="last-transmission">---</h4>
                </div>
                <div class="form-group col-xs-6 col-md-2">
                    <i class="fa fa-2x fa-battery-empty" id="icon-nivel-bateria"></i><br />
                    <label for="">Nível de Bateria</label><br />
                    <h4 for="" id="nivel-bateria">---</h4>
                </div>
                <div class="form-group col-xs-6 col-md-2">
                    <i class="fa fa-2x fa-cube"></i><br />
                    <label for="">Tipo de ísca</label><br />
                    <h4 for="" id="device-tipo">---</h4>
                </div>

            </div>
        </div>
    </div>

    <div class="kt-portlet hidden" id="div-new-boarding">
        <div class="kt-portlet kt-portlet--mobile">

            <form class="kt-form kt-form--label-right" id="form-create-boarding">

                @csrf
                <input type="hidden" name="id" id="id" value="{{ $boarding->id ?? '' }}" />
                <input type="hidden" name="device_id" id="device_id" />
                <input type="hidden" name="contract_id" id="contract_id" />

                <div class="kt-portlet__body">
                <!-- ----- -->

                    <div class="row ">

                        <div class="col-sm-12">

                            <h4><i class="fa fa-truck"></i> Transportadora</h4><hr />

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inpuCity">CPF/CNPJ</label>
                                    <input type="text" class="form-control input_cpf_cnpj" name="cpf_cnpj" value="{{ $boarding->cpf_cnpj ?? '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAddress">Nome da Transportador</label>
                                    <input type="text" class="form-control" name="transporter" value="{{ $boarding->transporter ?? '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputAddress">Telefone</label>
                                    <input type="text" id="input_cep_customers" class="form-control mask_input_contact" name="telephone" value="{{ $boarding->telephone ?? '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputState">Tel. Cel:</label>
                                    <input type="text" class="form-control mask_input_contact" name="cell_phone" value="{{ $boarding->cell_phone ?? '' }}">
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12">

                            <h4><i class="fa fa-info-circle"></i> Dados do Transporte</h4><hr />

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputName">Origem</label>
                                    <input type="text" name="source" class="form-control" value="{{ $boarding->source ?? '' }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Destino</label>
                                    <input type="text" class="form-control" name="destiny" value="{{ $boarding->destiny ?? '' }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="inputState">Duração aproximada (Horas)</label>
                                    <input type="number" max="1" min="50" class="form-control" name="duration" value="{{ $boarding->duration ?? '3' }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="inputState">Nº Ordem de Transporte</label>
                                    <input type="text" class="form-control" name="transport_order" value="{{ $boarding->transport_order ?? '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputNeighborhood">Valor Transportado</label>
                                    <input type="text" class="form-control" name="amount_carried" value="{{ $boarding->amount_carried ?? '' }}">
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12">

                            <h4><i class="fa fa-box"></i> Carga</h4><hr />

                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="inputComplement">Placa</label>
                                    <input type="text" class="form-control" name="board" maxlength="7" value="MAP2020{{ $boarding->board ?? '' }}" id="input-placa" >
                                    <span id="search-placa"></span>
                                </div>

                                <div class="form-group col-md-2">
                                    <!--<input type="text" name="device_paring" id="hidden_device_paring" />-->
                                    <label for="inputComplement">Dispositivo</label>
                                    <input type="text" class="form-control" name="pair_device" value="" id="input_pair_device" readonly="readonly" >
                                    <span id="search-placa"></span>
                                </div>

                                <div class="col-md-8" id="div-paring">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="inputComplement">Parear?</label>
                                            <select class="form-control" name="paring">
                                                <option value="sim">Sim</option>
                                                <option value="nao">Não</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-10">
                                            <label for="inputComplement">&nbsp;</label>
                                            <div class="kt-section">
                                                <div class="kt-section__content">
                                                    <div class="alert alert-warning" role="alert">
                                                        <strong>ATENÇÃO!</strong> <i class="fa fa-hand-o-left"></i>
                                                        Este veículo possui rastreador, você deseja vincular esta ísca a ao rastreador
                                                        existente neste veículo?
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputNeighborhood">Marca</label>
                                    <input type="text" class="form-control" name="brand" id="brand" value="{{ $boarding->brand ?? '' }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputNumber">Chassis</label>
                                    <input type="text" class="form-control" name="chassis" id= "chassi" value="{{ $boarding->chassis ?? '' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inpuCity">Modelo</label>
                                    <input type="text" class="form-control" name="model" id= "model" value="{{ $boarding->model ?? '' }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="inputType">Tipo de Carga</label>
                                    <select class="form-control" name="type_of_load_id">
                                        <option value=" ">Selecione um tipo</option>
                                        @foreach ($typeofloads as $typeofload)
                                            <option value="{{$typeofload->id}}">{{$typeofload->type}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="inputType">Local de Acomodação</label>
                                    <select id="accommodation_location_id" class="form-control" name="accommodation_location_id">
                                        <option value=" ">Selecione um tipo</option>
                                        @foreach ($accommodationlocations as $accommodationlocation)
                                            <option value="{{$accommodationlocation->id}}">{{$accommodationlocation->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 center">
                            <hr />
                            <div class="col-lg-12 ml-lg-auto">
                                <button type="button" class="btn btn-brand" id="btn-boarding-save"><i class="fa fa-fire"></i> Ativar</button>
                                <a href="{{url('devices')}}" class="btn btn-secondary">Voltar</a>
                            </div>
                        </div>

                    </div>

                </div>

            </form>
        </div>

    </div>

@endsection

@section('scripts')
<script>
    $(function() {

        $('#input-placa').focusout(function(){

            $('#search-placa').html('<i class="fa fa-spinner fa-pulse"></i> Pesquisando rastreador...')

            var placa = $('#input-placa').val();

            if(placa.length > 5 ){

                $.ajax({
                    type: 'GET',
                    url: '{{url("api-device/get-device")}}/' + placa,
                    success: function (response) {

                        if(response.status == "success"){
                            $('#search-placa').remove();
                            $('#div-paring').show()

                            $('#input_pair_device').val(response.data.device)
                            $('#brand').val(response.data.marca)
                            $('#chassi').val(response.data.chassi)
                            $('#model').val(response.data.modelo)

                        }else{
                            $('#div-paring').hide()

                            $('#input_pair_device').val('')
                            $('#brand').val('')
                            $('#chassi').val('')
                            $('#model').val('')

                            $('#search-placa').html('<i class="fa fa-warning"></i> Este veículo não possui rastreador.')
                        }

                        console.log(response)
                    }
                });

            }

        })

        $('#btn-find-device').click(function() {

            if ($('#device_number').val() != "") {

                device_number = $('#device_number').val();

                var loading = '<i class="fa fa-spinner fa-pulse"></i>';
                $("#test-device-code").html(loading);
                $("#device-tipo").html(loading);
                $('#last-transmission').html(loading)
                $('#nivel-bateria').html(loading)

                $.ajax({
                    type: 'GET',
                    url: '{{url("boardings/test-device")}}/'+device_number,
                    success: function(response) {

                        if (response.status == "success") {

                            $("#div-new-boarding").removeClass('hidden')

                            $('#device_id').val(response.device_id);
                            $('#contract_id').val(response.contract_id);

                            var battery_level = response.battery_level;

                            $("#test-device-code").html(response.model);
                            $('#last-transmission').html(response.last_transmission)
                            $('#nivel-bateria').html(battery_level)
                            $('#device-tipo').html(response.device_type)

                            $('#icon-nivel-bateria').removeClass('fa fa-2x fa-battery-empty');
                            $('#icon-nivel-bateria').removeClass('fa fa-2x fa-battery-quarter');
                            $('#icon-nivel-bateria').removeClass('fa fa-2x fa-battery-half');
                            $('#icon-nivel-bateria').removeClass('fa fa-2x fa-battery-three-quarters');
                            $('#icon-nivel-bateria').removeClass('fa fa-2x fa-battery-full');

                            if (parseInt(battery_level) < 20) {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-empty');
                            } else if (parseInt(battery_level) < 40) {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-quarter');
                            } else if (parseInt(battery_level) < 60) {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-half');
                            } else if (parseInt(battery_level) < 80) {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-three-quarters');
                            } else {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-full');
                            }

                        } else {

                            $("#test-device-code").html('---');
                            $("#device-tipo").html('---');
                            $('#last-transmission').html('---')
                            $('#nivel-bateria').html('---')

                            if(alert){
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                    showConfirmButton: true,
                                    timer: 2500
                                })
                            }


                        }

                    }
                })


            } else {
                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Informe o número da Ísca',
                    showConfirmButton: true,
                    timer: 2500
                })
            }

        })

    });

    /**
        Gravar Embarques
    */
    $(function() {

        $('#btn-boarding-save').click(function() {
            var boarding_id = $('#id').val();
            ajax_store(boarding_id, "boardings", $('#form-create-boarding').serialize());
        });

    });
</script>
@endsection