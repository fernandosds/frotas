@extends('layouts.app')

@section('styles')
    <style>
        .div-exemplo{
            margin-top: 30px;
            display: none
        }
    </style>
@endsection

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

                    </div>

                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="col-lg-12 ml-lg-auto">
                            <button type="button" class="btn btn-brand" id="btn-device-save">Importar</button>
                            <a href="{{url('production/devices')}}" class="btn btn-secondary">Voltar</a>

                            <div class="pull-right">
                                <a href="#" id="btn-show-exemple"><i class="kt-menu__ver-arrow la la-angle-down"></i> Ver exemplo de planilha</a>
                            </div>
                        </div>
                    </div>


                    <div class="row div-exemplo">
                        <hr />
                        <div class="row justify-content-md-center ">
                            <div class="col col-lg-2">
                                <img src="{{url('exemplo.png')}}" width="200px"/>
                            </div>
                            <div class="col col-lg-4">
                                <div class="center"><h4 class="alert-heading">Exemplo!</h4></div>

                                <ul>
                                    <li>A planilha deve conter duas colunas, a primeira contendo o modelo e a segunda contendo o ID da tecnologia.</li>
                                    <li>Não deve conter cabeçalho.</li>
                                    <li>Os IDS das tecnologias são os seguintes:
                                        <ul>
                                            @foreach($technologies as $technologie)
                                                <li><b>{{$technologie->id}}</b> => {{$technologie->type}}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>


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

        $("#btn-show-exemple").click(function(){
            $('.div-exemplo').show('100');
        })

        $('#btn-device-save').click(function() {

            //var formData = new FormData(this);
            var formData = new FormData(document.querySelector("#form-create-device"));

            $.ajax({
                url: '{{url("/production/devices/save")}}',
                type: 'POST',
                data: formData,
                success: function(response) {

                    if (response.status == "success") {

                        if(response.message > 0){
                            Swal.fire({
                                type: 'success',
                                title: response.message + " dispositivos importados!",
                                showConfirmButton: true,
                                timer: 10000
                            })
                            window.location.href = '{{url("/production/devices")}}'
                        }else{
                            Swal.fire({
                                type: 'warning',
                                title: 'Nenhum arquivo importado!',
                                text: 'Os dispositivos já devem existir no sistema ou a planilha esta fora do padrão!',
                                showConfirmButton: true,
                                timer: 10000
                            })
                        }

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro ao tentar salvar!' + response.message,
                            showConfirmButton: true,
                            timer: 10000
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
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', function() {
                        }, false);
                    }
                    return myXhr;
                }
            });

        });

    });
</script>
@endsection