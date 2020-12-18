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
                    type: 'POST',
                    url: '{{url("boardings/test-device")}}',
                    data: {
                        'device' : device_number,
                        '_token' : '{{ csrf_token() }}'
                    },
                    success: function (response) {

                        if(response.status == "success"){

                            var battery_level = response.battery_level;

                            $('#last-transmission').html(response.last_transmission)
                            $('#nivel-bateria').html(battery_level)

                            if( parseInt(battery_level) < 20 ) {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-empty');
                            } else if( parseInt(battery_level) < 40 ){
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-quarter');
                            }else if( parseInt(battery_level) < 60 ){
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-half');
                            }else if( parseInt(battery_level) < 80 ){
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-three-quarters');
                            }else {
                                $('#icon-nivel-bateria').addClass('fa fa-2x fa-battery-full');
                            }

                        }else{
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


                        /*

*/

                    }
                })


            })

        });
    </script>
@endsection