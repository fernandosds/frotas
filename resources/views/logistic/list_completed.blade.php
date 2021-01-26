@extends('layouts.app')

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
                    {{$title}}
                </h3>
            </div>

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <!--<a href="{{url('typeofloads/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i> Novo
                            </a>
                            -->
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nº Contrato</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data de criação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics as $logistic)
                    <tr id="_tr_user_{{$logistic->id}}">
                        <th scope="row">{{$logistic->id}}</th>
                        <td>{{$logistic->customer->name}}</td>
                        <td>{{ date_format($logistic->created_at, "d/m/Y") }}</td>
                        <td>
                            <div class="pull-right">
                                <!-- Button trigger modal -->
                                

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ...
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <a href="{{url('logistics/contracts/edit')}}/{{$logistic->id}}" class="btn btn-sm btn-info"><span class="fa fa-eye"></span> Detalhes</a> -->
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal"><span class="fa fa-eye"></span>
                                    Íscas adquiridas
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">

            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#myModal').on('shown.bs.modal', function() {
        $('#myInput').trigger('focus')
    })
</script>
@endsection