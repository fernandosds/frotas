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

<form class="kt-form kt-form--label-right" id="form-create-technologie">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $technologie->id ?? '' }}" />

    <div class="kt-portlet__body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputSerialNumber">Número de série</label>
                <input type="text" name="type" class="form-control" value="{{ $technologie->type ?? '' }}">
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12 ml-lg-auto">
                        <button type="button" class="btn btn-brand" id="btn-technologie-save">Cadastrar</button>
                        <a href="{{url('/lures/technologies')}}" class="btn btn-secondary">Voltar</a>
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

        $('#btn-technologie-save').click(function() {

            var technologie_id = $('#id').val();

            ajax_store(technologie_id, "lures/technologies", $('#form-create-technologie').serialize());

        });

    });
</script>
@endsection