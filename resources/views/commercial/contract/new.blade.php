@extends('layouts.app')

@section('content')

@section('styles')
<style>
    .div-tecnologia {
        margin-top: 30px;
        display: none
    }

    .div-radio {
        margin-top: 30px;
    }

    .div-header {
        text-align: center;
    }
</style>
@endsection

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
                    <input type="hidden" name="customer_id" id="customer_id" value="" />
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions mx-2">
                            <input type="text" id="input-search" name="cpf_cnpj" placeholder="Digite CPF/CNPJ" class="form-control input_cpf_cnpj" value="{{$customer->cpf_cnpj ?? ''}}">
                        </div>

                        <button type="button" id="btn-search" class="btn btn-outline-hover-success btn-sm btn-icon"><i class="fa fa-search"></i></button>

                    </div>
                </form>
            </div>

        </div>

        <div class="kt-portlet__body">

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputName"><b>Nome:</b> </label>
                    <span id="name"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputCpfCnpj"><b>CNPJ:</b> </label>
                    <span id="cpf_cnpj"></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputName"><b>Tipo:</b> </label>
                    <span id="type"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputCEP"><b>CEP:</b> </label>
                    <span id="cep"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputAddress"><b>Endereço:</b> </label>
                    <span id="address"></span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputComplement"><b>Complemento:</b> </label>
                    <span id="complement"></span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputCpfCnpj"><b>Número:</b> </label>
                    <span id="number"></span>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="inputCity"><b>Cidade:</b> </label>
                    <span id="city"></span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputUF"><b>UF:</b> </label>
                    <span id="state"></span>
                </div>
                <div class="form-group col-md-2">
                    <label for="inputUF"><b>ID:</b> </label>
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
                        <label for="inputvalor" id="label-total">Valor Total - R$: </label>
                        <span id="valor"></span>
                    </div>

                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header div-header">
                            <div class="form-group ">
                                <h5 class="modal-title" id="exampleModalLongTitle">Adicionando Dispositivos</h5>
                            </div>
                        </div>
                        <form id="form-insert-device">
                            @csrf
                            <div class="kt-radio-inline center div-radio">
                                <label class="kt-radio">
                                    <input type="radio" name="checked" value="isca"> Cad. Íscas
                                    <span></span>
                                </label>
                                <label class="kt-radio">
                                    <input type="radio" name="checked" value="dispositivo"> Cad. Dispositivos Móveis
                                    <span></span>
                                </label>
                            </div>
                            <div class="modal-body" id="list_devices">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">
                                        <label class="inputQuantity">Quantidade</label>
                                        <input type="number" id="quantity" name="quantity" placeholder="Quantidade" value="" class="form-control">
                                        <label class="inputValue"></label>
                                        <label class="inputValue">Valor</label>
                                        <input type="number" step="any" id="value" name="value" placeholder="Valor" value="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body div-tecnologia">
                                <label class="inputType">Tecnologia</label>
                                <select class="form-control" name="type" id="technologie_id">
                                    @foreach ($technologies as $technologie)
                                    <option value="{{$technologie->id}}">{{$technologie->type}}</option>
                                    @endforeach
                                    <input type="hidden" name="price" id="price_device" value="{{ $technologie->price ?? '' }}" />
                                    <input type="hidden" name="model" id="model" value="{{ $technologie->type ?? '' }}" />
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btn-contract-new-device">Adicionar</button>
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
                            <a href="{{url('commercial/contracts')}}" class="btn btn-secondary">Voltar</a>
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

    radio = "";
    $('input[type=radio]').change(function() {
        radio = this.value;
        if (radio == "isca") {
            $('.div-tecnologia').show('100');
        } else {
            $('.div-tecnologia').hide();
        }

    });

    // Modal
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })

    // Search customer
    if ($('#input-search').val() != "") {
        searchCustomer()
    }

    $('#btn-search').click(function() {
        searchCustomer()
    });

    function searchCustomer() {
        var input_search = $('#input-search').val();
        var form_search = $('#form-search-customer').serialize();
        var route = 'commercial/customer';
        ajax_find_data(input_search, form_search, route);
    }

    // Save contract
    $('#btn-contract-save').click(function() {
        $('#btn-contract-save').prop('disabled', true);
        var id = $('#customer_id').val();
        ajax_store("", "commercial/contracts", $('#form-search-customer').serialize());
    });

    // Add Device
    $('#btn-contract-new-device').click(function() {
        /**
         * Verifica se o radio está desmarcado
         */
        if (!$("input[type='radio']").is(':checked')) {
            radio = this.value;
            console.log(radio);
            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Selecione um tipo de dispositivo!',
                showConfirmButton: true,
                timer: 10000
            })
            return false;
        }
        var route = 'commercial/contracts/devices/add';
        $.ajax({
            url: "{{url('')}}/" + route,
            method: 'POST',
            data: {
                "technologie_id": $('#technologie_id').val(),
                "technologie_name": $('#technologie_id option:selected').text(),
                "quantity": $('#quantity').val(),
                "value": $('#value').val(),
                "checked": radio,
            },
            success: function(response) {
                $('#table-new-devices').html(response);
                $('#exampleModalCenter').modal('hide')

                $('#quantity').val('')
                $('#value').val('')
            }

        });

    });


    // Remove device
    $("#table-new-devices").on("click", ".btn-delete-device", function() {

        var id = $(this).data('id');

        $.ajax({
            url: "{{url('commercial/contracts/devices/remove')}}",
            method: 'POST',
            data: {
                "id": id

            },
            success: function(response) {
                $('#table-new-devices').html(response);
                $('#exampleModalCenter').modal('hide')
            }

        });
    });
</script>

@endsection
