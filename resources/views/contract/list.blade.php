
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
                            <a href="{{url('contracts/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
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
                            <th scope="col">N</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contracts as $contract)
                        <tr id="_tr_user_{{$contract->id}}">
                            <th scope="row">{{$contract->id}}</th>
                            <td>{{ !empty($contract->customer) ? $contract->customer->name:'' }}</td>
                            <td>{{ date_format($contract->created_at, "d/m/Y") }}</td>
                            <td>
                                <div class="pull-right">
                                    <a href="{{url('contracts/edit')}}/{{$contract->id}}" class="btn btn-sm btn-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                                    <button type="button" class="btn btn-sm  btn-danger btn-delete-contract" data-id="{{$contract->id}}">
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
        </div>
    </div>

@endsection

@section('scripts')
<script>
    /* Deletar */
    $('.btn-delete-contract').click(function() {
        var id = $(this).data('id');
        var url = "{{url('contracts/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection