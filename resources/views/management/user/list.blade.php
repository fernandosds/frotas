@extends('layouts.app')

@section('content')
@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" />
<style>
    .hidden {
        display: none;
    }

    th {
        font-size: 12px;
    }

    td {
        font-size: 12px;
    }
</style>
@endsection

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
            <table id="example" class="display">
                <thead>
                    <tr>
                        <!-- <th scope="col"></th> -->
                        <th scope="col">Nome</th>
                        <th scope="col">Login</th>
                        @if(Auth::user()->type == "sat")
                        <th scope="col">Tipo</th>
                        @endif
                        <th scope="col">Nível de Acesso</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr id="_tr_user_{{$user->id}}">
                        <!-- <th scope="row">{{$loop->iteration}}</th> -->
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>

                        @if(Auth::user()->type == "sat")
                        <td> @if( $user->type == "sat" )
                            Sat
                            @elseif( $user->type == "ext" )
                            Externo
                            @elseif( $user->type == "fle" )
                            Ges.Frotas
                            @elseif( $user->type == "gfl" )
                            Ges.Grandes Frotas
                            @endif
                        </td>
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
                            @elseif( $user->access_level == "fleets" )
                            Gestão de Frotas
                            @elseif( $user->access_level == "fleetslarge" )
                            Ges. Grandes Frotas
                            @endif
                        </td>

                        <td>{{$user->customer->name ?? ''}}</td>
                        <td>

                            @if( $user->status == 1 )
                            <i class="text-success fa fa-circle"></i> Ativo
                            @else
                            <i class="text-danger fa fa-circle"></i> Inativo
                            @endif

                        </td>
                        <td style="width: 200px;">
                            <div class="pull-right">
                                <a href="{{url('management/users/edit')}}/{{$user->id}}" class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle" title="Editar"><span class="fa fa-fw fa-edit"></span></a>
                                <button type="button" title="Deletar Usuário" class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle btn-delete-user" data-id="{{$user->id}}" @if( Auth::user()->id == $user->id ) disabled @endif>
                                    <span class="fa fa-fw fa-trash"></span>
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
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" integrity="" crossorigin=""></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function() {
        columns = [0, 1, 2];
        columsPdf = [0, 1, 2];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        var oTable = $('#example').DataTable({
            "order": [00, 'asc'],
            "columnDefs": [{
                "targets": 05,
                "orderable": false
            }],
            //"bDestroy": true,
            dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Registro_de_Log_' + date,
                    exportOptions: {
                        columns: columsPdf
                    },
                    orientation: 'landscape',
                },
                {
                    extend: 'excel',
                    title: 'SAT Company :: Registro_de_Log_' + date,
                    exportOptions: {
                        columns: columns
                    }
                }
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Nenhum registro encontrado",
                "sEmptyTable": "Nenhuma cerca cadastrada no sistema",
                "sInfo": "Mostrando registros de _START_ até _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros de 0 até 0 de um total de 0 registros",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Carregando...",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sLast": "Último",
                    "sNext": "Seguinte",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Ativar para ordenar a coluna de maneira ascendente",
                    "sSortDescending": ": Ativar para ordenar a coluna de maneira descendente"
                }
            },

        });

    });




    /* Deletar */
    $('.btn-delete-user').click(function() {
        var id = $(this).data('id');
        var url = "{{url('management/users/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection
