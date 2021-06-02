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
                        <a href="{{url('fleets/drivers/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                        <th scope="col">CNH</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Nº Cartão</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                    <tr id="_tr_user_{{$driver->id}}">
                        <th scope="row">{{$driver->id}}</th>
                        <td>{{$driver->name}}</td>
                        <td>{{$driver->cnh}}</td>
                        <td>{{$driver->email}}</td>
                        <td>{{ $driver->status == 0 ? 'Ativo' : 'Bloqueado' }}</td>
                        <td>{{$driver->card->serial_number ?? 'Nenhum cartão atribuído'}}</td>
                        <td>
                            <div class="pull-right">
                                <a href="{{url('fleets/drivers/edit')}}/{{$driver->id}}" class="btn btn-sm btn-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                <button type="button" class="btn btn-sm  btn-danger btn-delete-driver" data-id="{{$driver->id}}">
                                    <span class="fa fa-fw fa-trash"></span> Deletar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $drivers->links() !!}
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* Deletar */
    $('.btn-delete-driver').click(function() {
        var id = $(this).data('id');
        var url = "{{url('fleets/drivers/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection
