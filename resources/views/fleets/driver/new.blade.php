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

        <form class="kt-form kt-form--label-right" id="form-create-driver">

            <input type="hidden" name="id" id="id" value="{{ $driver->id ?? '' }}" />
            @csrf

            <div class="kt-portlet__body">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputName">Nome</label>
                        <input type="text" name="name" class="form-control" value="{{ $driver->name ?? '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Nº Cartão</label>
                        <input type="text" class="form-control" name="card_number" maxlength="25" value="{{ $driver->card_number ?? '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">&nbsp;</label><br />

                        <button type="button" class="btn btn-primary" id="btn-link">
                            <i class="fa fa-link"></i> Vincular
                        </button>

                        <button type="button" class="btn btn-danger" id="btn-unlink">
                            <i class="fa fa-unlink"></i> Desincular
                        </button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="">Endereço</label>
                        <input type="text" class="form-control automaker" name="address" value="{{ $driver->address ?? '' }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAddress">Data de Admissão</label>
                        <input type="date" class="form-control" name="admission" value="{{ $driver->admission ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputCpfCnpj">CPF</label>
                        <input type="text" id="input_cpf" name="cpf" class="form-control input_cpf_cnpj" maxlength="14" value="{{ $driver->cpf ?? '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputAddress">CNH</label>
                        <input type="text" class="form-control" name="cnh" maxlength="11" value="{{ $driver->cnh ?? '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputComplement">Telefone</label>
                        <input type="text" class="form-control" name="phone" value="{{ $driver->phone ?? '' }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputNumber">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $driver->email ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group col-md-3">
                        <label for="inputAddress">Status</label>
                        <select class="form-control" name="status">
                            <option value="0" {{ ($driver->status ?? null) == '0' ? 'selected' : ''}}>Bloqueado</option>
                            <option value="1" {{ ($driver->status ?? null) == '1' ? 'selected' : ''}}>Desbloqueado</option>
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

@endsection

@section('scripts')
<script>

    $('#btn-unlink').click(function(){
        alert('desvincular')
    })

    $('#btn-link').click(function(){
        alert('vincular')
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
</script>
@endsection