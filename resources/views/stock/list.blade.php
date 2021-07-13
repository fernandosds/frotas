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
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                    <tr id="_tr_user_{{$device->id}}">
                        <th scope="row">{{$device->id}}</th>
                        <td>{{$device->model}}</td>
                        <td>{{$device->technologie->type ?? ''}}</td>
                        <td>
                            <div class="pull-right">
                                <!--
                                        <a href="{{url('devices/edit')}}/{{$device->id}}" class="btn btn-sm btn-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                        <button type="button" class="btn btn-sm  btn-danger btn-delete-device" data-id="{{$device->id}}">
                                            <span class="fa fa-fw fa-trash"></span> Deletar
                                        </button>
                                        -->
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
    /* Deletar */
    $('.btn-delete-device').click(function() {
        var id = $(this).data('id');
        var url = "{{url('devices/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection
