@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"type="text/javascript"></script>
<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"rel="stylesheet" type="text/css" />


<style type="text/css">
    .btn-distribuir {
        display: grid;
        row-gap: 15px;
        margin-top: 8rem;
        margin-left: 2rem;
    }
    .form-style{
        margin-left: 15px;
        margin-right: 15px;
    }
</style>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand {{$icon}}"></i>
            </span>
            <h3 class="kt-portlet__head-title">
                {{$title}} @if(Route::is('fleetslarges.alerta.new'))<small>Novo</small> @else<small>Editar</small> @endif
            </h3>
        </div>
    </div>


    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" name="formHidden" id="form-create-cerca">
        @csrf
        <input type="hidden" name="id" id="id" value="{{ $cerca->id ?? '' }}" />
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <input type="hidden" name="grupo" id="grupo" value="{{isset($grupo) ? $grupo->id : null}}">
                    <label for="name">Nome Grupo:</label>
                    <input type="text" class="form-control" style="background-color: #ffffff;" value="{{isset($grupo) ? $grupo->nome : ''}}" id="name">
                </div>
                <div class="col-lg-5" style="margin-left: 235px;">
                    <label for="name" style="margin-left: -25px;">Recebimento Alerta:</label>
                    <div class="row">
                        <div class="md-col-6" style="margin-right: 35px;">
                            @if(isset($grupo))
                                @if($grupo->telephone)
                                    <input class="form-check-input" type="checkbox" value="1" name="telephone" id="telephone"  checked>
                                @else
                                    <input class="form-check-input" type="checkbox" value="1" name="telephone" id="telephone">
                                @endif
                                <label class="form-check-label" for="telephone">
                                    Telefone
                                </label>
                            @else
                                <input class="form-check-input" type="checkbox" value="1" name="telephone" id="telephone"  checked>
                                <label class="form-check-label" for="telephone">
                                    Telefone
                                </label>
                            @endif
                        </div>
                        <div class="md-col-6">
                            @if(isset($grupo))
                                @if($grupo->email)
                                    <input class="form-check-input" type="checkbox" value="1" name="email" id="email" checked>
                                @else 
                                    <input class="form-check-input" type="checkbox" value="1" name="email" id="email" >
                                @endif
                            @else
                                <input class="form-check-input" type="checkbox" value="1" name="email" id="email" >
                            @endif
                            <label class="form-check-label" for="email">
                                E-mail
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INCLUDE DE USUARIOS-->
            <div class="form-group row">
                <div class="col-lg-4" style="margin-top: 5px;">
                    <label for="exampleSelect2" class="col-form-label">Usuarios: </label></br>
                    <div class="pickerUser">
                        <select class="form-control col-md-10 leftBoxU usuariosLeft" id="usuariosRight" multiple size="10" data-live-search="true" >
                            @foreach($users as $user)
                                <option data-tokens="{{$user->name}}" value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="form-text text-muted"> <i class="flaticon-questions-circular-button"></i> Selecione um ou mais usuários e os direcione para o quadro á direita.</span>
                </div>
                <div class="col-lg-2">
                    <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                        <button type="button" class="btn btn-primary btn-sm btn-icon" id="rightUser" onClick="moveSelectedUsuarios('usuariosLeft')" title="Atribuir" ><i class="la la-arrow-right"></i></button>
                        <button type="button" class="btn btn-primary btn-sm btn-icon" id="leftUser" onClick="moveSelectedUsuarios('usuariosRight')" title="Desfazer atribuição"><i class="la la-arrow-left"></i></button>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-top: 9px;">
                    <div class="kt-input-icon kt-input-icon--right">
                        <label for="exampleSelect2" class="col-form-label">Incluir Usuários: </label>
                        <select multiple size="10" class="form-control col-md-10 rightBoxU usuariosRight" id="usuariosLeft" name='usuarios[]' >
                            @if(isset($grupo))
                                @foreach($grupo->grupoAlertaRelacionamento as $grupoAlertaRelacionamento)
                                    <option data-tokens="{{$grupoAlertaRelacionamento->nome_usuario}}" value="{{$grupoAlertaRelacionamento->id}}">{{$grupoAlertaRelacionamento->nome_usuario}}</option>
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
                        <a href="{{route('fleetslarges.alerta.list')}}" class="btn btn-secondary">Voltar</a>
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

    function moveSelectedUsuarios(classNAmeU){
        if('usuariosLeft' === classNAmeU){
            console.log("Entrou!");
            $("#rightUser").empty();
            $("#rightUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }else if('usuariosRight' === classNAmeU){
            console.log("if else")
            $("#leftUser").empty();
            $("#leftUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }
        const leftBoxU = $('.' + classNAmeU);
        
        var $optionsU = $("." + classNAmeU).find('option:selected').clone();
        $('.' + leftBoxU.attr('id')).append($optionsU);
        $("." + classNAmeU).find('option:selected').remove();
        var my_optionsU = $('.' + leftBoxU.attr('id') + " option");
        my_optionsU.sort(function(a, b) {
            if (a.text > b.text) return 1;
            else if (a.text < b.text) return -1;
            else return 0
        })
        my_optionsU.sort();
        $('.' + leftBoxU.attr('id')).empty().append(my_optionsU);
        if('usuariosLeft' === classNAmeU){
            $("#rightUser").empty();
            $("#rightUser").append('<i class="la la-arrow-right">');
        }else{
            $("#leftUser").empty();
            $("#leftUser").append('<i class="la la-arrow-left"></i>');
        } 
    }

    // function moveSelectedUsuarios(classNAmeU) {
    //     if('usuariosLeft' === classNAmeU){
    //         $("#rightUser").empty();
    //         $("#rightUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
    //     }else if('usuariosRight' === classNAmeU){
    //         $("#leftUser").empty();
    //         $("#leftUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
    //     }
    //     const $allOptions = $("." + classNAmeU).find('option').clone();
    //     console.log($allOptions);
    //     if('usuariosLeft' === classNAmeU){
            
    //         var $optionsU = $("." + classNAmeU).find('option:selected').clone();
    //         var $optionsUadd = $("." + classNAmeU).find('option');
    //         $("." + 'usuariosRight').append($optionsU);
    //         $optionsU.map(function(i, option){
    //             $optionsUadd.map(function(iA, optionAdd){
    //                 if(option.value === optionAdd.value){
    //                     // $optionsU.append(optionAdd);
    //                     $optionsUadd[iA].remove();
    //                 }
    //             })
    //         });
    //         // $("." + classNAmeU).find('option:selected').remove();
            
    //         // $("." + 'usuariosRight').find('option:selected').remove();
    //         $("." + 'selectpicker').empty();
    //         $("." + 'selectpicker').append($allOptions);

    //     }else{

    //         var $optionsU = $("." + classNAmeU).find('option:selected').clone();
    //         var $optionsUadd = $("." + classNAmeU).find('option');

    //         // $("." + classNAmeU).find('option:selected').remove();

    //         $("." + 'usuariosRight').find('option:selected').remove();

    //         $("." + 'selectpicker').remove();
    //         $("." + 'pickerUser').append('<select class="form-control col-md-10 selectpicker leftBoxU usuariosLeft user" id="usuariosRight" multiple size="10" data-live-search="true" ></select>');
    //         // $("." + 'selectpicker').append($allOptions);
            
    //     }

    //     if('usuariosLeft' === classNAmeU){
    //         $("#rightUser").empty();
    //         $("#rightUser").append('<i class="la la-arrow-right">');
    //     }else{
    //         $("#leftUser").empty();
    //         $("#leftUser").append('<i class="la la-arrow-left"></i>');
    //     } 
        
    // }

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    $('#btn-cerca-save').click(function() {
        cerca_id = $('#id').val();
        var id_grupo = $('#grupo').val();
        var data = {
            _token:     '{{csrf_token()}}',
            usuarios:   $(`#usuariosLeft option`).toArray().map(o => o.innerHTML),
            name:       $('#name').val(),
            telephone:  $('#telephone:checked').val(),
            email:      $('#email:checked').val(),
            id_grupo:   id_grupo,
        }
        ajax_store(cerca_id, "fleetslarges/alerta", data);
    });

</script>

@endsection
