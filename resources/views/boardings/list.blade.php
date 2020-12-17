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
                    <a href="{{url('boardings/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i> Novo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Telefone</th>
        <th scope="col">Email</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($boardings as $boarding)
        <tr id="_tr_user_{{$boarding->id}}">
            <th scope="row">{{$boarding->id}}</th>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-contact" data-id="{{$boarding->id}}">
                        <span class="fa fa-fw fa-trash"></span> Deletar
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


@endsection

@section('scripts')
    <script>
        /**
         Deletar
         $('.btn-delete-contact').click(function() {
        var id = $(this).data('id');
        var url = "{{url('customers/contacts/delete')}}/" + id;
        ajax_delete(id, url)
    })
         */
    </script>
@endsection