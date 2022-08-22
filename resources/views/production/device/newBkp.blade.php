@extends('layouts.app')

@section('styles')
<style>
.div-btn-isca {
    display: none
}

.div-btn-movel {
    display: none
}

.div-exemplo-isca {
    margin-top: 30px;
    display: none
}

.div-exemplo-movel {
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

                    @if (!isset($device->id))
                    {{$title}} <small>Novo</small>
                    @else
                    {{$title}} <small>Alterar</small>
                    @endif

                </h3>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if (!isset($device->id))
        <div class="row">
            <div class="col-sm-8">
                <form class="kt-form kt-form--label-right" id="form-create-device" method="post"
                    enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label>Cadastro manual</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input"> Verifique modelo existente</label>
                        <select class="form-control">
                            <option selected>
                                {{ isset($device->model) ? $device->model : null }}
                            </option>
                            @foreach( $devices as $model )
                            <option value="{{$model->id}}" {{ $model->id == $model->id}}>
                                {{$model->id}}-{{$model->model}}
                            </option>
                            @endforeach
                        </select><br /><br />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Modelo :
                            <input type="Text" id="model" name="model" maxlength="8"
                                onkeyup="this.value = this.value.toUpperCase();">
                        </label>
                    </div>
                    <div class="row kt-margin-b-20">
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <label for="input">Selecione um cliente</label>
                                <select class="form-control" name="customer_id" id="customer_id">
                                    <option selected>
                                        {{ isset($device->customer->name) ? $device->customer->name : null }}
                                    </option>
                                    @foreach( $customers as $customer )
                                    <option value="{{$customer->id}}" {{ $customer->id == $customer->id}}>
                                        {{$customer->id}}-{{$customer->name}}
                                    </option>
                                    @endforeach
                                </select><br /><br />
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <div class="form-row">
                                    <label for="input">Selecione uma bateria</label>
                                    <select class="form-control" name="tecnologie_id" id="tecnologie_id">
                                        <option selected>
                                            {{ isset($device->technologie->type) ? $device->technologie->type : null }}
                                        </option>
                                        @foreach( $technologies as $technologie )
                                        <option value="{{$technologie->id}}" {{ $technologie->id == $technologie->id}}>
                                            {{$technologie->id}}-{{$technologie->type}}
                                        </option>
                                        @endforeach
                                    </select><br /><br />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <div class="form-row">
                                    <label for="input">Selecione Tipo</label>
                                    <select class="form-control" name="tipo" id="tipo">
                                        <option selected>
                                            {{ isset($device->tipo) ? $device->tipo : null }}</option>
                                        <option value="isca">isca</option>
                                        <option value="dispositivo">dispositivo</option>
                                    </select><br /><br />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="modal-footer">
                                <a href="{{url('production/devices')}}" class="btn btn-secondary">Voltar</a>
                                <button type="button" class="btn btn-primary" id="btn-device-newone">Salvar</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row kt-margin-b-20">
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <label>Cadastro automático por importação de arquivo</label>
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <div class="form-row">
                                    <label for="input">Selecione um cliente</label>
                                    <select class="form-control" name="customer_id" id="customer_id">
                                        <option value="">Todos os clientes</option>
                                        @foreach( $customers as $customer )
                                        <option value="{{$customer->id}}" {{ $customer->id == $customer->id}}>
                                            {{$customer->id}}-{{$customer->name}}
                                        </option>
                                        @endforeach
                                    </select><br /><br />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <div class="form-row">
                                    <label for="input">Selecione um arquivo</label>
                                    <input id="xlsfile" name="file" type="file" class="form-control" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                            <div class="kt-portlet__body">
                                <div class="form-row kt-radio-inline">
                                    <label class="kt-radio">
                                        <input type="radio" name="checked" value="isca"> Cad. Íscas
                                        <span></span>
                                    </label>
                                    <label class="kt-radio">
                                        <input type="radio" name="checked" value="dispositivo"> Cad. Dispositivos
                                        Móveis
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="col-lg-12 ml-lg-auto">
                <a href="{{url('production/devices')}}" class="btn btn-secondary">Voltar</a>
                <button type="button" class="btn btn-brand" id="btn-device-import"><i
                        class="fas fa-upload"></i>Importar</button>
                <div class="pull-right div-btn-isca">
                    <a href="#" id="btn-show-exemple-isca"><i class="kt-menu__ver-arrow la la-angle-down"></i>
                        Ver exemplo de planilha</a>
                </div>
                <div class="pull-right div-btn-movel">
                    <a href="#" id="btn-show-exemple-movel"><i class="kt-menu__ver-arrow la la-angle-down"></i>
                        Ver exemplo de planilha</a>
                </div>
            </div>
        </div>
        <div class="row div-exemplo-isca">
            <hr />
            <div class="row justify-content-md-center ">
                <div class="col col-lg-2">
                    <img src="{{url('exemplo.png')}}" width="200px" />
                </div>
                <div class="col col-lg-4">
                    <div class="center">
                        <h4 class="alert-heading">Exemplo!</h4>
                    </div>
                    <ul>
                        <li>A planilha deve conter duas colunas, a primeira contendo o modelo e a segunda
                            contendo o ID da tecnologia.</li>
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
        <div class="row div-exemplo-movel">
            <hr />
            <div class="row justify-content-md-center ">
                <div class="col col-lg-2">
                    <img src="{{url('exemplo.png')}}" width="200px" />
                </div>
                <div class="col col-lg-4">
                    <div class="center">
                        <h4 class="alert-heading">Exemplo!</h4>
                    </div>
                    <ul>
                        <li>A planilha deve conter somente o preenchimento da primeira coluna com o número de
                            série dos dispositivos móveis.</li>
                        <li>Não deve conter cabeçalho.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @else
    <form class="kt-form kt-form--label-right" id="form-create-device" method="post" enctype="multipart/form-data">
        <div class="kt-portlet__body">
            <div class="row kt-margin-b-20">
                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                    <div class="kt-portlet__body">
                        <label>Registro:</label>
                        <input type="text" readonly name="registro" id="registro" class="form-control pull-right"
                            value="{{$device->id ?? ''}}" />
                    </div>
                </div>
                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <label for="input">Selecione um cliente</label>
                            <select class="form-control" name="customer_id" id="customer_id">
                                <option selected>
                                    {{ isset($device->customer->name) ? $device->customer->name : null }}</option>
                                @foreach( $customers as $customer )
                                <option value="{{$customer->id}}" {{ $customer->id == $customer->id}}>
                                    {{$customer->id}}-{{$customer->name}}
                                </option>
                                @endforeach
                            </select><br /><br />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <label for="input">Selecione um modelo</label>
                            <select class="form-control" name="model" id="model">
                                <option selected>
                                    {{ isset($device->model) ? $device->model : null }}
                                </option>
                                @foreach( $devices as $model )
                                <option value="{{$model->id}}" {{ $model->id == $model->id}}>
                                    {{$model->id}}-{{$model->model}}
                                </option>
                                @endforeach
                            </select><br /><br />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <label for="input">Selecione uma bateria</label>
                            <select class="form-control" name="tecnologie_id" id="tecnologie_id">
                                <option selected>
                                    {{ isset($device->technologie->type) ? $device->technologie->type : null }}
                                </option>
                                @foreach( $technologies as $technologie )
                                <option value="{{$technologie->id}}" {{ $technologie->id == $technologie->id}}>
                                    {{$technologie->id}}-{{$technologie->type}}
                                </option>
                                @endforeach
                            </select><br /><br />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <label for="input">Selecione Tipo</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option selected>
                                    {{ isset($device->tipo) ? $device->tipo : null }}</option>
                                <option value="isca">isca</option>
                                <option value="dispositivo">dispositivo</option>
                            </select><br /><br />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <label for="input">Selecione status</label>
                            <select class="form-control" name="status" id="status">
                                <option selected>
                                    {{ isset($device->status) ? $device->status : null }}</option>
                                <option value="disponivel">disponivel</option>
                                <option value="em andamento">em andamento</option>
                                <option value="indisponivel">indisponivel</option>
                            </select><br /><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="{{url('production/devices')}}" class="btn btn-secondary">Voltar</a>
            <button type="button" class="btn btn-primary" id="btn-device-save">Salvar</button>
        </div>

    </form>
    @endif
</div>
</div>

@endsection

@section('scripts')
<script>
$(function() {

    $('input[type=radio]').change(function() {
        var radio = this.value;
        if (radio == "isca") {
            $('.div-btn-isca').show('100');
            $('.div-btn-movel').hide();
            $('.div-exemplo-movel').hide();
            $("#btn-show-exemple-isca").click(function() {
                $('.div-exemplo-isca').show('100');
            })
        } else {
            $('.div-btn-movel').show('100');
            $('.div-btn-isca').hide();
            $('.div-exemplo-isca').hide();
            $("#btn-show-exemple-movel").click(function() {
                $('.div-exemplo-movel').show('100');
            })
        }
    });

    $('#btn-device-import').click(function() {

        if (typeof($('#xlsfile')[0].files[0]) == 'undefined') {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um arquivo!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        if ($('#customer_id')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um cliente!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        if (!$("input[type='radio']").is(':checked')) {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um tipo de dispositivo!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        var radios = document.getElementsByName("checked");
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                var tipo = radios[i].value;
            }
        }

        var optionSelected = $('#customer_id option:selected').val();
        //alert(optionSelected);

        var file_data = $('#xlsfile')[0].files[0];
        //console.log(file_data)
        var form_data = new FormData();
        //form_data.append('file', file_data, 'file', optionSelected);
        form_data.append('tipo', tipo);
        form_data.append('select', optionSelected);
        form_data.append('file', file_data);

        //console.log($customer_id);

        $.ajax({
            url: '{{url("/production/devices/save")}}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                cache: false,
                contentType: false,
                processData: false,
            },
            data: form_data,
            success: function(response) {
                if (response.status == "success") {
                    if (response.message > 0) {
                        Swal.fire({
                            type: 'success',
                            title: response.message +
                                " dispositivos importados!",
                            showConfirmButton: true,
                            timer: 10000
                        })
                        window.location.href = '{{url("/production/devices")}}'
                    } else {
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
                    html: 'O arquivo não esta no formato correto, necessário ter 2 colunas contendo numero de série e id do tipo de tecnologia e já existe produto cadastrado!',
                    footer: ' '
                })

            },
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', function() {}, false);
                }
                return myXhr;
            }
        });

    });

    $('#btn-device-save').click(function() {
        console.log('Vc apertou botão save');
        $.ajax({
            //url: "{{url('')}}/boardings/history/save",
            url: '{{url("/production/devices/update/")}}' + $('#registro'),
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                'model': $('#model'),
                'technologie_id': $('#technologie_id').val(),
                'customer_id': $('#customer_id').val(),
                'tipo': $('#tipo'),
                'status': $('#status'),
            },
            success: function(response) {
                if (response.status == "success") {
                    Swal.fire({
                        type: 'success',
                        title: 'Registro salvo com sucesso',
                        showConfirmButton: true,
                        timer: 10000
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro ao tentar salvar! ' + response.message,
                        showConfirmButton: true,
                        timer: 10000
                    })
                }

            },
            error: function(error) {
                if (error.responseJSON.status == "internal_error") {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                        showConfirmButton: true,
                        timer: 10000
                    })

                } else if (error.responseJSON.status == "validation_error") {
                    var items = error.responseJSON.errors;
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'Os seguintes erros foram encontrados: ' + items,
                        footer: ' '
                    })

                } else {
                    var items = error.responseJSON.errors;
                    var errors = $.map(items, function(i) {
                        return i.join('<br />');
                    });
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'Os seguintes erros foram encontrados: ' + errors,
                        footer: ' '
                    })
                }
            }
        });
    });

    $('#btn-device-newone').click(function() {
        console.log('Vc apertou botão new one');
        if ($('#model')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione uma isca modelo!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        if ($('#customer_id')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um cliente!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }
        if ($('#tecnologie_id')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione uma bateria !',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }
        if ($('#tipo')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um tipo !',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        $.ajax({
            //url: "{{url('')}}/boardings/history/save",
            url: '{{url("/production/devices/saveone")}}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                'model': $('#model').val(),
                'technologie_id': $('#technologie_id').val(),
                'customer_id': $('#customer_id').val(),
                'tipo': $('#tipo').val(),
                'status': $('#status').val(),
            },
            success: function(response) {
                if (response.status == "success") {
                    Swal.fire({
                        type: 'success',
                        title: 'Registro salvo com sucesso',
                        showConfirmButton: true,
                        timer: 10000
                    })
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro ao tentar salvar! ' + response.message,
                        showConfirmButton: true,
                        timer: 10000
                    })
                }

            },
            error: function(error) {
                if (error.responseJSON.status == "internal_error") {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                        showConfirmButton: true,
                        timer: 10000
                    })

                } else if (error.responseJSON.status == "validation_error") {
                    var items = error.responseJSON.errors;
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'Os seguintes erros foram encontrados: ' + items,
                        footer: ' '
                    })

                } else {
                    var items = error.responseJSON.errors;
                    var errors = $.map(items, function(i) {
                        return i.join('<br />');
                    });
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'Os seguintes erros foram encontrados: ' + errors,
                        footer: ' '
                    })
                }
            }
        });

    });

});
</script>

@endsection
