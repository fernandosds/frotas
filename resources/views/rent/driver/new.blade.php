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
                </div>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="inputAddress">Endereço</label>
                        <input type="text" class="form-control automaker" name="address" value="{{ $driver->address ?? '' }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputNumber">Email</label>
                        <input type="text" class="form-control" name="email" value="{{ $driver->email ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputCpfCnpj">CPF</label>
                        <input type="text" id="input_cpf" name="cpf" class="form-control input_cpf_cnpj" maxlength="14" value="{{ $driver->cpf ?? '' }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAddress">CNH</label>
                        <input type="text" class="form-control" name="cnh" maxlength="11" value="{{ $driver->cnh ?? '' }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputComplement">Telefone</label>
                        <input type="text" class="form-control" name="phone" value="{{ $driver->phone ?? '' }}">
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Status</label>
                    <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
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
                                <a href="{{url('rents/drivers')}}" class="btn btn-secondary">Voltar</a>
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
    /**
         Gravar motorista
         */
    $(function() {

        var driver_id = $('#id').val();

        $('#btn-driver-save').click(function() {
            ajax_store(driver_id, "rents/drivers", $('#form-create-driver').serialize());
        });

    });
</script>
@endsection