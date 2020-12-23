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

            <form class="kt-form kt-form--label-right" id="form-create-types-of-load">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $types_of_load->id ?? '' }}" />

                <div class="kt-portlet__body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputTypesOfLoad">Tipo de cargas</label>
                            <input type="text" name="type" class="form-control" value="{{ $types_of_load->type ?? '' }}">
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 ml-lg-auto">
                                    <button type="button" class="btn btn-brand" id="btn-types-of-load-save">Cadastrar</button>
                                    <a href="{{url('typeofloads')}}" class="btn btn-secondary">Voltar</a>
                                </div>
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

        $('#btn-types-of-load-save').click(function() {

            var type_of_load_id = $('#id').val();

            ajax_store(type_of_load_id, "typeofloads", $('#form-create-types-of-load').serialize());

        });

    });
</script>
@endsection