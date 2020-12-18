@extends('layouts.app')

@section('content')

<!-- HEADER -->
<meta name="csrf-token" content="{{ csrf_token() }}" />

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

    </div>

</div>


<div class="kt-portlet__body">
    <form id="form-search-customer">
        @csrf
        <div class="kt-portlet__head-wrapper">
            <div class="kt-portlet__head-actions mx-2">
                <input type="text" id="input-search" name="cpf_cnpj" placeholder="Digite CPF/CNPJ" class="form-control" value="">
            </div>

            <button type="button" id="btn-search" class="btn btn-outline-hover-success btn-sm btn-icon"><i class="fa fa-search"></i></button>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputName">Nome: </label>
                <span id="name"></span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputCpfCnpj">CNPJ: </label>
                <span id="cpf_cnpj"></span>
            </div>
            <div class="form-group col-md-4">
                <label for="inputName">Tipo: </label>
                <span id="type"></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="inputCEP">CEP: </label>
                <span id="cep"></span>
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress">Endereço: </label>
                <span id="address"></span>
            </div>
            <div class="form-group col-md-2">
                <label for="inputComplement">Complemento: </label>
                <span id="complement"></span>
            </div>
            <div class="form-group col-md-2">
                <label for="inputCpfCnpj">Número: </label>
                <span id="number"></span>
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="inputCity">Cidade: </label>
                <span id="city"></span>
            </div>
            <div class="form-group col-md-2">
                <label for="inputUF">UF: </label>
                <span id="state"></span>
            </div>
        </div>
    </form>
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
        <div class="col-xs-6 col-sm-6 col-md-4">
            <div class="form-group">
                <label>CPF/CNPJ</label>
                <input type="text" id="teste" name="cpfCnpj" class="form-control">
            </div>
        </div>


    </div>




</form>

<!--end::Modal-->

@endsection

@section('scripts')
<script>
    /** 
     * Mask CPF / CNPJ
     * 
     */
    $(document).on('keydown', '#input-search', function(e) {

        var digit = e.key.replace(/\D/g, '');

        var value = $(this).val().replace(/\D/g, '');

        var size = value.concat(digit).length;

        $(this).mask((size <= 11) ? '000.000.000-00' : '00.000.000/0000-00');
    });



    /**
     Search customers     
     */

    $(function() {

        $("#btn-search").on("click", function() {

            //var input_search = $("#input-search").val();
            var input_search = $("#form-search-customer").serialize();
            var route = "contracts";

            var customer = ajax_find_data(input_search, route);


        });
    });



    $(function() {

        $('#btn-contract-save').click(function() {

            var contract_id = $('#id').val();

            ajax_store(contract_id, "customers/contracts", $('#form-create-contract').serialize());

        });

    });
</script>
@endsection