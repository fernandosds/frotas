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
                            <a href="{{url('boardings/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i> Novo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kt-portlet__body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ordem de Transporte</th>
                        <th scope="col">Nome da Transportadora</th>
                        <th scope="col">Data</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($boardings as $boarding)
                        <tr id="_tr_user_{{$boarding->id}}">
                            <th scope="row">{{$boarding->id}}</th>
                            <td>{{$boarding->transport_order}}</td>
                            <td>{{$boarding->transporter}}</td>
                            <td>{{date_format($boarding->created_at, "d/m/Y")}}</td>
                            <td></td>
                            <td>
                                <div class="pull-right">
                                    <a href="" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Detalhes</a>
                                    <button type="button" class="btn btn-sm  btn-danger btn-delete-boarding" data-id="{{$boarding->id}}">
                                        <span class="fa fa-fw fa-trash"></span> Deletar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>

         // Deletar
         $('.btn-delete-boarding').click(function() {
            var id = $(this).data('id');
            var url = "{{url('boardings/delete')}}/" + id;
            ajax_delete(id, url)
        })

    </script>
@endsection