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
                        <a href="{{url('production/devices/new')}}/" class="btn btn-brand btn-elevate btn-icon-sm">
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
                        <th scope="col">Modelo</th>
                        <th scope="col">Tecnologia</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                    <tr id="_tr_user_{{$device->id}}">
                        <td>{{$device->model}}</td>
                        <td>@if($device->technologie) {{$device->technologie->type ?? ''}} @endif</td>
                        <td>{{$device->customer->name ?? ''}}</td>
                        <td>{{$device->status ?? ''}}</td>
                        <td>
                            <div class="pull-right">
                                <a href="{{url('production/devices/edit')}}/{{$device->id}}">
                                    <button type="button"
                                        class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle"
                                        title="Editar isca"><span class="fa fa-fw fa-edit"></span>
                                    </button>
                                </a>
                                <a href="{{url('production/devices/delete')}}/{{$device->id}}">
                                    <button type="button"
                                        class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle btn-delete-cerca"
                                        title="Excluir isca" id="btn-delete-device">
                                        <span class="fa fa-fw fa-trash"></span>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {!! $devices->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(function() {
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
        var url = "{{url('fleetslarges/alerta/delete')}}/" + id;
        ajax_delete(id, url)
    })

});
</script>
@endsection
