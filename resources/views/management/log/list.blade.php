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
                        <!--<th scope="col">ID</th>-->
                        <th scope="col">Usuário</th>
                        <th scope="col">Descricão</th>
                        <th scope="col">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr id="_tr_user_{{$log->id}}">
                        <!--<th scope="row">{{$loop->iteration}}</th>-->
                        <td>{{$log->user->name ?? ''}}</td>
                        <td>{{$log->description}}</td>
                        <td>{{date_format($log->created_at, "d/m/Y H:m:s")}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $logs->links() !!}
            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    /* Deletar */
    $('.btn-delete-log').click(function() {
        var id = $(this).data('id');
        var url = "{{url('logs/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection
