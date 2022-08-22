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
                <span class="kt-menu__link-icon"><i class="fa fa-truck-moving"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    <span class="kt-menu__link-text">Lista de iscas</span>
                </h3>
            </div>

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <a href="{{url('production/devices/new')}}">
                        <button type="button" class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle"
                            title="Cadastro de isca"><span class="la la-plus"></span>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">
            <table id="example" class="display">
                <thead>
                    <tr>
                        <!-- <th scope="col"></th> -->
                        <th scope="col">Id</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Tecnologia</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($devices as $device)
                    <tr id="_tr_device_{{$device->id}}">
                        <td>{{$device->id}}</td>
                        <td>{{$device->model}}</td>
                        <td>@if($device->technologie) {{$device->technologie->type ?? ''}} @endif</td>
                        <td>{{$device->customer->name ?? ''}}</td>
                        @if($device->status == 'disponivel')
                        <td class="{{$device->status == 'disponivel' ? 'text-success' : ''}}">
                            {{$device->status ?? ''}}
                        </td>
                        @endif
                        @if($device->status == 'indisponivel')
                        <td class="{{$device->status == 'indisponivel' ? 'text-danger' : ''}}">
                            {{$device->status ?? ''}}
                        </td>
                        @endif
                        @if($device->status == 'em andamento')
                        <td class="{{$device->status == 'em andamento' ? 'text-warning' : ''}}">
                            {{$device->status ?? ''}}
                        </td>
                        @endif
                        @if($device->status == null)
                        <td class="{{$device->status == null ? 'text-danger' : ''}}">
                            {{'falta status'}}
                        </td>
                        @endif
                        <td style="width: 200px;">
                            <div class="pull-left">
                                <a href="{{url('production/devices/edit')}}/{{$device->id}}">
                                    <button type="button"
                                        class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle"
                                        title="Editar isca"><span class="fa fa-fw fa-edit"></span>
                                    </button>
                                </a>
                                @if($device->status == 'disponivel')
                                <button type="button" title="Excluir produto" id="device_id" data-id="{{$device->id}}"
                                    class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle btn-delete-device">
                                    <span class="fa fa-fw fa-trash"></span>
                                </button>
                                @endif
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
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" integrity="" crossorigin="">
</script>
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
$('.btn-delete-device').click(function() {
    var id = $(this).data('id');
    var url = "{{url('production/devices/delete')}}/" + id;
    ajax_deleteDevice(id, url)
})

//Final da classe
</script>


@endsection