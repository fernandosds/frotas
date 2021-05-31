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

        <div class="row">
            <div class="col-sm-8">

                <form class="kt-form kt-form--label-right" id="form-create-card">


                    <input type="hidden" name="id" id="id" value="{{ $card->id ?? '' }}" />
                    @csrf

                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Nº de série</label>
                                <input type="text" name="serial_number" class="form-control" value="{{ $card->serial_number ?? '' }}">
                            </div>                            
                        </div>
                        
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button type="button" class="btn btn-brand" id="btn-card-save">Cadastrar</button>
                                        <a href="{{url('fleets/cards')}}" class="btn btn-secondary">Voltar</a>
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
        /**
         Gravar cartão
         */
    $(function() {

        var card_id = $('#id').val();

        $('#btn-card-save').click(function() {
            ajax_store(card_id, "fleets/cards", $('#form-create-card').serialize());
        });

    });
</script>
@endsection