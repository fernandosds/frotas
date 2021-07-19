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
                    <div class="kt-portlet__head-actions"></div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                    <tr id="_tr_user_{{$device->id}}">
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$device->model ?? ''}}</td>
                        <td>{{$device->technologie->type ?? ''}}</td>
                        <td>{{$device->status ?? ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="kt-portlet__body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trackers as $tracker)
                    <tr id="_tr_user_{{$tracker->id}}">
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$tracker->model ?? ''}}</td>
                        <td>{{'Disp. Móvel'}}</td>
                        <td>{{$device->status ?? ''}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
