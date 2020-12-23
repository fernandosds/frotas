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
                            <a href="{{url('logs/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                            <th scope="col"></th>
                            <th scope="col">Tipo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr id="_tr_user_{{$log->id}}">
                                <th scope="row">{{$log->id}}</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="pull-right">
                                        <a href="{{url('logs/edit')}}/{{$log->id}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                        <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-log" data-id="{{$log->id}}">
                                            <span class="fa fa-fw fa-trash"></span> Deletar
                                        </button>
                                    </div>
                                </td>
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
        $('.btn-delete-log').click(function(){
            var id = $(this).data('id');
            var url = "{{url('logs/delete')}}/"+id;
            ajax_delete(id, url)
        })

    </script>
@endsection