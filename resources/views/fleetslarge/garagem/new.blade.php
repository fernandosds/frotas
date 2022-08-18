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
                {{$title}} @if(Route::is('fleetslarges.cerca.new'))<small>Novo</small> @else<small>Editar</small> @endif
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
                    <label for="name">Nome Garagem:</label>
                    <input type="text" class="form-control" style="background-color: #ffffff;" value="{{isset($grupo) ? $grupo->nome : ''}}" id="name">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4">
                    <label for="exampleSelect2" class="col-form-label">Placas: </label><br>
                    <select class="form-control col-md-10  leftBox  seguradoresLeft" id="seguradoresRight" multiple size="10" data-live-search="true">
                        @foreach($cars as $driver)
                            <option data-tokens="{{$driver->placa}}" value="{{$driver->id}}">{{$driver->placa}}</option>
                        @endforeach
                    </select>
                    <span class="form-text text-muted"><i class="flaticon-questions-circular-button"></i> Selecione uma ou mais placas e direcione-as para o quadro á direita.</span>
                </div>
                <div class="col-lg-2">
                    <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                        <button type="button" class="btn btn-primary btn-sm btn-icon" id="rightSeg" onClick="moveSelected('seguradoresLeft')" title="Atribuir"><i class="la la-arrow-right"></i></button>
                        <button type="button" class="btn btn-primary btn-sm btn-icon" id="leftSeg" onClick="moveSelected('seguradoresRight')" title="Desfazer atribuição"><i class="la la-arrow-left"></i></button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="kt-input-icon kt-input-icon--right">
                        <label for="exampleSelect2" class="col-form-label">Placa(s) adicionada(s): </label>
                        <select multiple size="10" class="form-control col-md-10 rightBox seguradoresRight" id="seguradoresLeft" name='seguradoras[]'>
                            @if(isset($placas))
                                @foreach($placas as $placa)
                                    <option data-tokens="{{$placa}}" value="{{$placa}}">{{$placa}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <!-- INCLUDE DE ALERTAS-->
            <div class="form-group row">
                <div class="col-lg-4" style="margin-top: 5px;">
                    <label for="exampleSelect2" class="col-form-label">Grupos de Alertas: </label></br>
                    <div class="pickerUser">
                        <select class="form-control col-md-10 leftBoxU alertasLeft" id="alertasRight" multiple size="10" data-live-search="true" >
                            @if(isset($gruposAlerta))
                                @foreach($gruposAlerta as $alerta)
                                    <option data-tokens="{{$alerta->nome}}" value="{{$alerta->id}}">{{$alerta->nome}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <span class="form-text text-muted"> <i class="flaticon-questions-circular-button"></i> Selecione um ou mais usuários e os direcione para o quadro á direita.</span>
                </div>
                <div class="col-lg-2">
                    <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                        <button type="button" class="btn btn-primary btn-sm btn-icon" id="rightUser" onClick="moveSelectedAlertas('alertasLeft')" title="Atribuir" ><i class="la la-arrow-right"></i></button>
                        <button type="button" class="btn btn-primary btn-sm btn-icon" id="leftUser" onClick="moveSelectedAlertas('alertasRight')" title="Desfazer atribuição"><i class="la la-arrow-left"></i></button>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-top: 9px;">
                    <div class="kt-input-icon kt-input-icon--right">
                        <label for="exampleSelect2" class="col-form-label">Grupo de alertas adicionada para esta garagem: </label>
                        <select multiple size="10" class="form-control col-md-10 rightBoxU alertasRight" id="alertasLeft" name='alertas[]' >
                            @if(isset($alertas))
                                @foreach($alertas as $grupoAlerta)
                                    @foreach($grupoAlerta->grupoAlerta as $alerta)
                                        <option data-tokens="{{$alerta->nome}}" value="{{$alerta->id}}">{{$alerta->nome}}</option>
                                    @endforeach
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
                        <a href="{{route('fleetslarges.garagem.list')}}" class="btn btn-secondary">Voltar</a>
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

    // function moveSelected(classNAme) {
    //     if('seguradoresLeft' === classNAme){
    //         $("#rightSeg").empty();
    //         $("#rightSeg").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
    //     }else if('seguradoresRight' === classNAme){
    //         $("#leftSeg").empty();
    //         $("#leftSeg").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
    //     }
    //     const $allOptionsC = $("." + classNAme).find('option').clone();

    //     if('seguradoresLeft' === classNAme){
    //         var $optionsU = $("." + classNAme).find('option:selected').clone();
    //         var $optionsUadd = $("." + classNAme).find('option');

    //         $optionsUadd.map(function(iA, optionAdd){
    //             $optionsU.map(function(i, option){
    //                 if(optionAdd.value === option.value){
    //                     $(".seguradoresRight option[value="+optionAdd.value+"]").remove();

    //                 }
    //             })
    //         })
    //         $("." + 'seguradoresRight').append($optionsU);

    //         $('.filter-option').html("NADA SELECIONADO");
    //         $('.selected').toggleClass('selected select');
    //         $("." + 'selectpicker').empty();
    //         $("." + 'selectpicker').append($allOptionsC);

    //     }else{

    //         var $optionsU = $("." + classNAme).find('option:selected').clone();
    //         var $optionsUadd = $("." + classNAme).find('option');

    //         $("." + 'seguradoresRight').find('option:selected').remove();

    //     }

    //     if('seguradoresLeft' === classNAme){
    //         $("#rightSeg").empty();
    //         $("#rightSeg").append('<i class="la la-arrow-right">');
    //     }else{
    //         $("#leftSeg").empty();
    //         $("#leftSeg").append('<i class="la la-arrow-left"></i>');
    //     } 
        
    // }
    function moveSelected(classNAme) {
        if('seguradoresLeft' === classNAme){
            $("#rightSeg").empty();
            $("#rightSeg").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }else if('seguradoresRight' === classNAme){
            $("#leftSeg").empty();
            $("#leftSeg").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }
        const leftBox = $('.' + classNAme);
        
        // var $options = $("." + classNAme + " option:selected").clone();
        var $options = $("." + classNAme).find('option:selected').clone();

        $('.' + leftBox.attr('id')).append($options);
        $("." + classNAme).find('option:selected').remove();
        var my_options = $('.' + leftBox.attr('id') + " option");
        my_options.sort(function(a, b) {
            if (a.text > b.text) return 1;
            else if (a.text < b.text) return -1;
            else return 0
        })
        $('.' + leftBox.attr('id')).empty().append(my_options);

        if('seguradoresLeft' === classNAme){
            $("#rightSeg").empty();
            $("#rightSeg").append('<i class="la la-arrow-right">');
        }else{
            $("#leftSeg").empty();
            $("#leftSeg").append('<i class="la la-arrow-left"></i>');
        } 

    }

    function moveSelectedAlertas(classNAmeU) {
        if('alertasLeft' === classNAmeU){
            $("#rightUser").empty();
            $("#rightUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }else if('alertasRight' === classNAmeU){
            $("#leftUser").empty();
            $("#leftUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }
        const $allOptions = $("." + classNAmeU).find('option').clone();

        if('alertasLeft' === classNAmeU){
            var $optionsU = $("." + classNAmeU).find('option:selected').clone();
            var $optionsUadd = $("." + classNAmeU).find('option');

            $optionsUadd.map(function(iA, optionAdd){
                $optionsU.map(function(i, option){
                    if(optionAdd.value === option.value){
                        $(".alertasRight option[value="+optionAdd.value+"]").remove();
                    }
                })
            })

            $("." + 'alertasRight').append($optionsU);

            $('.filter-option').html("NADA SELECIONADO");
            $('.selected').toggleClass('selected ');
            $("." + 'selectpicker').empty();
            $("." + 'selectpicker').append($allOptions);

        }else{

            var $optionsU = $("." + classNAmeU).find('option:selected').clone();
            var $optionsUadd = $("." + classNAmeU).find('option');

            $("." + 'alertasRight').find('option:selected').remove();

        }

        if('alertasLeft' === classNAmeU){
            $("#rightUser").empty();
            $("#rightUser").append('<i class="la la-arrow-right">');
        }else{
            $("#leftUser").empty();
            $("#leftUser").append('<i class="la la-arrow-left"></i>');
        } 
        
    }

    function moveSelectedAlertas(classNAmeU) {
        if('alertasLeft' === classNAmeU){
            console.log("Entrou!");
            $("#rightUser").empty();
            $("#rightUser").append('<div class="fa-3x"><i class="fas fa-spinner fa-pulse"></i></div>');
        }else if('alertasRight' === classNAmeU){
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
        if('alertasLeft' === classNAmeU){
            $("#rightUser").empty();
            $("#rightUser").append('<i class="la la-arrow-right">');
        }else{
            $("#leftUser").empty();
            $("#leftUser").append('<i class="la la-arrow-left"></i>');
        } 
        
    }

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    $('#btn-cerca-save').click(function() {
        cerca_id = $('#id').val();
        var id_grupo = $('#grupo').val();
        var data = {
            _token:     '{{csrf_token()}}',
            placas:     $(`#seguradoresLeft option`).toArray().map(o => o.innerHTML),
            alertas:    $(`#alertasLeft option`).toArray().map(o => o.innerHTML),
            name:       $('#name').val(),
            id_grupo:   id_grupo,
        }
        ajax_store(cerca_id, "fleetslarges/garagem", data);
    });

</script>

@endsection
