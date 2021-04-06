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
                            <a href="{{url('management/users/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                            <th scope="col">Login</th>
                            @if(Auth::user()->type == "sat")
                                <th scope="col">Tipo</th>
                            @endif
                            <th scope="col">Nível de Acesso</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr id="_tr_user_{{$user->id}}">
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>                              

                                @if(Auth::user()->type == "sat")
                                    <td>{{ ($user->type == "sat" ) ? "Sat" : "Externo" }}</td>
                                @endif

                                <td>
                                    @if( $user->access_level == "shipper" )
                                        Embarcador
                                    @elseif( $user->access_level == "commercial" )
                                        Comercial
                                    @elseif( $user->access_level == "logistic" )
                                        Logística
                                    @elseif( $user->access_level == "production" )
                                        Produção
                                    @elseif( $user->access_level == "management" )
                                        Administrador
                                    @endif
                                </td>

                                <td>{{$user->customer->name ?? ''}}</td>
                                <td>

                                    @if( $user->status == 1 )
                                        <i class="text-success fa fa-circle"></i> Ativo
                                    @else
                                        <i class="text-danger fa fa-circle"></i>  Inativo
                                    @endif

                                </td>
                                <td>
                                    <div class="pull-right">
                                        <a href="{{url('management/users/edit')}}/{{$user->id}}" class="btn btn-sm btn-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                        <button type="button" class="btn btn-sm  btn-danger btn-delete-user" data-id="{{$user->id}}" @if( Auth::user()->id == $user->id ) disabled @endif>
                                            <span class="fa fa-fw fa-trash"></span> Deletar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {!! $users->links() !!}
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        /* Deletar */
        $('.btn-delete-user').click(function(){
            var id = $(this).data('id');
            var url = "{{url('management/users/delete')}}/"+id;
            ajax_delete(id, url)
        })

    </script>
@endsection