@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
    .btn-distribuir {
        display: grid;
        row-gap: 15px;
        margin-top: 5rem;
        margin-left: 3rem;
    }
</style>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Grupo de Cercas e Veículos
            </h3>
        </div>
    </div>

    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" id="form-create-cerca">
        @csrf
        <input type="hidden" name="id" id="id" value="{{ $cerca->id ?? '' }}" />
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="name">Nome Cerca:</label>
                            <input type="text" class="form-control" style="background-color: #ffffff;" id="name">
                        </div>
                        <div class="col-lg-12">
                            <label for="exampleSelect2" class="col-form-label">Placas: </label><br><!--  js-example-basic-multiple-->
                            <select class="form-control col-md-12  leftBox  seguradoresLeft" id="seguradoresRight" multiple="multiple">
                                @foreach($cars as $driver)
                                <option value="">{{$driver->placa}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row" style="margin-top: -10px;"> 
                        <div class="col-lg-4" style="margin-top: 60px;">
                            <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                                <button type="button" class="btn btn-primary btn-sm btn-icon" onClick="moveSelected('seguradoresLeft')" title="Atribuir"><i class="la la-arrow-right"></i></button>
                                <button type="button" class="btn btn-primary btn-sm btn-icon" onClick="moveSelected('seguradoresRight')" title="Desfazer atribuição"><i class="la la-arrow-left"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="kt-input-icon kt-input-icon--right">
                                <label for="exampleSelect2" class="col-form-label">Placa direcionada: </label>
                                <select multiple size="10" class="form-control col-md-10 rightBox seguradoresRight" id="seguradoresLeft" name='seguradoras[]'>
                                    <!-- <option value=""></option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-3 ml-lg-auto">
                        <button type="button" class="btn btn-success" id="btn-cerca-save">Confirmar</button>
                        <a href="#" class="btn btn-secondary">Voltar</a>
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
        const leftBox = $('.' + classNAme);
        var $options = $("." + classNAme + " option:selected").clone();
        $('.' + leftBox.attr('id')).append($options);
        $("." + classNAme + " option:selected").remove();
        var my_options = $('.' + leftBox.attr('id') + " option");

        my_options.sort(function(a, b) {
            if (a.text > b.text) return 1;
            else if (a.text < b.text) return -1;
            else return 0
        })
        $('.' + leftBox.attr('id')).empty().append(my_options);
    }

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    $('#btn-cerca-save').click(function() {
        cerca_id = $('#id').val();

        var data = {
            _token: '{{csrf_token()}}',
            placas: $(`#seguradoresLeft option`).toArray().map(o => o.innerHTML),
            name: $('#name').val()
        }

        ajax_store(cerca_id, "fleetslarges/cercas", data);

    });
</script>

@endsection
