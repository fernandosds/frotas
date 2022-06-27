@extends('layouts.app')

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

                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">
            <div class="row kt-margin-b-20">
                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label>Data do evento:</label>
                    <div class="input-group">
                        <input type="text" name="dates" id="reportrange" class="form-control" readonly="" placeholder="Período de datas">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                    <label for="input">Selecione um usuário</label>
                    <select class="form-control" name="user_name" id="user_name">
                        <option value="">Todos os usuários</option>
                        @foreach( $users as $user )
                        <option value="{{$user->name}}">{{$user->name}}</option>
                        @endforeach
                    </select><br /><br />
                </div>
            </div>

            </br>

            <table id="example" class="display">
                <thead>
                    <tr>
                        <th scope="col">Usuário</th>
                        <th scope="col">Descrição</th>
                        <!-- <th scope="col">IP</th> -->
                        <th scope="col">Data</th>
                        <th class="hidden">Data</th>
                        <th class="hidden">Data Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr id="_tr_user_{{$log->id}}">
                        <td>{{$log->user_name}}</td>
                        <td>{{$log->description}}</td>
                        <!--  <td>{{$log->host_ip}}</td> -->
                        <td><span style="display:none">{{$log->created_at}}</span>{{\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s')}}</td>
                        <td class="hidden">{{\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s')}}</td>
                        <td class="hidden">{{\Carbon\Carbon::parse($log->created_at)->format('d/m/Y')}}</td>
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
            "order": [02, 'desc'],
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

        // INICIO DATARANGEPICKER
        var startdate;
        var enddate;
        $('input[name="dates"]').daterangepicker({
                "singleDatePicker": false,
                ranges: {
                    "Todos": [moment().subtract(5, 'years'), moment()],
                    "Hoje": [moment(), moment()],
                    'Dia anterior': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mês': [moment().startOf('month'), moment().endOf('month')],
                    'Mês passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "opens": "right",
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "De",
                    "toLabel": "Até",
                    "customRangeLabel": "Definir período",
                    "daysOfWeek": [
                        "Dom",
                        "Seg",
                        "Ter",
                        "Qua",
                        "Qui",
                        "Sex",
                        "Sáb"
                    ],
                    "monthNames": [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro"
                    ],
                    "firstDay": 0
                }
            },
            function(start, end, label) {
                var s = moment(start.toISOString());
                var e = moment(end.toISOString());
                startdate = s.format("YYYY-MM-DD");
                enddate = e.format("YYYY-MM-DD");
            }
        );

        // FILTRO POR DATA DE ENTRADA
        //Filter the datatable on the datepicker apply event with reportage 1
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            startdate = picker.startDate.format('YYYY-MM-DD');
            enddate = picker.endDate.format('YYYY-MM-DD');
            $.fn.dataTableExt.afnFiltering.push(
                function(oSettings, aData, iDataIndex) {
                    if (startdate != undefined) {
                        var coldate = aData[4].split("/"); // Precisa alterar este número para a coluna correspondente
                        var d = new Date(coldate[2], coldate[1] - 1, coldate[0]);
                        var date = moment(d.toISOString());
                        date = date.format("YYYY-MM-DD");
                        dateMin = startdate.replace(/-/g, "");
                        dateMax = enddate.replace(/-/g, "");
                        date = date.replace(/-/g, "");
                        if (dateMin == "" && date <= dateMax) {
                            return true;
                        } else if (dateMin == "" && date <= dateMax) {
                            return true;
                        } else if (dateMin <= date && "" == dateMax) {
                            return true;
                        } else if (dateMin <= date && date <= dateMax) {
                            return true;
                        }
                        return false;
                    }
                }
            );
            oTable.draw();
        });

        //FUNÇÃO PARA FILTRAR AS ATIVIDADES DOS USUÁRIOS
        $('#user_name').on('change', function() {
            oTable.columns(0).search(this.value).draw();
        });

    });


    /* Deletar */
    $('.btn-delete-log').click(function() {
        var id = $(this).data('id');
        var url = "{{url('logs/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection
