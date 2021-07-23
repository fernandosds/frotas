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
                                    <td data-technologie_id="{{$device->technologie->id ?? 'Disp. Móvel'}}">{{$device->technologie->type ?? 'Disp. Móvel'}}</td>
                                    <td data-quantity_id="{{$device->quantity}}">{{$device->quantity}}</td>
                                    <td>R$ {{ number_format($device->total,2,",",".")}}</td>
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
                                <div class="form-row col md-12" id="list_devices"  >
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
                                    <a href="{{url('contracts/history')}}" class="btn btn-secondary">Voltar</a>
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

@endsection
