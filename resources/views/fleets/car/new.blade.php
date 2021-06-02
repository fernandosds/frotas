@extends('layouts.app')


@section('content')

<div class="kt-portlet">
    <div class="kt-portlet kt-portlet--mobile">

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

        <form class="kt-form kt-form--label-right" id="form-create-car">

            <input type="hidden" name="id" id="id" value="{{ $car->id ?? '' }}" />

            @csrf
            <div class="kt-portlet__body">
                <div class="form-row">
                    <div class="form-group  col-md-4">
                        <label for="inputName">Placa</label>
                        <div class="input-group">

                            <input type="text" name="placa" id="inputplaca" class="form-control" value="MAP2020{{ $car->placa ?? '' }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" id="btn-search-placa" type="button">Verificar</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputCpfCnpj">Chassi</label>
                        <input type="text" id="input_chassi" name="chassi" class="form-control" maxlength="17" value="{{ $car->chassi ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Modelo</label>
                        <input type="text" class="form-control" name="model" value="{{ $car->model ?? '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputAddress">Montadora</label>
                        <input type="text" id="input_automaker" class="form-control" name="automaker" value="{{ $car->automaker ?? '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputComplement">Ano Fabricação</label>
                        <input type="text" class="form-control" name="year" value="{{ $car->year ?? '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputNumber">Cor</label>
                        <input type="text" class="form-control" name="color" value="{{ $car->color ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inpuCity">Tipo (caminhão, passeio, etc...)</label>
                        <input type="text" class="form-control" name="type" value="{{ $car->type ?? '' }}">
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12 ml-lg-auto">
                                <button type="button" class="btn btn-brand" id="btn-car-save">Cadastrar</button>
                                <a href="{{url('fleets/cars')}}" class="btn btn-secondary">Voltar</a>
                            </div>
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
    /**
         Gravar carro
         */
    $(function() {

        var car_id = $('#id').val();

        $('#btn-car-save').click(function() {
            ajax_store(car_id, "fleets/cars", $('#form-create-car').serialize());
        });

    });


    /**
     Pesquisar placa de carro
     */
    $(function() {


        $('#btn-search-placa').click(function() {
            var placa = $('#inputplaca').val();
            var url = "{{url('')}}/api-device/get-device/" + placa;

            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    if (response.status == "success") {
                        $('#input_chassi').val(response.data.chassi);
                        $('input[name=automaker]').val(response.data.marca);
                        $('input[name=model]').val(response.data.modelo);
                        $('input[name=year]').val(response.data.ano);
                        $('input[name=color]').val(response.data.cor);
                        $('input[name=type]').val(response.data.categoria);

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Vaículo não encontrado na base de dados.',
                            showConfirmButton: true,
                            timer: 10000
                        })
                        $("#input-search").val('')
                        $("#btn-search").html('<i class="fa fa-search"></i>')
                    }
                    //alert(response);

                }
            });
            //return false;
        });

    });
</script>
@endsection