@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">

        <!-- HEADER -->
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-menu__link-icon"><i class="fa fa-solid fa-wrench"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    <span class="kt-menu__link-text">&nbsp; Lista de iscas</span>
                </h3>
            </div>

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <a href="#">
                        <button type="button" class="btn btn-primary btn-pill"
                            title="Importar planilha"><i class="fa fa-file-excel"></i>
                            <span> Cadastrar Isca</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>

            <br />
            <div class="kt-portlet kt-portlet--mobile" id="kt_content">

                <div class="col-md-12">
                    <br />
                    <table id="stock" class="display" style="width:50%">
                        <thead>
                            <tr class="headerTable">
                                <th scope="col">Produto</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Data de embarque</th>
                                <th scope="col">Data de encerramento</th>
                                <th scope="col" style="width: 170px;">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyVehicle">
                            @foreach ($devices as $device)
                            <tr id="_tr_user_{{$device->id}}">
                                <td>{{'Iscas'}}</td>
                                <td>{{$device->customer->name}}</td>
                                <td>{{$device->model}}</td>
                                <td>{{$device->technologie->type ?? ''}}</td>
                                <td>{{$device->status ?? ''}}</td>
                                <td>{{$device->boardings[0]->created_at ?? ''}}</td>
                                <td>{{$device->boardings[0]->finished_at ?? ''}}</td>
                                <td style="width: 200px;">
                                    @if($device->status == 'disponivel' || $device->status == '')
                                        <div class="">
                                            <a href="#" class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle" title="Editar isca"><span class="fa fa-fw fa-edit"></span></a>
                                                <button type="button" title="Excluir isca" class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle">
                                                    <span class="fa fa-fw fa-trash"></span>
                                                </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @foreach ($trackers as $tracker)
                            <tr id="_tr_user_{{$tracker->id}}">
                                <td>{{'Disp. Móvel'}}</td>
                                <td>{{$tracker->model ?? ''}}</td>
                                <td> --- </td>
                                <td>{{$tracker->status ?? ''}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        columns = [0, 1, 2, 3, 4, 5];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        $('#stock').DataTable({
            "search": {
                "search": ''
            },
            dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Grid de Estoque_' + date,
                    exportOptions: {
                        columns: columns
                    },
                    orientation: 'portrait',
                },
                {
                    extend: 'excel',
                    title: 'SAT Company :: Grid de Estoque_' + date,
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
</script>
@endsection
