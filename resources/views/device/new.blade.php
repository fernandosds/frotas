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

            <form class="kt-form kt-form--label-right" id="form-create-device" method="post" enctype="multipart/form-data">
                @csrf

                <div class="kt-portlet__body">
                    <div class="form-row">

                        <input name="file" type="file" class="form-control" />

                        <!--
                        <div class="form-group col-md-6">
                            <label for="inputSerialNumber">Modelo</label>
                            <input type="text" name="model" class="form-control" value="{{ $device->model ?? '' }}">
                        </div>
                        -->

                    </div>


                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="col-lg-12 ml-lg-auto">
                            <button type="button" class="btn btn-brand" id="btn-device-save">Importar</button>
                            <a href="{{url('devices')}}" class="btn btn-secondary">Voltar</a>
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

        //$('#form-create-device').click(function() {
        $('#btn-device-save').click(function() {

            //var formData = new FormData(this);
            var formData = new FormData(document.querySelector("#form-create-device"));

            $.ajax({
                url: '{{url("/devices/save")}}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Registro salvo com sucesso',
                            showConfirmButton: true,
                            timer: 3000
                        }).then((result) => {
                            $(location).attr('href', '<?php echo e(url("")); ?>/' + route);
                        })

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro ao tentar salvar!' + response.message,
                            showConfirmButton: true,
                            timer: 2500
                        })
                    }
                },
                error: function(error) {

                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'O arquivo não esta no formato correto, necessário ter 2 colunas contendo numero de série e id do tipo de tecnologia',
                        footer: ' '
                    })

                },
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() { // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                        myXhr.upload.addEventListener('progress', function() {
                            /* faz alguma coisa durante o progresso do upload */
                        }, false);
                    }
                    return myXhr;
                }
            });

        });

    });
</script>
@endsection