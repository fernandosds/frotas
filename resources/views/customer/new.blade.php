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

<div class="row">
    <div class="col-sm-8">

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
                        <input type="text" id="input_cpf_cnpj_customers" name="cpf_cnpj" class="form-control" value="{{ $customer->cpf_cnpj ?? '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputAddress">Endereço</label>
                        <input type="text" class="form-control" name="address" value="{{ $customer->address ?? '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputAddress">CEP</label>
                        <input type="text" id="input_cep_customers" class="form-control" name="cep" value="{{ $customer->cep ?? '' }}">
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
                        @if (\Request::is('customers/edit/*'))

                        @endif
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
    </div>

    <div class="col-sm-4">

        @if (\Request::is('customers/edit/*'))
        <div class="col-sm-12">
            <br />
            <button type="button" class="btn btn-outline-brand btn-sm pull-right" data-toggle="modal" data-target="#kt_modal_4">
                <i class="fa fa-phone" aria-hidden="true"></i> Adicionar
            </button>
            <h4>Contatos </h4>
            <hr />
        </div>

        <div class="form-row col md-12" id="list_contacts">
            <i class="fa fa-spinner fa-pulse fa-5x"></i>
        </div>
        @else

        <div class="col-sm-12">
            <br />
            <button type="button" class="btn btn-outline-brand btn-sm pull-right" disabled>
                <i class="fa fa-phone" aria-hidden="true"></i> Adicionar
            </button>
            <h4>Contatos </h4>
            <hr />
        </div>
        Antes de adicionar telefone ou email do cliente, é necessário salvar o cadastro.
        @endif

    </div>
</div>








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
                    <input type="hidden" name="customer_id" id="id" value="{{ $customer->id ?? '' }}" />

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">Telefone</label>
                        <input type="text" id="input_contact_customers" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btn-customer-new-contact">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!--end::Modal-->

@endsection

@section('scripts')
<script>
    /**
     Carregar a div de contatos
     */

    /**
    $.ajax({
        type: 'GET',
        
        url: "{{url('customers/contacts')}}",
        success: function(response) {
            $('#list_contacts').html(response)
        }

    })
    */

    /**
     Exibir contato
     */
    $(function() {
        var id = $('#id').val();

        $.ajax({
            type: 'GET',
            url: "{{url('customers/contacts/show')}}/" + id,
            success: function(response) {
                $('#list_contacts').html(response)
            }

        })
    })


    /** 
     * Mask CPF / CNPJ
     * 
     */
    $(function() {

        $(document).on('keydown', '#input_cpf_cnpj_customers', function(e) {

            var digit = e.key.replace(/\D/g, '');

            var value = $(this).val().replace(/\D/g, '');

            var size = value.concat(digit).length;

            $(this).mask((size <= 11) ? '000.000.000-00' : '00.000.000/0000-00');
        });

    });

    /** 
     * Mask CEP
     * 
     */
    $(function() {

        $(document).on('keydown', '#input_cep_customers', function(e) {

            var digit = e.key.replace(/\D/g, '');

            var value = $(this).val().replace(/\D/g, '');

            var size = value.concat(digit).length;

            $(this).mask(('00000-000'));
        });

    });

    /** 
     * Mask Contato
     * 
     */
    $(function() {

        $(document).on('keydown', '#input_contact_customers', function(e) {

            var digit = e.key.replace(/\D/g, '');

            var value = $(this).val().replace(/\D/g, '');

            var size = value.concat(digit).length;

            $(this).mask((size <= 10) ? '(00)0000-0000' : '(00)00000-0000');
        });

    });




    /**
     Deletar
     */

    $("#list_contacts").on("click", ".btn-delete-contact", function() {

        var id = $(this).data('id');
        var url = "{{url('customers/contacts/delete')}}/" + id;
        ajax_delete(id, url)

    });


    /**
    Gravar contato
    */

    $(function() {

        $('#btn-customer-new-contact').click(function() {

            var dados = $('#form-create-contact').serialize();
            var customer_id = $('#id').val();

            ajax_save_contact(dados, customer_id);

        });
    });




    /**
        Gravar cliente
    */
    $(function() {

        $('#btn-customer-save').click(function() {

            var customer_id = $('#id').val();

            ajax_store(customer_id, "customers", $('#form-create-customer').serialize());

        });

    });
</script>
@endsection