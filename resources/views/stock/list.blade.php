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
                        <th scope="col">Produto</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                    <tr id="_tr_user_{{$device->id}}">
                        <td>{{'Iscas'}}</td>
                        <td>{{$device->model}}</td>
                        <td>{{$device->technologie->type ?? ''}}</td>
                    </tr>
                    @endforeach
                    @foreach ($trackers as $tracker)
                    <tr id="_tr_user_{{$tracker->id}}">
                        <td>{{'Disp. Móvel'}}</td>
                        <td>{{$tracker->model ?? ''}}</td>
                        <td>{{$tracker->status ?? ''}}</td>
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
