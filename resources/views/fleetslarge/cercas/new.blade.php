@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
.btn-distribuir {
    display: grid;
    row-gap: 15px;
    margin-top: 8rem;
    margin-left: 2rem;
}
</style>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand {{$icon}}"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                {{$title}} @if(Route::is('fleetslarges.cerca.new'))<small>Novo</small> @else<small>Editar</small> @endif
            </h3>
        </div>
    </div>

    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" id="form-create-cerca">
        @csrf
        <input type="hidden" name="id" id="id" value="{{ $cerca->id ?? '' }}" />
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <input type="hidden" name="grupo" id="grupo" value="{{isset($grupo) ? $grupo->id : null}}">
                    <label for="name">Nome Cerca:</label>
                    <input type="text" class="form-control" style="background-color: #ffffff;"
                        value="{{isset($grupo) ? $grupo->nome : ''}}" id="name">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label for="exampleSelect2" class="col-form-label">Placas: </label><br>
                    <select class="form-control col-md-10  leftBox  seguradoresLeft" id="seguradoresRight" multiple
                        size="10">
                        @foreach($cars as $driver)
                        <option value="">{{$driver->placa}}</option>
                        @endforeach
                    </select>
                    <span class="form-text text-muted"><i class="flaticon-questions-circular-button"></i> Selecione uma
                        ou mais placas e direcione-as para o quadro á direita.</span>
                </div>
                <div class="col-lg-2">

                    <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                            onClick="moveSelected('seguradoresLeft')" title="Atribuir"><i
                                class="la la-arrow-right"></i></button>
                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                            onClick="moveSelected('seguradoresRight')" title="Desfazer atribuição"><i
                                class="la la-arrow-left"></i></button>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="kt-input-icon kt-input-icon--right">
                        <label for="exampleSelect2" class="col-form-label">Placa(s) adicionada(s): </label>
                        <select multiple size="10" class="form-control col-md-10 rightBox seguradoresRight"
                            name='seguradoras[]'>
                            @if(isset($placas))
                            @foreach($placas as $placa)
                            <option value="">{{$placa}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <!-- INCLUDE DE USUARIOS-->
            <div class="form-group row">
                <div class="col-lg-4" style="margin-top: 5px;">
                    <label for="exampleSelect2" class="col-form-label">Usuários: </label></br>
                    <select class="form-control col-md-10 leftBoxU usuariosLeft" id="usuariosRight" multiple size="10">
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    <span class="form-text text-muted"> <i class="flaticon-questions-circular-button"></i> Selecione um
                        ou mais usuários e os direcione para o quadro á direita.</span>
                </div>
                <div class="col-lg-2">
                    <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                            onClick="moveSelectedUsuarios('usuariosLeft')" title="Atribuir"><i
                                class="la la-arrow-right"></i></button>
                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                            onClick="moveSelectedUsuarios('usuariosRight')" title="Desfazer atribuição"><i
                                class="la la-arrow-left"></i></button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="kt-input-icon kt-input-icon--right">
                        <label for="exampleSelect2" class="col-form-label">Incluir Usuários: </label>
                        <select multiple size="10" class="form-control col-md-10 rightBox usuariosRight"
                            id="usuariosLeft" name='usuarios[]'>
                            @if(isset($grupo))
                            @foreach($usuarios->grupoUsuarioRelacionamento as $usuarioRelacionamento)
                            <option value="">{{$usuarioRelacionamento->nome_usuario}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-3 ml-lg-auto">
                        <button type="button" class="btn btn-success" id="btn-cerca-save">Confirmar</button>
                        <a href="{{route('fleetslarges.cerca.list')}}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
function moveSelected(classNAme) {
    if (classNAme == "seguradoresLeft") {
        var mensagem = "Aguarde adicionar placa no grupo...! " + '<i class="fas fa-cog fa-spin"></i>';
    } else if (classNAme == "seguradoresRight") {
        var mensagem = "Aguarde remover placa do grupo...! " + '<i class="fas fa-cog fa-spin"></i>';
    }
    $('.moveSelected').on('click', function() {
        $(this).prop("disabled", true);
    });
    $.ajax({
        beforeSend: function() {},
        success: function(result) {
            Swal.fire({
                icon: 'success',
                title: mensagem,
                showConfirmButton: false,
                timer: 1000
            }).then((result) => {
                const leftBox = $('.' + classNAme);
                var $options = $("." + classNAme + " option:selected").clone();
                $('.' + leftBox.attr('id')).append($options);
                $("." + classNAme + " option:selected").remove();
                var my_options = $('.' + leftBox.attr('id') + " option");
                $('.' + leftBox.attr('id')).empty().append(my_options);
            })
        }
    });
}

function moveSelectedUsuarios(classNAmeU) {
    //console.log(classNAmeU);
    if (classNAmeU == "usuariosLeft") {
        var mensagem = 'Aguarde adicionar usuário no grupo...!' + '<i class="fas fa-cog fa-spin"></i>';
    } else if (classNAmeU == "usuariosRight") {
        var mensagem = 'Aguarde remover usuário do grupo...!' + '<i class="fas fa-cog fa-spin"></i>';
    }
    $('.moveSelectedUsuarios').on('click', function() {
        $(this).prop("disabled", true);
    });
    $.ajax({
        beforeSend: function() {},
        success: function(result) {
            Swal.fire({
                icon: 'success',
                title: mensagem,
                showConfirmButton: false,
                timer: 1000
            }).then((result) => {
                const leftBoxU = $('.' + classNAmeU);
                var $optionsU = $("." + classNAmeU + " option:selected").clone();
                $('.' + leftBoxU.attr('id')).append($optionsU);
                $("." + classNAmeU + " option:selected").remove();
                var my_optionsU = $('.' + leftBoxU.attr('id') + " option");
                $('.' + leftBoxU.attr('id')).empty().append(my_optionsU);
            })
        }
    });
}

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

$('#btn-cerca-save').click(function() {
    cerca_id = $('#id').val();
    var id_grupo = $('#grupo').val();
    var data = {
        _token: '{{csrf_token()}}',
        placas: $(`#seguradoresLeft option`).toArray().map(o => o.innerHTML),
        usuarios: $(`#usuariosLeft option`).toArray().map(o => o.innerHTML),
        name: $('#name').val(),
        id_grupo: id_grupo,
    }
    $('#btn-cerca-save').prop('disabled', true);
    ajax_store(cerca_id, "fleetslarges/cercas", data);
});
</script>

@endsection