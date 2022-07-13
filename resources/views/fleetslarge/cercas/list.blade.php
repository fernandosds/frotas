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
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <i class="fa fa-car-alt"></i>
                    Grupo de Cercas e Veículos
                </h3>
            </div>
        </div>


        <!-- CONTENT -->
        <div class="kt-portlet__body">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <!-- <th scope="col"></th> -->
                        <th scope="col">Nome da Cerca</th>
                        <th scope="col">Total Veículos</th>
                        <th scope="col">Total Usuários</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($grupos as $grupo)
                    <tr id="_tr_user_{{$grupo->id}}">
                        <td>{{$grupo->nome}}</td>
                        <td>{{count($grupo->grupoCercaRelacionamento)}}</td>
                        <td>{{count($grupo->grupoUsuarioRelacionamento)}}</td>
                        <td style="width: 200px;">
                            <div class="pull-right">
                                <a href="{{ route('fleetslarges.cerca.new') }}/{{$grupo->id}}" class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle" title="Editar"><span class="fa fa-fw fa-edit"></span></a>
                                <button type="button" title="Excluir cerca" data-id="{{$grupo->id}}" class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle btn-delete-cerca">
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
        columsPdf = [0, 1];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        var oTable = $('#example').DataTable({
            "order": [00, 'asc'],
            "columnDefs": [{
                "targets": 02,
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
                "sEmptyTable": "Nenhum registro disponível nesta tabela",
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
    $('.btn-delete-cerca').click(function() {
        var id = $(this).data('id');
        var url = "{{url('fleetslarges/cercas/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection