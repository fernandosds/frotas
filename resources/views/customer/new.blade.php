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
                <input type="text" name="name" class="form-control" value="{{ $customer->name ?? '' }}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCpfCnpj">CPF / CNPJ</label>
                <input type="text" name="cpf_cnpj" class="form-control" value="{{ $customer->cpf_cnpj ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Endereço</label>
                <input type="text" class="form-control" name="address" value="{{ $customer->address ?? '' }}">
            </div>
            <div class="form-group col-md-2">
                <label for="inputAddress">CEP</label>
                <input type="text" class="form-control" name="cep" value="{{ $customer->cep ?? '' }}">
            </div>
            <div class="form-group col-md-2">
                <label for="inputComplement">Complemento</label>
                <input type="text" class="form-control" name="complement" value="{{ $customer->complement ?? '' }}">
            </div>
            <div class="form-group col-md-2">
                <label for="inputNumber">Número</label>
                <input type="text" class="form-control" name="number" value="{{ $customer->number ?? '' }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inpuCity">Cidade</label>
                <input type="text" class="form-control" name="city" value="{{ $customer->city ?? '' }}">
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">Estado</label>
                <input type="text" class="form-control" name="state" value="{{ $customer->state ?? '' }}">
            </div>
            <div class="form-group col-md-4">
                <label for="inputNeighborhood">Bairro</label>
                <input type="text" class="form-control" name="neighborhood" value="{{ $customer->neighborhood ?? '' }}">
            </div>
        </div>


        <div class="form-row">

            <div class="form-group col-md-4">
                <label class="inputType">Tipo</label>
                <select class="form-control" name="type">
                    <option value=" ">Selecione um tipo</option>
                    <option value="embarcado" {{ ($customer->type ?? null) == 'embarcado' ? 'selected' : ''}}>Embarcado</option>
                    <option value="transportadora" {{ ($customer->type ?? null) == 'transportadora' ? 'selected' : ''}}>Transportadora</option>
                    <option value="cliente" {{ ($customer->type ?? null) == 'cliente' ? 'selected' : ''}}>Cliente</option>
                </select>
            </div>
            <div class="form-group col-md-4">


                <button type="button" class="btn btn-outline-brand btn-sm " data-toggle="modal" data-target="#kt_modal_4">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    Novo Contato
                </button>
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

        <div id="contacts">Lista</div>
    </div>
</form>

<!--begin::Modal-->
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionando contato</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-contact">

                    <input type="hidden" name="customer_id" value="{{$customer->id ?? ''}}" />

                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Telefone</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-customer-new-contact">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->

@endsection

@section('scripts')
<script>
    $(function() {

        $('#btn-customer-new-contact').click(function() {

            var dados = $('#form-create-contact').serialize();
            var id = $('#id').val();

            $.ajax({
                type: 'PUT',
                dataType: 'json',
                url: "{{url('')}}/contacts/update/" + id,
                async: true,
                data: dados,
                success: function(response) {

                    if (response.status == "success") {


                        $('#contacts').html(response);



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

            return false;
        });
    });





    $(function() {

        $('#btn-customer-save').click(function() {

            var customer_id = $('#id').val();

            ajax_store(customer_id, "customers", $('#form-create-customer').serialize());

        });

    });
</script>
@endsection