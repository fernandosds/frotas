@extends('layouts.app')

@section('content')

<!-- HEADER -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

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

<form class="kt-form kt-form--label-right" id="form-create-device">
    

    @csrf

    <input type="hidden" name="device_id" id="device_id" />

    <div class="kt-portlet__body">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="">Isca 99a00004</label>
                <input type="text" name="device_number" id="device_number" class="form-control" maxlength="20" placeholder="Nº da Ísca">
            </div>
            <div class="form-group col-md-2">
                <label for="">&nbsp;</label><br />
                <button type="button" class="btn btn-primary" id="btn-find-device"><i class="fa fa-search"></i> Pesquisar </button>
            </div>

            <div class="form-group col-md-2">
                <i class="fa fa-2x fa-microchip"></i><br />
                <label for="">Isca</label><br />
                <h4 for="" id="test-device-code">---</h4>
            </div>
            <div class="form-group col-md-2">

                <i class="fa fa-2x fa-signal"></i><br />

                <label for="">Última Transmissão</label><br />
                <h4 for="" id="last-transmission">---</h4>
            </div>
            <div class="form-group col-md-2">


                <i class="fa fa-2x fa-battery-empty" id="icon-nivel-bateria"></i><br />

                <label for="">Nível de Bateria</label><br />
                <h4 for="" id="nivel-bateria">---</h4>
            </div>
            <div class="form-group col-md-2">

                <i class="fa fa-2x fa-cube"></i><br />
                <label for="">Tipo de ísca</label><br />
                <h4 for="" id="device-tipo">---</h4>
            </div>
        </div>

        <!-- ----- -->

        <input type="hidden" name="user_id" id="id" value="{{Auth::id()}}" />
        <div class="row">
            <div class="col-sm-8">
                <div class="kt-portlet__body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Origem</label>
                            <input type="text" name="source" class="form-control" value="{{ $boarding->source ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Ordem de Transporte</label>
                            <input type="text" class="form-control" name="transport_order" value="{{ $boarding->transport_order ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row ">
                        <div class="form-group col-md-6">
                            <label for="inputState">Destino</label>
                            <input type="text" class="form-control" name="destiny" value="{{ $boarding->destiny ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNeighborhood">Valor Transportado</label>
                            <input type="text" class="form-control" name="amount_carried" value="{{ $boarding->amount_carried ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Transportador</label>
                            <input type="text" class="form-control" name="transporter" value="{{ $boarding->transporter ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inpuCity">CPF/CNPJ</label>
                            <input type="text" class="form-control input_cpf_cnpj" name="cpf_cnpj" value="{{ $boarding->cpf_cnpj ?? '' }}">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Telefone</label>
                            <input type="text" id="input_cep_customers" class="form-control mask_input_contact" name="telephone" value="{{ $boarding->telephone ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Tel. Cel:</label>
                            <input type="text" class="form-control mask_input_contact" name="cell_phone" value="{{ $boarding->cell_phone ?? '' }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputComplement">Placa</label>
                            <input type="text" class="form-control" name="board" value="{{ $boarding->board ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNeighborhood">Marca</label>
                            <input type="text" class="form-control" name="brand" value="{{ $boarding->brand ?? '' }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNumber">Chassis</label>
                            <input type="text" class="form-control" name="chassis" value="{{ $boarding->chassis ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inpuCity">Modelo</label>
                            <input type="text" class="form-control" name="model" value="{{ $boarding->model ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNumber">Placas carretas</label>
                        <input type="text" class="form-control" name="carts_plates" value="{{ $boarding->carts_plates ?? '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inpuCity">Tecnologia Redundante</label>
                        <input type="text" class="form-control" name="redundant_technology" value="{{ $boarding->redundant_technology ?? '' }}">
                    </div>
                </div>

            </div>


            <div class="col-sm-4">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label class="inputType">Tipo de Carga</label>
                        <select class="form-control" name="type_of_load_id">
                            <option value=" ">Selecione um tipo</option>
                            @foreach ($typeofloads as $typeofload)
                            <option value="{{$typeofload->id}}">{{$typeofload->type}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
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
        </div>



        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12 ml-lg-auto">
                        <button type="button" class="btn btn-brand" id="btn-device-save">Cadastrar</button>
                        <a href="{{url('devices')}}" class="btn btn-secondary">Voltar</a>
                    </div>

                </div>
            </div>
        </div>
    </div>



</form>

@endsection

@section('scripts')
<script>
    $(function() {

        $('#btn-find-device').click(function() {

            if ($('#device_number').val() != "") {

                var loading = '<i class="fa fa-spinner fa-pulse"></i>';
                $("#test-device-code").html(loading);
                $("#device-tipo").html(loading);
                $('#last-transmission').html(loading)
                $('#nivel-bateria').html(loading)

                var device_number = $('#device_number').val();
                var device_tipo = $('#device-tipo').val();;

                //

                $.ajax({
                    type: 'POST',
                    url: '{{url("boardings/test-device")}}',
                    data: {
                        'device': device_number,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        if (response.status == "success") {

                            $('#device_id').val(response.device_id);

                            var battery_level = response.battery_level;

                            $("#test-device-code").html(response.model);
                            $('#last-transmission').html(response.last_transmission)
                            $('#nivel-bateria').html(battery_level)
                            $('#device-tipo').html(response.device_type)

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
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 2500
                            })
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

        $('#btn-device-save').click(function() {

            var boardings_id = $('#id').val();

            console.log($('form-create-device').serialize());

            ajax_store(boardings_id, "boardings", $('form-create-device').serialize());

        });

    });
</script>
@endsection