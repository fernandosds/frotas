@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" />
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


    div #datatable {
        width: 80% !important;
    }
</style>
@endsection

@section('content')


<!--
<div class="kt-section " id="div-progress-bar-fleetlarge">
    <br />
    <div class="progress progress-sm">
        <div class="" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar_fleetlarge"></div>
    </div>
</div>

<div class="row" id="div-grid-vehicle">
    <div class="col-md-6" id="divCard01">
        <div class="card text-white col-md-12 bg-primary" id="divColor01">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"> <span id="grid04"></span></h1>
                <p class="card-text h5"><span id="statusCard01">TEMPO MÉDIO DE INSTALAÇÃO</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="divCard02">
        <div class="card text-white col-md-12 bg-primary" id="divColor02">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="grid01"></span></h1>
                <p class="card-text h5"><span id="statusCard02">TEMPO MÉDIO PARA ACIONAR TECNICO</p>
            </div>
        </div>
    </div>
</div>

<div class="row" id="div-grid-vehicle2">
    <div class="col-md-6" id="divCard04">
        <div class="card text-white col-md-12 bg-primary" id="divColor04">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="grid02"></span></h1>
                <p class="card-text h5"><span id="statusCard04">TEMPO MÉDIO DE DESLOCAMENTO</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id='divCard05'>
        <div class="card text-white col-md-12 bg-primary" id='divColor05'>
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="grid03"></span></h1>
                <p class="card-text h5"><span id="statusCard05">TEMPO MÉDIO DE ATENDIMENTO</p>
            </div>
        </div>
    </div>
</div>
-->
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary col-md-12 installed">
            <div class="card-body card-total">
                <br />
                <h1 class="card-title display-12">&nbsp;</span> </h1>
                <h3 class="card-title display-12"><span class="spanText" id="gridInstalacaoEfetuada" value="instalado"></span> INSTALAÇÕES EFETUADAS </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary col-md-12 waiting">
            <div class="card-body card-total">
                <br />
                <h1 class="card-title display-12">&nbsp;</span> </h1>
                <h3 class="card-title display-12"><span class="spanText" id="gridAguardandoInstalacao"></span>&nbsp; AGUARDANDO INSTALAÇÃO </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary col-md-12 vehiclesTotal">
            <div class="card-body card-total">
                <br />
                <h1 class="card-title display-12">&nbsp;</span> </h1>
                <h3 class="card-title display-12"><span class="spanText" id="gridTotal"></span> &nbsp; TOTAL DE REGISTROS </h3>
            </div>
        </div>
    </div>
</div>

<!--
<div class="row">
    <div class="col-md-12">
        <div class="btn-success text-white center btn-excel col-md-12">
            <a href="https://bi.satcompany.com.br/public/question/d1aa64fe-7aad-4ee4-ab24-6b67468e9d92.xlsx" class="no-link">Gerar Relatório Telemetria <i class="far fa-file-excel"></i></a>
        </div>
    </div>
