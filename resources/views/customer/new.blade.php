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

<form class="kt-form kt-form--label-right" id="form-create-customer">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $customer->id ?? '' }}" />

    <div class="kt-portlet__body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputName">Nome</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $customer->name ?? '' }}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCpfCnpj">CPF / CNPJ</label>
                <input type="text" name="cpf_cnpj" class="form-control" id="cpf_cnpj" value="{{ $customer->cpf_cnpj ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Endereço</label>
                <input type="text" class="form-control" name="address" id="address" value="{{ $customer->address ?? '' }}">
            </div>
            <div class="form-group col-md-4">
                <label for="inputComplement">Complemento</label>
                <input type="text" class="form-control" name="complement" id="complement" value="{{ $customer->complement ?? '' }}">
            </div>
            <div class="form-group col-md-2">
                <label for="inputNumber">Número</label>
                <input type="text" class="form-control" name="number" id="number" value="{{ $customer->number ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inpuCity">Cidade</label>
                <input type="text" class="form-control" name="city" id="city" value="{{ $customer->city ?? '' }}">
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Estado</label>
                <input type="text" class="form-control" name="state" id="state" value="{{ $customer->state ?? '' }}">
            </div>
            <div class="form-group col-md-4">
                <label for="inputNeighborhood">Bairro</label>
                <input type="text" class="form-control" name="neighborhood" id="neighborhood" value="{{ $customer->neighborhood ?? '' }}">
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputType">Tipo</label>
                <select id="inputType" class="form-control">
                    <option selected  value="embarcado" {{ ($customer->type ?? null) == 'embarcado' ? 'selected' : ''}}>Embarcado</option>
                    <option  value="transportadora" {{ ($customer->type ?? null) == 'transportadora' ? 'selected' : ''}}>Transportadora</option>
                    <option value="cliente" {{ ($customer->type ?? null) == 'cliente' ? 'selected' : ''}}>Cliente</option>
                </select>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12 ml-lg-auto">
                        <button type="button" class="btn btn-brand" id="btn-customer-save">Cadastrar</button>
                        <a href="{{url('customers')}}" class="btn btn-secondary">Voltar</a>
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

        $('#btn-customer-save').click(function() {

            var customer_id = $('#id').val();

            ajax_store(customer_id, "customers", $('#form-create-customer').serialize());

        });

    });
</script>
@endsection