@extends('layouts.app')

@section('styles')
<style>
    .div-btn-isca {
        display: none
    }

    .div-btn-movel {
        display: none
    }

    .div-exemplo-isca {
        margin-top: 30px;
        display: none
    }

    .div-exemplo-movel {
        margin-top: 30px;
        display: none
    }
</style>
@endsection

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

                    {{$title}} <small>Alterar</small>

                </h3>
            </div>
        </div>
        <form class="kt-form kt-form--label-right" id="form-create-device" method="post" enctype="multipart/form-data">
            @csrf
            <div class="kt-portlet__body">
                <div class="row kt-margin-b-20">
                    <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <div class="kt-portlet__body">
                            <label>Registro:</label>
                            <input type="text" readonly name="registro" id="registro" class="form-control pull-right" value="{{$device->id ?? ''}}" />
                        </div>
                    </div>
                    <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <div class="kt-portlet__body">
                            <div class="form-row">
                                <label for="input">Selecione um cliente</label>
                                <select class="form-control" name="acustomer_id" id="acustomer_id">
                                    @if(isset($device->customer))
                                        @foreach($customers as $customer)
                                            @if($device->customer->id == $customer->id)
                                                <option value="{{$customer->id}}" selected>{{$customer->name}}</option>
                                            @else
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <div class="kt-portlet__body">
                            <div class="form-row">
                                <label>Modelo:</label>
                                <input type="text" readonly name="amodel" id="amodel" class="form-control pull-right" value="{{$device->model ?? ''}}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <div class="kt-portlet__body">
                            <div class="form-row">
                                <label for="input">Selecione tipo de bateria</label>

                                <select class="form-control" name="technologie_id" id="technologie_id">
                                    @if(isset($device->technologie))
                                        @foreach($technologies as $technologie)
                                            @if($technologie->id == $device->technologie->id)
                                                <option value="{{$technologie->id}}" selected>
                                                    {{$device->technologie->type}}
                                                </option>
                                            @else
                                                <option value="{{$technologie->id}}">
                                                    {{$technologie->type}}
                                                </option>  
                                            @endif
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <div class="kt-portlet__body">
                            <div class="form-row">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{url('stocks/')}}" class="btn btn-secondary">Voltar</a>
                <button type="button" class="btn btn-primary" id="btn-device-alterar">Alterar</button>
            </div>
        </form>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {

        $('#btn-device-alterar').click(function() {
            var form_data = {
                "_token"        : "{{ csrf_token() }}",
                'registro'      : $('#registro').val(),
                'model'         : $('#amodel').val(),
                'technologie_id': $('#technologie_id option:selected').val(),
                'customer_id'   : $('#acustomer_id option:selected').val(),
            };
            $.ajax({
                url: '{{url("/stocks/update")}}' + "/" + $('#registro').val(),
                type: 'POST',
                data: form_data,
                success: function(response) {
                    console.log("response: " + response.status);
                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Registro salvo com sucesso',
                            showConfirmButton: true,
                            timer: 10000
                        }).then(function(){
                            $(location).attr('href', '{{url("stocks")}}/');
                        })
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro ao tentar salvar! ' + response.message,
                            showConfirmButton: true,
                            timer: 10000
                        })
                    }
                },
                error: function(error) {
                    if (error.responseJSON.response == "internal_error") {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                            showConfirmButton: true,
                            timer: 10000
                        })

                    } else if (error.responseJSON.response == "validation_error") {
                        var items = error.responseJSON.errors;
                        Swal.fire({
                            type: 'error',
                            title: 'Erro!',
                            html: 'Os seguintes erros foram encontrados: ' + items,
                            footer: ' '
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
