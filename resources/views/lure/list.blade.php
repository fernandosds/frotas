@extends('layouts.app')

@section('content')

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
                    <a href="{{url('lures/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                    <th scope="col">Tipo de Isca</th>
                    <th scope="col">Número de série</th>
                    <th scope="col">Nível de bateria</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lures as $lure)
                    <tr id="_tr_user_{{$lure->id}}">
                        <th scope="row">{{$lure->id}}</th>
                        <td>{{$lure->type_of_lure_id}}</td>
                        <td>{{$lure->serial_number}}</td>
                        <td>{{$lure->batery_level}}</td>
                        <td>
                            <div class="pull-right">
                                <a href="{{url('lures/edit')}}/{{$lure->id}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-lure" data-id="{{$lure->id}}">
                                    <span class="fa fa-fw fa-trash"></span> Deletar
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {!! $lures->links() !!}
        </div>

    </div>

@endsection

@section('scripts')
    <script>

        /* Deletar */
        $('.btn-delete-lure').click(function(){
            var id = $(this).data('id');
            var url = "{{url('lures/delete')}}/"+id;
            ajax_delete(id, url)
        })

    </script>
@endsection