</div>
--->

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
                        Relatório Gerencial
                    </h3>
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="row kt-margin-b-20">
                    <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                        <label>Data de entrada:</label>
                        <div class="input-group">
                            <input type="text" name="dates" id="reportrange" class="form-control" readonly="" placeholder="Período de datas">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                        <label>Projeto:</label>
                        <div class="kt-checkbox-inline grid-status">
                            <div class="grid-item">
                                <input class="checkbox" type="checkbox" name="pos" value="(RENEG)"> <span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill"><span id="renegociacao"></span>&nbsp; RENEG</span>
                            </div>
                            <div class="grid-item">
                                <input class="checkbox" type="checkbox" name="pos" value="FINANCEIRA"> <span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill"><span id="financeira"></span>&nbsp; FINANCEIRA</span>
                            </div>
                        </div>
                        <div class="obs">
                            <label><i class="flaticon-alert"></i> OBS: Desmarcar as opções para listar todos.</label>
                        </div>
                    </div>
                </div>
                <!--begin: Datatable -->

                <table id="example" class="display">
                    <div id="datatable">
                        <thead>
                            <tr class="headerTable">
                                <th>Placa</th>
                                <th>Placa - Mercosul</th>
                                <th class="hidden">Chassis</th>
                                <th>Modelo</th>
                                <th class="hidden">Data - Instalacao</th>
                                <th class="hidden">Latitude</th>
                                <th class="hidden">Longitude</th>
                                <th class="hidden">Endereço</th>
                                <th class="hidden">Estado</th>
                                <th class="hidden">Velocidade</th>
                                <th class="hidden">Última Transmissão</th>
                                <th>Última Transmissão</th>
                                <th style="width: 78px;">Loja</th>
                                <th>Nº Proposta</th>
                                <th class="hidden">Data de entrada</th>
                                <th>Data de entrada</th>
                                <th class="hidden">Data de acionamento Técnico</th>
                                <th>Data de acionamento Técnico</th>
                                <th class="hidden">Data de início de instalação</th>
                                <th>Data de início de instalação</th>
                                <th class="hidden">Data de término de instalação</th>
                                <th>Data de término de instalação</th>
                                <th>Projeto</th>
                                <th class="hidden">Situação</th>
                                <th class="hidden">Status_Geral</th>
                                <th style="width: 200px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyVehicle">
                            @foreach ($carros as $driver)
                            <tr id='_tr_car_{{$driver->chassis}}'>
                                <td>{{$driver->placa}}</td>
                                <td>{{$driver->placa_mercosul}}</td>
                                <td class="hidden">{{$driver->chassis}}</td>
                                <td>{{$driver->modelo_veiculo}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver->data_inst)->format('d/m/Y')}}</td>
                                <td class="hidden">{{$driver->lp_latitude}}</td>
                                <td class="hidden">{{$driver->lp_longitude}}</td>
                                <td class="hidden">{{$driver->end_logradouro}}, {{$driver->end_bairro}} - {{$driver->end_cidade}} {{$driver->end_uf}}</td>
                                <td class="hidden">{{$driver->estado}}</td>
                                <td class="hidden">{{$driver->lp_velocidade}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver->lp_ultima_transmissao)->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver->lp_ultima_transmissao}}</span>{{\Carbon\Carbon::parse($driver->lp_ultima_transmissao)->format('d/m/Y H:i:s')}}</td>
                                <td>{{$driver->cliente}}</td>
                                <td>{{$driver->contrato}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver->dt_entrada)->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver->dt_entrada}}</span>{{\Carbon\Carbon::parse($driver->dt_entrada)->format('d/m/Y H:i:s')}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver->dt_tecnico_acionado)->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver->dt_tecnico_acionado}}</span>{{\Carbon\Carbon::parse($driver->dt_tecnico_acionado)->format('d/m/Y H:i:s')}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver->dt_inicio_instalacao)->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver->dt_inicio_instalacao}}</span>{{\Carbon\Carbon::parse($driver->dt_inicio_instalacao)->format('d/m/Y H:i:s')}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver->dt_termino_instalacao)->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver->dt_termino_instalacao}}</span>{{\Carbon\Carbon::parse($driver->dt_termino_instalacao)->format('d/m/Y H:i:s')}}</td>
                                @if ($driver->projeto == 'RENEGOCIACAO')
                                <td><span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">RENEG</span></td>
                                @elseif ($driver->projeto == 'FINANCEIRA')
                                <td><span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill texto">{{$driver->projeto}}</span></td>
                                @endif
                                <td class="hidden">{{$driver->situacao}}</td>
                                <td class="hidden">{{$driver->status_situacao}}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-hover-info  btn-sm btn-icon btn-circle btn-vehicle-data" data-toggle="modal" data-target="#modalVehiclePSA" data-chassi="{{$driver->chassis}}">
                                        <i class="fa fa-search-plus"></i>
                                    </button>
                                    <a href="{{route('fleetslarges.monitoring.index')}}/{{$driver->chassis}}" class="btn btn-outline-hover-warning  btn-sm btn-icon btn-circle"><span class="fa fa-map-marked-alt"></span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </div>
                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
