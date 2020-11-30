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
                    <a href="{{url('customers/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                    <th scope="col">Nome</th>
                    <th scope="col">CPF/CNPJ</th>
                    <th scope="col">Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr id="_tr_user_{{$customer->id}}">
                        <th scope="row">{{$customer->id}}</th>
                        <td>{{$customer->name}}</td>
                        <td>{{$customer->cpf_cnpj}}/td>
                        <td>{{$customer->type}}</td>
                        <td>
                            <div class="pull-right">
                                <a href="{{url('customers/edit')}}/{{$customer->id}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-user" data-id="{{$customer->id}}">
                                    <span class="fa fa-fw fa-trash"></span> Deletar
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {!! $customers->links() !!}
        </div>

    </div>

@endsection

@section('scripts')
    <script>

        /* Deletar */
        $('.btn-delete-user').click(function(){
            var id = $(this).data('id');
            var url = "{{url('users/delete')}}/"+id;
            ajax_delete(id, url)
        })

    </script>
@endsection