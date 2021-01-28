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
                            <a href="{{url('devices/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i> Novo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="kt-portlet__body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Tecnologia</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Nº Contrato</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $device)
                            <tr id="_tr_user_{{$device->id}}">
                                <th scope="row">{{$device->id}}</th>
                                <td>{{$device->model}}</td>
                                <td>{{$device->technologie->type}}</td>
                                <td>{{$device->customer->name ?? ''}}</td>
                                <td>{{$device->contract_id ?? ''}}</td>
                                <td>
                                    <div class="pull-right">

                                        @if( $device->customer == null || $device->contract_id == null )
                                            <button type="button" class="btn btn-sm  btn-danger btn-delete-device" data-id="{{$device->id}}">
                                                <span class="fa fa-fw fa-trash"></span> Deletar
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm  btn-danger" disabled>
                                                <span class="fa fa-fw fa-trash"></span> Deletar
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {!! $devices->links() !!}
                </div>

            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>

        /* Deletar */
        $('.btn-delete-device').click(function(){
            var id = $(this).data('id');
            var url = "{{url('production/devices/delete')}}/"+id;
            ajax_delete(id, url)
        })

    </script>
@endsection