</div>

@include('fleetslarge.dashboard.modalVehiclePSA')

@endsection

@section('scripts')
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" integrity="" crossorigin=""></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
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
        }, 1000);
    }



    $(document).ready(function() {
        columns = [0, 1, 2, 3, 5, 6, 7, 8, 9, 10, 12, 13, 14, 16, 18, 20, 22, 23];
        columsPdf = [0, 1, 2, 3, 7, 8, 10, 14, 16, 18, 20];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        var oTable = $('#example').DataTable({
            //"bDestroy": true,
            "order": [19, 'desc'],
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




    $('.installed').click(function() {
        $('#example').DataTable().columns(24).search("Instalacao_Efetuada", true, false, true).draw();
    });

    $('.waiting').click(function() {
        $('#example').DataTable().columns(24).search('Aguardando_Instalacao', true, false, true).draw();
    });

    $('.vehiclesTotal').click(function() {
        $('#example').DataTable().columns(24).search('').draw();
    });



    /* Details vehicle */
    $('.btn-vehicle-data').click(function() {
        var chassi = $(this).data('chassi');
        $.ajax({
            url: "{{url('')}}/fleetslarges/psa/find/" + chassi,
            type: 'GET',
            success: function(response) {
                console.log(response.data)
                $('.categoria_veiculo').val(response.data.categoria_veiculo)
                $('.chassis').val(response.data.chassis)
                $('.cidade').val(response.data.cidade)
                $('.cliente').val(response.data.cliente)
                $('.cod_empresa').val(response.data.cod_empresa)
                $('.codigo_fipe').val(response.data.codigo_fipe)
                if (response.data.data_instalacao) {
                    $('.data_instalacao').val(response.data.data_instalacao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'))
                }
                $('#dif_date').val(response.data.dif_date)
                $('.empresa').val(response.data.empresa)
                $('.end_bairro').val(response.data.end_bairro)
                $('.end_cep').val(response.data.end_cep)
                $('.end_cidade').val(response.data.end_cidade)
                $('.end_logradouro').val(response.data.end_logradouro)
                $('.end_uf').val(response.data.end_uf)
                $('.estado').val(response.data.estado)
                $('.filial').val(response.data.filial)
                $('.iccid').val(response.data.iccid)
                $('.lp_ignicao').val(response.data.lp_ignicao)
                $('.lp_latitude').val(response.data.lp_latitude)
                $('.lp_longitude').val(response.data.lp_longitude)
                $('.lp_satelite').val(response.data.lp_satelite)
                if (response.data.lp_ultima_transmissao) {
                    $('.lp_ultima_transmissao').val(response.data.lp_ultima_transmissao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'))
                }
                $('.lp_velocidade').val(response.data.lp_velocidade + " km/h")
                $('.lp_voltagem').val(response.data.lp_voltagem)
                $('.modelo').val(response.data.modelo)
                $('.modelo_veiculo').val(response.data.modelo_veiculo)
                $('#modelo_veiculo_aprimorado').val(response.data.modelo_veiculo_aprimorado)
                $('.operadora').val(response.data.operadora)
                $('.placa').val(response.data.placa)
                $('.point').val(response.data.point)
                $('.qtd_dispositivos').val(response.data.qtd_dispositivos)
                $('.r12s_proximos').val(response.data.r12s_proximos)
                $('#sinistrado').val(response.data.sinistrado != "FALSE" ? "SIM" : "NÃO")
                $('.status').val(response.data.status)
                $('#status_veiculo').val(response.data.status_veiculo)
                if (response.data.status_veiculo_dt) {
                    $('#status_veiculo_dt').val(response.data.status_veiculo_dt.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))

                }
                $('.telefone').val(response.data.telefone)
                $('.versao').val(response.data.versao)
                $('.contrato').val(response.data.contrato)

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
</script>
@endsection
