@extends('layouts.app')

@section('content')

<div class="kt-portlet">
    <div class="kt-portlet kt-portlet--mobile">

        <!-- HEADER -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand {{$icon}}"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{$title}} <small>{{$contract->id}}</small>
                </h3>

            </div>

            <div class="kt-portlet__head-toolbar">
                <form id="form-search-customer">
                    @csrf
                    <div class="kt-portlet__head-wrapper">

                    </div>
                </form>
            </div>

        </div>


        <div class="kt-portlet__body">

            <input type="hidden" name="contract_id" id="contract_id" value="{{ $contract->id ?? '' }}" />
            <input type="hidden" name="customer_id" id="customer_id" value="{{ $contract->customer->id ?? '' }}" />


            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputName">Nome: </label>
                    <span id="name">{{$contract->customer->name}}</span>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputCpfCnpj">CNPJ: </label>
                    <span id="cpf_cnpj">{{$contract->customer->cpf_cnpj}}</span>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputName">Tipo: </label>
                    <span id="type">{{$contract->customer->type}}</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputCEP">CEP: </label>
                    <span id="cep">{{$contract->customer->cep}}</span>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputAddress">Endereço: </label>
                    <span id="address">{{$contract->customer->address}}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputComplement">Complemento: </label>
                    <span id="complement">{{$contract->customer->complement}}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputCpfCnpj">Número: </label>
                    <span id="number">{{$contract->customer->number}}</span>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputCity">Cidade: </label>
                    <span id="city">{{$contract->customer->city}}</span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputUF">UF: </label>
                    <span id="state">{{$contract->customer->state}}</span>
                </div>
            </div>

        </div>

        <div class="form-row">
        </div>

        <div class="kt-portlet__head kt-portlet__head--lg">
            <h3 class="kt-portlet__head-title">
                <small>Dados do contrato</small>
            </h3>

        </div>


        <div class="kt-portlet__body">
            <!--DIV COM SCROLL -->

            <div class="form-row">
                <div class=" form-group col-md-12" id='table-new-devices' style="height: 250px; overflow-y: scroll;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tecnologia</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contract->contractDevice as $cont)
                            <tr id="_tr_user_{{$cont->id}}">
                                <td>{{$cont->id}}</td>
                                <td data-technologie_id="{{$cont->technologie->id}}">{{$cont->technologie->type}}</td>
                                <td data-quantity_id="{{$cont->quantity}}">{{$cont->quantity}}</td>
                                <td>{{$cont->total}}</td>

                                <td>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-sm  btn btn-outline-primary btn-save-devices" data-id="{{$cont->id}}">
                                            <span class="fa fa-fw fa-folder-plus"></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="kt-form__actions">
                <div class="form-row">
                    <div class="form-group col-md-8">

                    </div>
                </div>

                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12 ml-lg-auto">
                                <button type="button" class="btn btn-brand" id="btn-contract-save">Cadastrar</button>
                                <a href="{{url('logistics')}}" class="btn btn-secondary">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4">
                    <div class="form-group">

                    </div>
                </div>

            </div>
            <!-- FIM DIV COM SCROLL -->

        </div>
    </div>
</div>
<!--end::Modal-->

@endsection

@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    /**
     Modal     
     */

    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })

    /**
     Search customers     
     */

    $(function() {

        $('#btn-search').click(function() {

            var input_search = $('#input-search').val();
            var form_search = $('#form-search-customer').serialize();
            var route = 'contracts';

            ajax_find_data(input_search, form_search, route);


        });
    });

    /**
     Display Contracts     
     */

    $(function() {

        $('#btn-contract-save').click(function() {


            var id = $('#customer_id').val();
            console.log($('#form-insert-device').serialize());

            ajax_store("", "contracts", $('#form-insert-device').serialize());
            //ajax_store("", "contracts", $('#form-create-contract').serialize());

        });

    });

    /**
     Add Device     
    */

    $(function() {

        $('#btn-contract-new-device').click(function() {
            var route = 'contracts/add-device';

            $.ajax({
                url: "{{url('')}}/" + route,
                method: 'POST',
                data: {
                    // "devices": $('#new-device').val(),
                    "technologie_id": $('#technologie_id').val(),
                    "quantity": $('#quantity').val(),
                    "value": $('#value').val(),

                },
                success: function(response) {
                    $('#table-new-devices').html(response);
                    $('#exampleModalCenter').modal('hide')
                }

            });

        });

    });

    $(function() {

        /* Salvar devices */
        $('.btn-save-devices').click(function() {
            var contract_id = $('#contract_id').val();
            var customer_id = $('#customer_id').val();
            var quantity = $(this).closest('tr').find('td[data-quantity_id]').data('quantity_id');
            var technologie_id = $(this).closest('tr').find('td[data-technologie_id]').data('technologie_id');

            var route = 'logistics/contracts/save/device'


            $.ajax({
                url: "{{url('')}}/" + route,
                method: 'POST',
                data: {
                    "contract_id": contract_id,
                    "customer_id": customer_id,
                    "quantity": quantity,
                    "technologie_id": technologie_id,

                },
                success: function(response) {

                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Registro salvo com sucesso',
                            showConfirmButton: true,
                            timer: 3000
                        }).then((result) => {
                            //$(location).attr('href', '{{url("")}}/' + route);
                            //colocar função para bloquear o botão aqui.
                        })

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro ao tentar salvar!',
                            showConfirmButton: true,
                            timer: 2500
                        })
                    }


                },
                error: function(error) {

                    if (error.responseJSON.status == "internal_error") {
                        console.log(error.responseJSON.errors)
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                            showConfirmButton: true,
                            timer: 2500
                        })
                    } else {
                        var items = error.responseJSON.errors;
                        var errors = $.map(items, function(i) {
                            return i.join('<br />');
                        });
                        Swal.fire({
                            type: 'error',
                            title: 'Erro!',
                            html: 'Os seguintes erros foram encontrados: ' + errors,
                            footer: ' '
                        })
                    }
                }

            });
            console.log(data);
        });

    });
</script>
@endsection