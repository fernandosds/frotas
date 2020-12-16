@extends('layouts.app')

@section('content')

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

    <form class="kt-form kt-form--label-right" id="form-create-device">
        @csrf

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
                    <label for="">Isca</label><br />
                    <h4 for="" id="test-device-code">---</h4>
                </div>
                <div class="form-group col-md-2">
                    <label for="">Última Transmissão</label><br />
                    <h4 for="" id="last-transmission">---</h4>
                </div>
                <div class="form-group col-md-2">
                    <label for="">Nível de Bateria</label><br />
                    <h4 for="" id="nivel-bateria">---</h4>
                </div>
                <div class="form-group col-md-2">
                    <label for="">Tipo</label><br />
                    <h4 for="" id="device-tipo">---</h4>
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

            $('#btn-find-device').click(function(){

                var loading = '<i class="fa fa-spinner fa-pulse"></i>';
                $("#test-device-code").html(loading);
                $("#device-tipo").html(loading);
                $('#last-transmission').html(loading)
                $('#nivel-bateria').html(loading)

                var device_number = $('#device_number').val();
                var device_tipo = 'Autônoma';

                $("#test-device-code").html(device_number);
                $("#device-tipo").html(device_tipo);


                $.ajax({
                    type: 'GET',
                    url: '{{url("api-device/test")}}/'+device_number,
                    success: function(response){

                        $('#last-transmission').html(response.body[0].dh_gps)
                        $('#nivel-bateria').html(response.body[0].nivel_bateria)
                    }
                })


            })

        });
    </script>
@endsection