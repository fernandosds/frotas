@extends('layouts.app')

@section('content')
<style>
.modal-backdrop {
    z-index: 0;
}
</style>

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

        <form class="kt-form kt-form--label-right" id="form-create-driver">

            <input type="hidden" name="id" id="id" value="{{ $driver->id ?? '' }}" />
            @csrf

            <div class="kt-portlet__body">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputName">Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ $driver->name ?? '' }}">
                    </div>
                    <div class="form-group col-md-3" id="reloadOption">
                        <label for="">Nº Cartão</label>
                        <select class="form-control" name="card_id" id="card_id">
                            <option value=" ">Selecione um cartão</option>
                            @foreach($cards as $card)
                            <option value="{{$card->id}}" id="optionSelected">{{$card->serial_number}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="">&nbsp</label>
                        <br />
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"
                            data-backdrop="static">
                            +
                        </button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="">Endereço</label>
                        <input type="text" class="form-control automaker" name="address"
                            value="{{ $driver->address ?? '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputCpfCnpj">CPF</label>
                        <input type="text" id="input_cpf" name="cpf" class="form-control input_cpf_cnpj" maxlength="14"
                            value="{{ $driver->cpf ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputAddress">Data de Admissão</label>
                        <input type="date" class="form-control" name="admission" value="{{ $driver->admission ?? '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputComplement">Telefone</label>
                        <input type="text" class="form-control mask_input_contact" name="phone"
                            value="{{ $driver->phone ?? '' }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNumber">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $driver->email ?? '' }}">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="inputAddress">CNH</label>
                        <input type="text" class="form-control" name="cnh" maxlength="11"
                            value="{{ $driver->cnh ?? '' }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="inputAddress">Validade da CNH</label>
                        <input type="date" class="form-control" name="validation"
                            value="{{ $driver->admission ?? '' }}">
                    </div>

                    <div class="form-group col-md-1">
                        <label for="">Categoria A</label>
                        <div class="form-group">
                            <div class="kt-radio-inline">
                                <label class="kt-checkbox">
                                    <input type="checkbox" name="category[]" value="A">A
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="inputCategory">Outras Catogorias</label>
                        <select class="form-control" name="category[]" id="category">
                            <option value="">Sem categoria</option>
                            <option value="B" id="option">B</option>
                            <option value="C" id="option">C</option>
                            <option value="D" id="option">D</option>
                            <option value="E" id="option">E</option>
                        </select>

                    </div>
                    <div class="form-group col-md-0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputAddress">Status</label>
                        <select class="form-control" name="status">
                            <option value="0" {{ ($driver->status ?? null) == '0' ? 'selected' : ''}}>Ativo</option>
                            <option value="1" {{ ($driver->status ?? null) == '1' ? 'selected' : ''}}>Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12 ml-lg-auto">
                                <button type="button" class="btn btn-brand" id="btn-driver-save">Cadastrar</button>
                                <a href="{{url('fleets/drivers')}}" class="btn btn-secondary">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="kt-form kt-form--label-right" id="form-create-card">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Novo Cartão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-6">
                        <label for="inputName">Nº de série</label>
                        <input type="text" name="serial_number" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-card-save">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
/**
         Modal
         */

$('#myModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus')
})

/**
     Gravar motorista
     */
$(function() {

    var driver_id = $('#id').val();
    $('#btn-driver-save').click(function() {
        ajax_store(driver_id, "fleets/drivers", $('#form-create-driver').serialize());
    });

});

/**
            Gravar cartão
*/
$(function() {
    var card_id = $('#id').val();
    $('#btn-card-save').click(function() {
        ajax_store_cards_driver(card_id, "fleets/cards", $('#form-create-card').serialize());
    });
});
</script>
@endsection
