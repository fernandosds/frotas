
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
                <a href="{{url('customers/contracts/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                <th scope="col">Estoque</th>
                <th scope="col">Cliente</th>
                <th scope="col">Embarque</th>
                <th scope="col">Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contracts as $contract)
            <tr id="_tr_user_{{$contract->id}}">
                <th scope="row">{{$contract->stock_id}}</th>
                <td>{{ !empty($contract->customer) ? $contract->customer->name:'' }}</td>
                <td>{{$contract->shipment_id}}</td>
                <td>{{$contract->type}}</td>
                <td>
                    <div class="pull-right">
                        <a href="{{url('customers/contracts/edit')}}/{{$contract->id}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                        <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-contract" data-id="{{$contract->id}}">
                            <span class="fa fa-fw fa-trash"></span> Deletar
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        @if (\Request::is('customers/contracts/'))
            {!! $contracts->links() !!}
        @endif
    </div>

</div>

@endsection

@section('scripts')
<script>
    /* Deletar */
    $('.btn-delete-contract').click(function() {
        var id = $(this).data('id');
        var url = "{{url('customers/contracts/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection