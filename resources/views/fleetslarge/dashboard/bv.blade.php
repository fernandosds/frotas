@extends('layouts.app')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    input[type="number"] {
        min-width: 50px;
    }

    div.dataTables_wrapper {
        margin-bottom: 3em;
    }

    .modal-personalizado {
        min-width: 80%;
        margin-left: 100;
    }

    .modal-personalizado.modal-content {
        min-height: 70vh;
    }

    div.dt-buttons {
        float: right;
        margin-left: 10px;
    }

    .hidden {
        display: none;
    }


    .time-line-box {
        height: 100px;
        padding: 100px 0;
        width: 100%;

    }

    .time-line-box .timeline {
        list-style-type: none;
        display: flex;
        padding: 0;
        text-align: center;
    }

    .time-line-box .timestamp {
        margin: auto;
        margin-bottom: 5px;
        padding: 0px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .time-line-box .status {
        padding: 0px 10px;
        display: flex;
        justify-content: center;
        border-top: 3px solid #6959CD;
        position: relative;
        transition: all 200ms ease-in;
    }

    .time-line-box .status span {
        padding-top: 8px;
    }

    .status span:before {
        content: '';
        width: 12px;
        height: 12px;
        background-color: #ecf0f5;
        border-radius: 12px;
        border: 2px solid #6959CD;
        position: absolute;
        left: 50%;
        top: 0%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        transition: all 200ms ease-in;
    }

    .timelinePointActive span:before {
        background-color: #6959CD !important;
    }

    .swiper-container {
        width: 95%;
        margin: auto;
        overflow-y: auto;
    }

    .swiper-wrapper {
        display: inline-flex;
        flex-direction: row;
        overflow-y: auto;
        justify-content: center;
    }

    .swiper-container::-webkit-scrollbar-track {
        background: #a8a8a8b6;
    }

    .swiper-container::-webkit-scrollbar {
        height: 2px;
    }

    .swiper-container::-webkit-scrollbar-thumb {
        background: #4F4F4F !important;
    }

    .swiper-slide {
        text-align: center;
        font-size: 12px;
        width: 200px;
        height: 100%;
        position: relative;
    }

    .text-white {
        color: #fff !important;
        border-radius: 10px;
        box-shadow: 0 6px 6px 2px #9898
    }

    .row {
        margin-top: 17px;
    }

    .card-total {
        margin-top: -52px;
        text-align: center;
    }

    .spanText {
        cursor: pointer;
    }

    .btn-excel {
        padding: 10px;
        cursor: pointer;
        font-size: 20px;
        border: 2px solid #fff;
    }

    .no-link {
        text-decoration: none;
        color: #fff !important;
    }

    .installed,
    .waiting,
    .vehiclesTotal {
        cursor: pointer;
    }

    .installed:hover,
    .waiting:hover,
    .vehiclesTotal:hover {
        background-color: #4556df !important;
    }

    .grid-status {
        display: flex;
        flex-wrap: wrap;

    }

    .grid-item {
        padding: 20px;
        text-align: left;
        display: flex;
        column-gap: 10px;
    }

    .checkbox {
        width: 20px;
        height: 20px;
        border: 1px solid #ebedf2;
    }

    .fa-stack-modificado {
        display: inline-block;
        height: 2em;
        position: relative;
        vertical-align: middle;
        width: 2em;
    }

    .fa-stack-modificado,
    #iconRed {
        color: red;
    }

    .fa-stack-modificado,
    #iconGreen {
        color: green;
    }

    th {
        font-size: 12px;
    }

    td {
        font-size: 12px;
    }

    .grid-style {
        border-right: 1px solid lightgray;
    }
</style>
@endsection

@section('content')

<div class="row">

    <!--begin::Portlet-->
    <div class="kt-portlet kt-portlet--mobile">
        <br />
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-line-chart"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Dashboard
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row kt-margin-b-20">
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile grid-style">
                        <label><b>Data de entrada:</b></label>
                        <div class="input-group">
                            <input type="text" name="dates" id="reportrange" class="form-control" readonly="" placeholder="Período de datas">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row"> -->
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile grid-style">
                        <label><b>Projeto:</b></label>
                        <div class="kt-checkbox-inline grid-status">
                            <div class="grid-item">
                                <input class="checkbox" type="checkbox" style="cursor: pointer;" name="pos" value="(RENEG)"> <span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill"><span id="renegociacao"></span>&nbsp; RENEG</span>
                            </div>
                            <div class="grid-item">
                                <input class="checkbox" type="checkbox" style="cursor: pointer;" name="pos" value="FINANCEIRA"> <span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill"><span id="financeira"></span>&nbsp; FINANCEIRA</span>
                            </div>
                        </div>
                        <div class="obs">
                            <label><i class="flaticon-alert"></i> OBS: Desmarcar as opções para listar todos.</label>
                        </div>
                    </div>
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile grid-style">
                        <label><b>Manutenção:</b></label>
                        <div class="kt-checkbox-inline grid-status">
                            <div class="grid-item hidden">
                                <input class="checkbox" id="batNaoViolada" style="cursor: pointer;" type="checkbox" name="bat" value="bateria_nao_violada"> <span><span id="bateria_nao_violada"></span>&nbsp; DESMARQUE PARA LISTAR BATERIAS VIOLADAS</span>
                            </div>
                            <div class="grid-item">
                                <input class="checkbox" id="batViolada" type="checkbox" style="cursor: pointer;" name="bat" value="bateria_violada"> <span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill"><span id="bateria_violada"></span>&nbsp; BATERIA DESCONECTADA</span>
                            </div>
                            <div class="grid-item">
                                <input class="checkbox" type="checkbox" style="cursor: pointer;" name="man" value="equipamento_manutencao"> <span class="kt-badge kt-badge--dark  kt-badge--inline kt-badge--pill"><span id="equipamento_manutencao"></span>&nbsp; SEM POSIÇÃO POR MAIS DE 30 DIAS</span>
                            </div>
                        </div>
                        <div class="obs">
                            <label><i class="flaticon-alert"></i> OBS: Marcar para listar bateria desconectada.</label>
                        </div>
                    </div>
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile ">
                        <label><b>Evento:</b></label>
                        <div class="kt-checkbox-inline grid-status">
                            <div class="grid-item">
                                <input class="checkbox" type="checkbox" style="cursor: pointer;" name="vei" value="veiculo_recuperado"> <span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill"><span id="veiculo_recuperado"></span>&nbsp; VEÍCULO RECUPERADO</span>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <!--begin: Datatable -->
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Placa</th><!-- 0 -->
                            <th>Placa - Mercosul</th> <!-- 1 -->
                            <th class="hidden">Chassis</th> <!-- 2 -->
                            <th style="width: 80px;">Modelo</th> <!-- 3 -->
                            <th class="hidden">Latitude</th> <!-- 4 -->
                            <th class="hidden">Longitude</th> <!-- 5 -->
                            <th class="hidden">Endereço</th> <!-- 6 -->
                            <th class="hidden">Estado</th><!-- 7 -->
                            <th class="hidden">Velocidade</th> <!-- 8 -->
                            <th>Última Transmissão</th> <!-- 9 -->
                            <th style="width: 78px;">Loja</th> <!-- 10 -->
                            <th>Nº Proposta</th> <!-- 11 -->
                            <th>Data de entrada</th> <!-- 12 -->
                            <th>Data de acionamento Técnico</th> <!-- 13 -->
                            <th>Data de início de instalação</th> <!-- 14 -->
                            <th>Data de término de instalação</th> <!-- 15 -->
                            <th>Projeto</th> <!-- 16 -->
                            <th class="hidden">Situação</th> <!-- 17 -->
                            <th></th> <!-- 18 -->
                            <th class="hidden">Filtro - Dt. Entrada</th> <!-- 19 -->
                            <th></th> <!-- 20 -->
                            <th class="hidden">Event_Violacao</th> <!-- 21 -->
                            <th class="hidden">Manutencao</th> <!-- 22 -->
                            <th class="hidden">Event_Recuperado</th> <!-- 23 -->
                            <th></th> <!-- 24 -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
</div>

