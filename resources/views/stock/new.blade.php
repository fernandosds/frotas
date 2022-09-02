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

                    {{$title}} <small>Novo</small>

                </h3>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row">
            <div class="col-sm-12">
                <form class="kt-form kt-form--label-right" id="form-create-device" method="post"
                    enctype="multipart/form-data">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">Cadastro manual</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#perfil" role="tab"
                                aria-controls="profile" aria-selected="false">Cadastro importação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#informacao" role="tab"
                                aria-controls="contact" aria-selected="false">Informação</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="kt-portlet__body">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="input">Modelo : </label>
                                        <input type="Text" title="Digitar modelo de isca" class="form-control"
                                            id="nmodel" name="nmodel" maxlength="8"
                                            onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="input">Selecione um cliente</label>
                                        <select class="form-control" name="ncustomerI_id" id="ncustomerI_id">
                                            <option selected>
                                            </option>
                                            @foreach( $customers as $customer )
                                            <option value="{{$customer->id}}" {{ $customer->id == $customer->id}}>
                                                {{$customer->id}}-{{$customer->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="input">Selecione Tipo</label>
                                        <select class="form-control" name="ntipo" id="ntipo">
                                            <option selected>
                                                {{ isset($device->tipo) ? $device->tipo : null }}</option>
                                            <option value="isca">isca</option>
                                            <option value="dispositivo">dispositivo</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="input">Selecione uma bateria</label>
                                        <select class="form-control" name="ntechnologie_id" id="ntechnologie_id">
                                            <option selected>
                                            </option>
                                            @foreach( $technologies as $technologie )
                                            <option value=" {{$technologie->id}}">
                                                {{$technologie->type}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{url('stocks/')}}" class="btn btn-secondary">Voltar</a>
                                <button type="button" class="btn btn-primary" id="btn-device-newone">Salvar</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="perfil" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="kt-portlet__body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="input">Selecione um arquivo</label>
                                        <input id="xlsfile" name="file" type="file" class="form-control" required />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="input">Selecione um cliente</label>
                                        <select class="form-control" name="customer_id" id="customer_id">
                                            <option selected>
                                                {{ isset($device->customer->name) ? $device->customer->name : null }}
                                            </option>
                                            @foreach( $customers as $customer )
                                            <option value="{{$customer->id}}" {{ $customer->id == $customer->id}}>
                                                {{$customer->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="input">Selecione Tipo</label>
                                        <select class="form-control" name="tipo" id="tipo">
                                            <option selected>
                                                {{ isset($device->tipo) ? $device->tipo : null }}</option>
                                            <option value="isca">isca</option>
                                            <option value="dispositivo">dispositivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{url('stocks/')}}" class="btn btn-secondary">Voltar</a>
                                <button type="button" class="btn btn-brand" id="btn-device-import"><i
                                        class="fas fa-upload"></i>Importar</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="informacao" role="tabpanel" aria-labelledby="contact-tab">

                            <div class="row justify-content-md-center ">
                                <div class="left">
                                    <div class="col col-lg-2">
                                        <img src="{{url('exemplo.png')}}" width="200px" />
                                    </div>
                                </div>
                                <div class="col col-lg-4">
                                    <div class="center">
                                        <h4 class="alert-heading">Exemplo importação de arquivo!</h4>
                                    </div>
                                    <ul>
                                        <li>A planilha deve conter duas colunas, a primeira contendo o modelo e
                                            a segunda
                                            contendo o ID da tecnologia.</li>
                                        <li>Não deve conter cabeçalho.</li>
                                        <li>Os IDS das tecnologias são os seguintes:
                                            <ul>
                                                @foreach($technologies as $technologie)
                                                <li><b>{{$technologie->id}}</b> => {{$technologie->type}}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li>A planilha deve conter somente o preenchimento da primeira coluna
                                            com o número de
                                            série dos dispositivos móveis.
                                        </li>
                                    </ul>
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
                                            <li>A planilha deve conter somente o preenchimento da primeira coluna
                                                com o número de
                                                série dos dispositivos móveis.</li>
                                            <li>Não deve conter cabeçalho.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
$(function() {

    $('#btn-device-import').click(function() {
        console.log('Vc apertou botão import');
        console.log('Arquivo : ' + $('#xlsfile').val());
        console.log('Customer_id : ' + $('#customer_id').val());
        console.log('Tipo : ' + $('#tipo').val());

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

        var file_data = $('#xlsfile')[0].files[0];
        var optionSelectedcustomer = $('#customer_id option:selected').val();
        var optionSelectedtipo = $('#tipo option:selected').val();

        //console.log(file_data)
        var form_data = new FormData();
        //form_data.append('file', file_data, 'file', optionSelected);
        form_data.append('tipo', optionSelectedtipo);
        form_data.append('select', optionSelectedcustomer);
        form_data.append('file', file_data);

        //console.log($customer_id);

        $.ajax({
            url: '{{url("/stocks/save")}}',
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
                        window.location.href = '{{url("/stocks/")}}'
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

    $('#btn-device-newone').click(function() {
        // console.log('Vc apertou botão new one');
        // console.log('Model : ' + $('#nmodel').val());
        // console.log('Technologie_id : ' + $('#ntechnologie_id').val());
        // console.log('Customer_id : ' + $('#ncustomerI_id').val());
        // console.log('Tipo : ' + $('#ntipo').val());
        // console.log('Status : ' + 'disponivel');

        if ($('#nmodel')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione uma isca modelo!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        if ($('#ncustomerI_id')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um cliente!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }
        if ($('#ntipo')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione um tipo !',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }
        if ($('#ntechnologie_id')[0].value == "") {
            Swal.fire({
                type: 'warning',
                title: 'Ops...',
                text: 'Selecione uma bateria !',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }

        $.ajax({
            url: '{{url("/stocks/saveone")}}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                'model': $('#nmodel').val(),
                'technologie_id': $('#ntechnologie_id').val(),
                'customer_id': $('#ncustomerI_id').val(),
                'tipo': $('#ntipo').val(),
                'status': 'disponivel',
            },
            success: function(response) {
                console.log("response: " + response.status);
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