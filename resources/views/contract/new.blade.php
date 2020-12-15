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

    <div class="kt-portlet__head-toolbar">
        <div class="kt-portlet__head-wrapper">
            <div class="kt-portlet__head-actions">                
                <select class="form-control" name="type">
                    <option value=" ">Selecione um cliente</option>
                    <option value="embarcado" {{ ($customer->type ?? null) == 'embarcado' ? 'selected' : ''}}>Embarcado</option>
                    <option value="transportadora" {{ ($customer->type ?? null) == 'transportadora' ? 'selected' : ''}}>Transportadora</option>
                    <option value="cliente" {{ ($customer->type ?? null) == 'cliente' ? 'selected' : ''}}>Cliente</option>
                </select>
            </div>
        </div>
    </div>

</div>




<div class="kt-portlet__head kt-portlet__head--lg">
    <h3 class="kt-portlet__head-title">
        <small>Dados do contrato</small>
    </h3>

</div>

<form class="kt-form kt-form--label-right" id="form-create-contract">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $contract->id ?? '' }}" />

    <div class="kt-portlet__body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputName">Estoque</label>
                <input type="text" name="stock_id" class="form-control" value="{{ $contract->stock_id ?? '' }}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCpfCnpj">Embarque</label>
                <input type="text" name="shipment_id" class="form-control" value="{{ $contract->shipment_id ?? '' }}">
            </div>
        </div>
        <div class="form-row">

            <div class="form-group col-md-2">
                <label class="inputTipo">Tipo de contrato</label>
                <select class="form-control" name="type">
                    <option value=" ">Selecione um tipo</option>
                    <option value="Retornavel" {{ ($contract->type ?? null) == 1 ? 'selected' : ''}}>Retornavel</option>
                    <option value="Descartavel" {{ ($clurestomer->type ?? null) == 2 ? 'selected' : ''}}>Descartavel</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="inputComplement">Validade</label>
                <input type="date" class="form-control" name="validity" value="{{ $contract->validity ?? '' }}">
            </div>

        </div>
        <div class="form-row">

        </div>

        <div class="form-row">

        </div>

        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12 ml-lg-auto">
                        <button type="button" class="btn btn-brand" id="btn-contract-save">Cadastrar</button>
                        <a href="{{url('customers/contracts')}}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




</form>

<!--end::Modal-->

@endsection

@section('scripts')
<script>
    $(function() {

        $('#btn-contract-save').click(function() {

            var contract_id = $('#id').val();

            ajax_store(contract_id, "customers/contracts", $('#form-create-contract').serialize());

        });

    });
</script>
@endsection