@include('fleetslarge.dashboard.modalVehicle')

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{asset('/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.ptBr.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" integrity="" crossorigin=""></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        }
    });
    resetGrid()
    /**
     * Rastrea isca automaticamente
     */
    $(document).ready(function() {
        // reloadValue()
    })

    $('#timeline').removeClass('hidden');

    function resetGrid() {
        // Progress bar
        $('#div-progress-bar-fleetlarge').show();
        progressBar = 100;
        setInterval(function() {
            $('#progress_bar_fleetlarge').addClass('progress-bar kt-bg-primary');
            if (progressBar < 11) {
                $('#progress_bar_fleetlarge').removeClass('progress-bar kt-bg-primary');
                $('#progress_bar_fleetlarge').addClass("progress-bar kt-bg-danger");
            }
            if (progressBar == 0) {
                $('#progress_bar_fleetlarge').removeClass('progress-bar kt-bg-danger');
                $('#progress_bar_fleetlarge').addClass('progress-bar kt-bg-primary');
                // reloadValue()
                progressBar = 100;
            } else {
                progressBar = progressBar - 1;
            }
            $('#progress_bar_fleetlarge').attr("style", "width:" + progressBar + "%")
            $('#progress_bar_fleetlarge').attr("title", "Tempo" + progressBar + "%")
        }, 1000);
    }

    // 2022-08-16 09:54:49.000

    $(document).ready(function() {
        columns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
        columsPdf = [1, 2, 3, 6, 7, 9, 12, 13, 14, 15];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        var dateTime = moment(new Date()); //.format('DD/MM/YYYY HH:mm:ss');
        var oTable = $('#example').DataTable({
            processing: true,
            //serverSide: true,
            ajax: {
                header: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',

                url: "{{url('')}}/fleetslarges/data/bv",
                data: ({
                    _token: $('meta[name="csrf-token"]').attr('content')
                }),
                dataSrc: "",
            },
            order: [
                [12, 'desc']
            ],
            columnDefs: [{
                    className: "hidden",
                    "targets": [19, 21, 22, 23]
                }, {
                    orderable: false,
                    targets: [18, 20, 23, 24],
                }, {
                    targets: [9, 12, 13, 14, 15],
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    }
                },
                {
                    targets: [19],
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
            ],
            columns: [{
                    "data": "placa", //0
                }, {
                    "data": "placa_mercosul", //1
                }, {
                    "data": "chassis", //2
                    visible: false
                }, {
                    "data": "modelo_veiculo", //3
                    "width": "40px",
                }, {
                    "data": "lp_latitude", //4
                    visible: false
                }, {
                    "data": "lp_longitude", //5
                    visible: false
                }, {
                    "data": '', //6
                    render: function(data, type, row) {
                        return row.end_logradouro + ', ' + row.end_bairro + ' - ' + row.end_cidade + ' ' + row.end_uf;
                    },
                    visible: false
                }, {
                    "data": "estado", //7
                    visible: false
                }, {
                    "data": "lp_velocidade", //8
                    visible: false
                }, {
                    "data": "lp_ultima_transmissao", //9
                }, {
                    "data": "cliente", //10 loja
                }, {
                    "data": "contrato", //11
                }, {
                    "data": "dt_entrada", //12
                }, {
                    "data": "dt_tecnico_acionado", //13
                }, {
                    "data": "dt_inicio_instalacao", //14
                }, {
                    "data": "dt_termino_instalacao", // 15
                }, {
                    "data": "projeto", //16
                    "width": "50px",
                    render: function(data, type, row, meta) {
                        if (row.projeto == 'RENEGOCIACAO') {
                            return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">RENEG</span>'
                        }
                        return '<span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill texto">FINANCEIRA</span>'
                    }
                }, {
                    "data": "situacao", //17
                    visible: false
                }, {
                    "data": " ", //18
                    "width": "70px",
                    render: function(data, type, row, meta) {
                        return '<button type="button" class="btn btn-outline-hover-info  btn-sm btn-icon btn-circle btn-vehicle-data" data-toggle="modal" data-target="#modalVehicle" data-chassi="' + row.chassis + '"><i class="fa fa-search-plus"></i></button>' +
                            ' <a href="{{route("fleetslarges.monitoring.index")}}/' + row.chassis + '" class="btn btn-outline-hover-warning  btn-sm btn-icon btn-circle"><span class="fa fa-map-marked-alt"></span></a>'
                    }
                }, {
                    "data": "dt_entrada", //19
                }, {
                    "data": "event_violacao", //20
                    render: function(data, type, row, meta) {
                        if (row.event_violacao == 'bateria_violada') {
                            return '<div class="fa-stack-modificado" id="iconRed"><label title="Bateria desconectada"><i class="fas fa-2x fa-car-battery"></i></label></div>'
                        }
                        return '<span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill hidden">bateria_nao_violada</span>'
                    }
                },
                // campo oculto
                {
                    "data": "event_violacao", //21
                    render: function(data, type, row, meta) {
                        if (row.event_violacao == 'bateria_violada') {
                            return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">bateria_violada</span>'
                        }
                        return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">bateria_nao_violada</span>'
                    }
                },
                {
                    "data": "manutencao", //22
                    render: function(data, type, row, meta) {
                        if (row.manutencao == 'equipamento_manutencao') {
                            return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">equipamento_manutencao</span>'
                        }

                        return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">equipamento_nao_manutencao</span>'
                    }
                },
                {
                    "data": "sinistrado", //23
                    render: function(data, type, row, meta) {
                        if (row.sinistrado == 'veiculo_recuperado') {
                            return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">veiculo_recuperado</span>'
                        }
                        return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">veiculo_nao_recuperado</span>'
                    }
                },
                {
                    "data": "sinistrado", //24
                    render: function(data, type, row, meta) {
                        if (row.sinistrado == 'veiculo_recuperado') {
                            return '<div class="fa-stack-modificado" id="iconGreen"><label title="Veículo Recuperado""><i class="fas fa-2x fa-car"></i></label></div>'
                        }
                        return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto hidden">veiculo_nao_recuperado</span>'
                    }
                },
            ],
            //"order": [1, 'asc'],
            dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Grid de Veiculos_' + date,
                    exportOptions: {
                        columns: columsPdf
                    },
                    orientation: 'landscape',
                },
                {
                    extend: 'excel',
                    title: 'SAT Company :: Grid de Veiculos_' + date,
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
                        var coldate = aData[19].split("/");
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
        const total_violada = 0;
        const total_financeira = 0;
        oTable.on('draw', function() {

            totalRowCount['financeira'] = oTable.rows(':contains("FINANCEIRA")', {
                search: 'applied'
            }).count();

            totalRowCount['renegociacao'] = oTable.rows(':contains("(RENEG)")', {
                search: 'applied'
            }).count();

            totalRowCount['bateria_violada'] = oTable.rows(':contains("bateria_violada")', {
                search: 'applied'
            }).count();

            totalRowCount['bateria_nao_violada'] = oTable.rows(':contains("bateria_nao_violada")', {
                search: 'applied'
            }).count();

            totalRowCount['equipamento_manutencao'] = oTable.rows(':contains("equipamento_manutencao")', {
                search: 'applied'
            }).count();

            totalRowCount['veiculo_recuperado'] = oTable.rows(':contains("veiculo_recuperado")', {
                search: 'applied'
            }).count();

            $('#financeira').html(totalRowCount['financeira']);
            $('#renegociacao').html(totalRowCount['renegociacao']);
            $('#bateria_violada').html(totalRowCount['bateria_violada']);
            $('#bateria_nao_violada').html(totalRowCount['bateria_nao_violada']);
            $('#equipamento_manutencao').html(totalRowCount['equipamento_manutencao']);
            $('#veiculo_recuperado').html(totalRowCount['veiculo_recuperado']);

        });

        function tableOneRowCount() {

            totalRowCount['gridAguardandoInstalacao'] = oTable.rows(':contains("Aguardando_Instalacao")', {
                search: 'applied'
            }).count();

            totalRowCount['gridInstalacaoEfetuada'] = oTable.rows(':contains("Instalacao_Efetuada")', {
                search: 'applied'
            }).count();

            setTimeout(function() {
                $('#gridAguardandoInstalacao').html(totalRowCount['gridAguardandoInstalacao']);
                $('#gridInstalacaoEfetuada').html(totalRowCount['gridInstalacaoEfetuada']);
            }, 16000);

            return totalRowCount;
        }

        setTimeout(function() {
            tableOneRowCount();
        }, 15000);

        // Adicionar checked após 10 segundos
        setTimeout(function() {
            $('#batNaoViolada')[0].click();
        }, 20000);

        $('input[name="bat"]').change(function() {
            if ($('#batViolada').is(':checked')) {
                $('#batNaoViolada').attr('checked', false);
                $('#batViolada').attr('checked', true);
            } else {
                $('#batViolada').attr('checked', false);
                $('#batNaoViolada')[0].click();
            }
        });

        // FUNÇÃO PARA ALTERAR CHECKBOX STATUS OS
        $('input:checkbox').on('change', function() {
            var status = $('input:checkbox[name="pos"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');
            $('#example').DataTable().column(16).search(status, true, false, false).draw();
        });

        $('input:checkbox').on('change', function() {
            var status = $('input:checkbox[name="bat"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');
            $('#example').DataTable().column(21).search(status, true, false, false).draw();
        });


        $('input:checkbox').on('change', function() {
            var status = $('input:checkbox[name="man"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');
            $('#example').DataTable().column(22).search(status, true, false, false).draw();
        });

        $('input:checkbox').on('change', function() {
            var status = $('input:checkbox[name="vei"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');
            $('#example').DataTable().column(23).search(status, true, false, false).draw();
        });



        /* Details vehicle */
        $(document).on("click", ".btn-vehicle-data", function() {
            var chassi = $(this).data('chassi');
            $.ajax({
                url: "{{url('')}}/fleetslarges/find/bv" + chassi,
                type: 'GET',
                success: function(response) {
                    $('#modelo_veiculo_aprimorado').val(response.modelo_veiculo_aprimorado)
                    $('.placa').val(response.data.placa)
                    $('.empresa').val(response.data.empresa)
                    $('#r12s_proximos').val(response.data.r12s_proximos)
                    $('#dif_date').val(response.data.dif_date)
                    $('.lp_longitude').val(response.data.lp_longitude)
                    $('.estado').val(response.data.estado)
                    $('.lp_latitude').val(response.data.lp_latitude)
                    $('.telefone').val(response.data.telefone)
                    $('.status').val(response.data.status)
                    $('.iccid').val(response.data.iccid)
                    $('.chassis').val(response.data.chassis)
                    $('.modelo_veiculo').val(response.data.modelo_veiculo)
                    $('.qtd_dispositivos').val(response.data.qtd_dispositivos)
                    $('.categoria_veiculo').val(response.data.categoria_veiculo)
                    $('.cidade').val(response.data.cidade)
                    $('.operadora').val(response.data.operadora)
                    $('.cliente').val(response.data.cliente)
                    $('.data_instalacao').val(response.data.data_instalacao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'))
                    $('.cod_empresa').val(response.data.cod_empresa)
                    $('.codigo_fipe').val(response.data.codigo_fipe)
                    $('.modelo').val(response.data.modelo)
                    $('.point').val(response.data.point)
                    $('.lp_ultima_transmissao').val(response.data.lp_ultima_transmissao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'))
                    $('.versao').val(response.data.versao)
                    $('.lp_satelite').val(response.data.lp_satelite)
                    $('.lp_ignicao').val(response.data.lp_ignicao)
                    $('.r12s_proximos').val(response.data.r12s_proximos)
                    $('#dif_date').val(response.data.dif_date)
                    $('.lp_voltagem').val(response.data.lp_voltagem)
                    $('#veiculo_em_loja').val(response.data.veiculo_em_loja != "" ? "NÃO" : "SIM")
                    $('#r12s_proximos').val(response.data.r12s_proximos)
                    $('#dif_date').val(response.data.dif_date)
                    $('.lp_velocidade').val(response.data.lp_velocidade + " km/h")
                    $('#point').val(response.data.point)
                    $('.filial').val(response.data.filial)
                    $('#status_veiculo_dt').val(response.data.status_veiculo_dt.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                    $('#status_veiculo').val(response.data.status_veiculo)
                    $('#sinistrado').val(response.data.sinistrado != "FALSE" ? "SIM" : "NÃO")
                    $('.end_cep').val(response.data.end_cep)
                    $('.end_logradouro').val(response.data.end_logradouro)
                    $('.end_bairro').val(response.data.end_bairro)
                    $('.end_uf').val(response.data.end_uf)
                    $('.cliente_foto').attr('src', response.data.cliente_foto);
                    $('#cliente_cpf').val(response.data.cliente_cpf)
                    $('#cliente_nome').val(response.data.cliente_nome)
                    $('#cliente_datadev').val(response.data.cliente_datadev.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                    $('#cliente_celular').val(response.data.cliente_celular)
                    $('#cliente_localdev').val(response.data.cliente_localdev)
                    $('#cliente_local_retirada').val(response.data.cliente_local_retirada)
                    $('#cliente_contrato').val(response.data.cliente_contrato)
                    $('#cliente_dataretirada').val(response.data.cliente_dataretirada.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                    $('#cliente_email').val(response.data.cliente_email)
                    $('#cliente_endereco').val(response.data.cliente_endereco)
                    $('.cidade').val(response.data.end_cidade)
                    $('#cliente_cnh').val(response.data.cliente_cnh)
                    $('.veiculo_odometro').val(response.data.veiculo_odometro)
                    $('#cliente_foto_cnh').attr('href', response.data.cliente_foto_cnh);
                    $('.cliente_foto').attr('href', response.data.cliente_foto)

                    if (response.data.status_veiculo != "LOCACAO") {
                        $("#btn_cliente").css({
                            "display": "none"
                        });
                    } else {
                        $("#btn_cliente").css({
                            "display": "inline"
                        });
                    }

                    updateTimeline(response.data.dt_entrada, response.data.dt_inicio_instalacao, response.data.dt_tecnico_acionado, response.data.dt_termino_instalacao)
                },
                error: function(error) {
                    if (error.responseJSON.status == "internal_error") {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                            showConfirmButton: true,
                            timer: 10000
                        })

                    } else if (error.responseJSON.status == "validation_error") {
                        var items = error.responseJSON.errors;
                        Swal.fire({
                            type: 'error',
                            title: 'Erro!',
                            html: 'Os seguintes erros foram encontrados: ' + items,
                            footer: ' '
                        })

                    } else {
                        var items = error.responseJSON.errors;
                        var errors = $.map(items, function(i) {
                            return i.join('<br />');
                        });
                        Swal.fire({
                            type: 'error',
                            title: 'Erro!',
                            html: 'Os seguintes erros foram encontrados: ' + errors,
                            footer: ' '
                        })
                    }
                }
            });
        })
    });


    /**
     * Update Timeline cliente Santander
     */
    function updateTimeline(dt_entrada, dt_inicio_instalacao, dt_tecnico_acionado, dt_termino_instalacao) {
        if (dt_entrada != '') {
            $('#dt_entrada').html(dt_entrada.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3.$2.$1 $4:$5:$6'))
            $('#status_dt_entrada').addClass('timelinePointActive');
        } else {
            $('#dt_entrada').html('Aguarde...')
        }

        if (dt_tecnico_acionado != '') {
            $('#dt_tecnico_acionado').html(dt_tecnico_acionado.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3.$2.$1 $4:$5:$6'))
            $('#status_dt_tecnico_acionado').addClass('timelinePointActive');
        } else {
            $('#dt_tecnico_acionado').html('Aguarde...')
        }

        if (dt_inicio_instalacao != '') {
            $('#dt_inicio_instalacao').html(dt_inicio_instalacao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3.$2.$1 $4:$5:$6'))
            $('#status_dt_inicio_instalacao').addClass('timelinePointActive');
        } else {
            $('#dt_inicio_instalacao').html('Aguarde...')
        }

        if (dt_termino_instalacao != '') {
            $('#dt_termino_instalacao').html(dt_termino_instalacao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3.$2.$1 $4:$5:$6'))
            $('#status_dt_termino_instalacao').addClass('timelinePointActive');
        } else {
            $('#dt_termino_instalacao').html('Aguarde...')
        }

    }

    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "textName",
    });

    $(document).on('click', '.spanText', function() {
        if ($(this).attr('value') == 'instalado') {
            $('.textName').val('instalado').focus().click()
        }
    });


    //Log Relatório de Telemetria
    $('.no-link').click(function() {
        var chassi = $(this).data('chassi');
        $.ajax({
            url: "{{route('fleetslarges.telemetria')}}",
            type: 'GET',
        });
    })

    $(document).ready(function() {
        $('.hidden').css('display', 'none');
    });
</script>
@endsection
