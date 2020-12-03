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

<form class="kt-form kt-form--label-right" id="form-create-lure">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $lure->id ?? '' }}" />

    <div class="kt-portlet__body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputSerialNumber">Número de série</label>
                <input type="text" name="serial_number" class="form-control" value="{{ $lure->serial_number ?? '' }}">
            </div>            

            <div class="form-group col-md-6">
                <label for="inputTipoIsca">Tipo de isca</label>
                <input type="text" class="form-control" name="type_of_lure_id" value="{{ $lure->type_of_lure_id ?? '' }}">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="inputBateryLevel">Bateria</label>
            <input type="text" class="form-control" name="batery_level" value="{{ $lure->batery_level ?? '' }}">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Data validação</label>
                <input type="date" class="form-control" name="validation" value="{{ $lure->validation ?? '' }}">
            </div>

        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12 ml-lg-auto">
                        <button type="button" class="btn btn-brand" id="btn-lure-save">Cadastrar</button>
                        <a href="{{url('lures')}}" class="btn btn-secondary">Voltar</a>
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

        $('#btn-lure-save').click(function() {

            var lure_id = $('#id').val();

            ajax_store(lure_id, "lures", $('#form-create-lure').serialize());

        });

    });
</script>
@endsection