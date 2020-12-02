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
                    <a href="{{url('accommodationlocations/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                    <th scope="col">Tipo</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accommodationLocations as $accommodationlocation)
                    <tr id="_tr_user_{{$accommodationlocation->id}}">
                        <th scope="row">{{$accommodationlocation->id}}</th>
                        <td>{{$accommodationlocation->type}}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="pull-right">
                                <a href="{{url('accommodationlocations/edit')}}/{{$accommodationlocation->id}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-accommodationlocation" data-id="{{$accommodationlocation->id}}">
                                    <span class="fa fa-fw fa-trash"></span> Deletar
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {!! $accommodationLocations->links() !!}
        </div>

    </div>

@endsection

@section('scripts')
    <script>

        /* Deletar */
        $('.btn-delete-accommodationlocation').click(function(){
            var id = $(this).data('id');
            var url = "{{url('accommodationlocations/delete')}}/"+id;
            ajax_delete(id, url)
        })

    </script>
@endsection