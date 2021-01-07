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
                    {{$title}} <small>Novo</small>
                </h3>

            </div>

            <div class="kt-portlet__head-toolbar">
                <form id="form-search-customer">
                    @csrf
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions mx-2">
                            <input type="text" id="input-search" name="cpf_cnpj" placeholder="Digite CPF/CNPJ" class="form-control input_cpf_cnpj" value="">
                        </div>

                        <button type="button" id="btn-search" class="btn btn-outline-hover-success btn-sm btn-icon"><i class="fa fa-search"></i></button>

                    </div>
                </form>
            </div>

        </div>


        <div class="kt-portlet__body">

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
                <div class="form-group col-md-2">
                    <label for="inputUF">ID: </label>
                    <span id="id"></span>
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


        <input type="hidden" name="id" id="id" value="{{ $contract->id ?? '' }}" />

        <div class="kt-portlet__body">

            <div class="form-row">
                <div class=" form-group col-md-12" id='table-new-devices' style="height: 250px; overflow-y: scroll;">


                </div>

            </div>

            <div class="kt-form__actions">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="flaticon-add-circular-button"></i>
                            Adicionar Dispositivo
                        </button>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputvalor">Valor Total - R$: </label>
                        <span id="valor"></span>
                    </div>

                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="form-group ">
                                <h5 class="modal-title" id="exampleModalLongTitle">Adicionando Iscas</h5>
                                <label for="dadostexto">Separar os números de séries da isca por vírgula</label>
                            </div>
                        </div>
                        <form>
                            @csrf
                            <div class="modal-body" id="list_devices">
                                <textarea id="new-device" name="textarea" rows="8" cols="70"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-contract-new-contract">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-12 ml-lg-auto">
                            <button type="button" class="btn btn-brand" id="btn-contract-save">Cadastrar</button>
                            <a href="{{url('contracts')}}" class="btn btn-secondary">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="form-group">

                </div>
            </div>

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

            var contract_id = $('#id').val();

            ajax_store(contract_id, "contracts", $('#form-create-contract').serialize());

        });

    });

    /**
     Add Device     
    */

    $(function() {

        $('#btn-contract-new-contract').click(function() {
            var route = 'contracts/adddevice';
            var contract_id = $('#id').val();

            $.ajax({
                url: "{{url('')}}/" + route,
                method: 'POST',
                data: {
                    "new-device": $('#new-device').val()
                },
                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Registro salvo com sucesso',
                        showConfirmButton: true,
                        timer: 3000
                    }).then((result) => {

                        //$(location).attr('href', '{{url("")}}/' + route);
                    });
                    $('#table-new-devices').html(response);
                }

            });


        });

    });


    /**
     Delete Device     
    */

    $("#table-new-devices").on("click", ".btn-delete-device", function() {
        
        var id = $(this).data('id') + 1;
        //alert(id)

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Tem certeza?',
            text: "Deseja realmente deletar o registro " + id,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim!',
            cancelButtonText: 'Não!',
            reverseButtons: true
        }).then((result) => {
            console.log(result)
            if (result.value) {

                $.ajax({
                    method: 'GET',
                }).done(function(data) {                    
                    Swal.fire({
                        type: 'success',
                        title: 'Registro excluído com sucesso',
                        showConfirmButton: true,
                        timer: 3000,                        
                    })
                    $(this).closest('tr').fadeOut(300);

                }).fail(function(data) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro ao tentar excluir!',
                        showConfirmButton: true,
                        timer: 2500
                    })
                });

            }
        })

        //$(this).closest('tr').fadeOut(300);

        //var url = "{{url('contracts/delete')}}/" + id;
        /**
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Tem certeza?',
                    text: "Deseja realmente deletar o registro " + id,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim!',
                    cancelButtonText: 'Não!',
                    reverseButtons: true
                }).then((result) => {
                    console.log(result)
                    if (result.value) {

                        $.ajax({
                            url: url,
                            method: 'GET',
                        }).done(function(data) {
                            $('#_tr_user_' + id).hide()
                            Swal.fire({
                                type: 'success',
                                title: 'Registro excluído com sucesso',
                                showConfirmButton: true,
                                timer: 3000
                            })
                        }).fail(function(data) {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Erro ao tentar excluir!',
                                showConfirmButton: true,
                                timer: 2500
                            })
                        });

                    }
                })
         */
    });
</script>
@endsection