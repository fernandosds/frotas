@extends('layouts.app')

@section('content')

<div class="kt-portlet">
    <div class="kt-portlet kt-portlet--mobile">

        <form id="form_finalize_contract">

            <!-- HEADER -->
            @csrf

            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand {{$icon}}"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{$title}} <small>{{$contract->id}}</small>
                    </h3>

                </div>

            </div>


            <div class="kt-portlet__body">

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputName"><b>Nome:</b> </label>
                        <span id="name">{{$contract->customer->name}}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputCpfCnpj"><b>CNPJ:</b> </label>
                        <span id="cpf_cnpj">{{$contract->customer->cpf_cnpj}}</span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputName"><b>Tipo:</b> </label>
                        <span id="type">{{$contract->customer->type}}</span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputCEP"><b>CEP:</b> </label>
                        <span id="cep">{{$contract->customer->cep}}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress"><b>Endereço:</b> </label>
                        <span id="address">{{$contract->customer->address}}</span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputComplement"><b>Complemento:</b> </label>
                        <span id="complement">{{$contract->customer->complement}}</span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputCpfCnpj"><b>Número:</b> </label>
                        <span id="number">{{$contract->customer->number}}</span>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="inputCity"><b>Cidade:</b> </label>
                        <span id="city">{{$contract->customer->city}}</span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputUF"><b>UF:</b> </label>
                        <span id="state">{{$contract->customer->state}}</span>
                    </div>
                </div>

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
                                    <th scope="col"></th>
                                    <th scope="col">Tecnologia</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contract->contractDevice as $device)
                                <tr id="_tr_user_{{$device->id}}">
                                    <td data-id="{{$device->id}}">{{$loop->iteration}}</td>
                                    <td data-technologie_id="{{$device->technologie->id  ?? ''}}">{{$device->technologie->type ?? 'Disp. Móvel'}}</td>
                                    <td data-quantity_id="{{$device->quantity}}">{{$device->quantity}}</td>
                                    <td>R$ {{ number_format($device->total,2,",",".")}}</td>
                                    <td>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-primary btn-device-indexed" id="_btn_devices_{{$device->id}}" data-toggle="modal" data-id="{{$device->id}}" data-technologie="{{$device->technologie->id ?? ''}}" data-target="#exampleModal">
                                                <span class="fa fa-fw fa-search-plus"></span> Dispositivos cadastrados
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="btn-attach-indexed">Iscas Cadastradas</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row col md-12" id="list_devices">
                                    <i class="fa fa-spinner fa-pulse fa-5x"></i>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
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
                                    @if($contract->status == 0)
                                    <button type="button" class="btn btn-brand" id="btn-contract-save"><i class="fa fa-check"></i> Finalizar</button>
                                    @endif
                                    <a href="{{url('logistics/contracts/completed')}}" class="btn btn-secondary">Voltar</a>
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

        </form>

    </div>

</div>
<!--end::Modal-->

@endsection

@section('scripts')
<script>
    /**
         Exibir Iscas cadastradas

    $(function() {
        var id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{url('customers/contacts/show')}}/" + id,
            success: function(response) {
                $('#list_contacts').html(response)
            }

        })
    })
    */

    /**
     Display Contracts
     */

    $(function() {


        $('.btn-device-indexed').click(function() {
            var id = $(this).data('id');
            var dataTechnologie = $('#_btn_devices_' + id).data('technologie');

            if (dataTechnologie != "") {
                var url = "{{url('logistics/contracts/devices/filter')}}/" + id;
            } else {
                var url = "{{url('logistics/contracts/devices/filter/tracker')}}/" + id
            }
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#list_devices').html(response)
                }
            })
        });
    });

    /**
     Add Device
    */

    /**
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
 */
    $(function() {

        /* Salvar devices */
        $('.btn-attach-device').click(function() {

            $(this).html("<i class='fa fa-pulse fa-spinner'></i> Aguarde...");
            var id = $(this).data('id');

            $.ajax({
                url: "{{url('logistics/contracts/devices/attach')}}/" + id,
                method: 'GET',
                success: function(response) {

                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Dispositivos vinculados com sucesso',
                            showConfirmButton: true
                        });
                        $("#_btn_devices_" + id).hide();
                        $("#_after_" + id).html("<i class='fa fa-check text-success'></i> Vínculo efetuada");

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Erro ao tentar vincular os dispositivos!',
                            text: response.message,
                            showConfirmButton: true
                        })
                        $("#_btn_devices_" + id).html("<span class='fa fa-fw fa-folder-plus'></span> Vincular Dispositivos");
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
                            timer: 10000
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
        });

    });
</script>
@endsection
