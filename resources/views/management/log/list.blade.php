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

            <table id="example" class="display">
                <thead>
                    <tr>
                        <!--<th scope="col">ID</th>-->
                        <th scope="col">Usuário</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Data</th>
                        <th class="hidden">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr id="_tr_user_{{$log->id}}">
                        <!--<th scope="row">{{$loop->iteration}}</th>-->
                        <td>{{$log->user_name}}</td>
                        <td>{{$log->description}}</td>
                        <td><span style="display:none">{{$log->created_at}}</span>{{\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s')}}</td>
                        <td class="hidden">{{\Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s')}}</td>
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
        columns = [0, 1, 3];
        columsPdf = [0, 1, 3];
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
                        var coldate = aData[4].split("/");
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

        let totalRowCount = new Array();

        oTable.on('draw', function() {
            totalRowCount['financeira'] = oTable.rows(':contains("FINANCEIRA")', {
                search: 'applied'
            }).count();

            totalRowCount['renegociacao'] = oTable.rows(':contains("(RENEG)")', {
                search: 'applied'
            }).count();

            totalRowCount['gridAguardandoInstalacao'] = oTable.rows(':contains("Aguardando_Instalacao")', {
                search: 'applied'
            }).count();

            totalRowCount['gridInstalacaoEfetuada'] = oTable.rows(':contains("Instalacao_Efetuada")', {
                search: 'applied'
            }).count();


            $('#financeira').html(totalRowCount['financeira']);
            $('#renegociacao').html(totalRowCount['renegociacao']);


            $('#gridAguardandoInstalacao').html(totalRowCount['gridAguardandoInstalacao']);
            $('#gridInstalacaoEfetuada').html(totalRowCount['gridInstalacaoEfetuada']);



        });

        var info = oTable.page.info();
        var count = info.recordsTotal;
        $('#gridTotal').html(count);


        function tableOneRowCount() {
            totalRowCount['financeira'] = oTable.rows(':contains("FINANCEIRA")').data().length;
            totalRowCount['renegociacao'] = oTable.rows(':contains("(RENEG)")').data().length;
            totalRowCount['gridAguardandoInstalacao'] = oTable.rows(':contains("Aguardando_Instalacao")').data().length;
            totalRowCount['gridInstalacaoEfetuada'] = oTable.rows(':contains("Instalacao_Efetuada")').data().length;

            $('#financeira').html(totalRowCount['financeira']);
            $('#renegociacao').html(totalRowCount['renegociacao']);
            $('#gridAguardandoInstalacao').html(totalRowCount['gridAguardandoInstalacao']);
            $('#gridInstalacaoEfetuada').html(totalRowCount['gridInstalacaoEfetuada']);

            return totalRowCount;
        }

        tableOneRowCount();

        // FUNÇÃO PARA ALTERAR CHECKBOX STATUS OS (RENEG OU FINANCEIRA)
        $('input:checkbox').on('change', function() {
            var status = $('input:checkbox[name="pos"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');
            $('#example').DataTable().column(22).search(status, true, false, false).draw();
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
