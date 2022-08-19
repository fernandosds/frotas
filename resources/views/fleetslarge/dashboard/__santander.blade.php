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

    th {
        font-size: 12px;
    }

    td {
        font-size: 12px;
    }
</style>
@endsection

@section('content')

<div class="kt-section " id="div-progress-bar-fleetlarge">
    <br />
    <div class="progress progress-sm">
        <div class="" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar_fleetlarge"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary col-md-12 installed">
            <div class="card-body card-total">
                <br />
                <h1 class="card-title display-12">&nbsp;</span> </h1>
                <h3 class="card-title display-12"><span class="spanText" id="gridInstalacaoEfetuada" value="gridInstalacaoEfetuada"></span> INSTALAÇÕES EFETUADAS </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary col-md-12 waiting">
            <div class="card-body card-total">
                <br />
                <h1 class="card-title display-12">&nbsp;</span> </h1>
                <h3 class="card-title display-12"><span class="spanText" id="gridAguardandoInstalacao" value="gridAguardandoInstalacao"></span> AGUARDANDO INSTALAÇÃO </h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary col-md-12 vehiclesTotal">
            <div class="card-body card-total">
                <br />
                <h1 class="card-title display-12">&nbsp;</span> </h1>
                <h3 class="card-title display-12"><span class="spanText" id="gridTotal"></span> TOTAL </h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="btn-success text-white center btn-excel col-md-12">
            <a href="https://bi.satcompany.com.br/public/question/d1aa64fe-7aad-4ee4-ab24-6b67468e9d92.xlsx" class="no-link">Gerar Relatório Telemetria <i class="far fa-file-excel"></i></a>
        </div>
    </div>
</div>


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
                <table id="example" class="display" style="width:50%">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Placa - Mercosul</th>
                            <th class="hidden">Chassis</th>
                            <th style="width: 80px;">Modelo</th>
                            <th class="hidden">Latitude</th>
                            <th class="hidden">Longitude</th>
                            <th class="hidden">Endereço</th>
                            <th class="hidden">Estado</th>
                            <th class="hidden">Velocidade</th>
                            <!-- 9 -->
                            <th>Última Transmissão</th>
                            <th style="width: 78px;">Loja</th>
                            <th>Nº Proposta</th>
                            <th>Data de entrada</th>
                            <th>Data de acionamento Técnico</th>
                            <th>Data de início de instalação</th>
                            <th>Data de término de instalação</th>
                            <th>Projeto</th>
                            <th class="hidden">Situação</th>
                            <th></th>
                            <th class="hidden">Filtro - Dt. Entrada</th>

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
<script src="{{asset('/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.ptBr.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js" integrity="" crossorigin=""></script>

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

    // 2022-08-16 09:54:49.000

    $(document).ready(function() {
        columns = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17];
        columsPdf = [1, 2, 3, 6, 7, 9, 12, 13, 14, 15];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        var dateTime = moment(new Date()).format('DD/MM/YYYY HH:mm:ss');
        var oTable = $('#example').DataTable({
            // ajax: "{{route('fleetslarges.data.santander')}}",
            ajax: {
                url: "{{route('fleetslarges.data.santander')}}",
                dataSrc: "",
            },
            order: [
                [12, 'desc']
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets: 18
                }, {
                    targets: [9, 12, 13, 14, 15],
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY HH:mm:ss');
                    }
                },
                {
                    targets: 19,
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
            ], //  "data": "dt_termino_instalacao",
            columns: [{
                "data": "placa"
            }, {
                "data": "placa"
            }, {
                "data": "chassis",
                visible: false
            }, {
                "data": "modelo_veiculo"
            }, {
                "data": "lp_latitude",
                visible: false
            }, {
                "data": "lp_longitude",
                visible: false
            }, {
                "data": '',
                render: function(data, type, row) {
                    return row.end_logradouro + ', ' + row.end_bairro + ' - ' + row.end_cidade + ' ' + row.end_uf;
                },
                visible: false
            }, {
                "data": "estado",
                visible: false
            }, {
                "data": "lp_velocidade",
                visible: false
            }, {
                "data": "lp_ultima_transmissao"
            }, {
                "data": "cliente" // loja
            }, {
                "data": "contrato"
            }, {
                "data": "dt_entrada"
            }, {
                "data": "dt_tecnico_acionado"
            }, {
                "data": "dt_inicio_instalacao"
            }, {
                "data": "dt_termino_instalacao",
            }, {
                "data": "projeto",
                "width": "50px",
                render: function(data, type, row, meta) {
                    if (row.projeto == 'RENEG') {
                        return '<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill texto">RENEG</span>'
                    } else {
                        return '<span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill texto">FINANCEIRA</span>'
                    }

                }
            }, {
                "data": "situacao",
                visible: false
            }, {
                "data": " ",
                "width": "100px",
                render: function(data, type, row, meta) {
                    return '<button type="button" class="btn btn-outline-hover-info  btn-sm btn-icon btn-circle btn-vehicle-data" data-toggle="modal" data-target="#modalVehicle" data-chassi="' + row.chassis + '"><i class="fa fa-search-plus"></i></button>' +
                        ' <a href="{{route("fleetslarges.monitoring.index")}}/' + row.chassis + '" class="btn btn-outline-hover-warning  btn-sm btn-icon btn-circle"><span class="fa fa-map-marked-alt"></span></a>'
                }
            }, {
                "data": "dt_entrada",
                visible: false
            },  ],


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

        oTable.on('draw', function() {
            totalRowCount['financeira'] = oTable.rows(':contains("FINANCEIRA")', {
                search: 'applied'
            }).count();

            totalRowCount['renegociacao'] = oTable.rows(':contains("(RENEG)")', {
                search: 'applied'
            }).count();

            $('#financeira').html(totalRowCount['financeira']);
            $('#renegociacao').html(totalRowCount['renegociacao']);
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

            console.log(totalRowCount)
            return totalRowCount;
        }


        setTimeout(function() {
            tableOneRowCount();
        }, 15000);



        // FUNÇÃO PARA ALTERAR CHECKBOX STATUS OS
        $('input:checkbox').on('change', function() {
            var status = $('input:checkbox[name="pos"]:checked').map(function() {
                return '^' + this.value + '$';
            }).get().join('|');
            $('#example').DataTable().column(16).search(status, true, false, false).draw();
        });


        $('.installed').click(function() {
            $('#example').DataTable().columns(20).search("Instalacao_Efetuada", true, false, true).draw();
        });

        $('.waiting').click(function() {
            $('#example').DataTable().columns(20).search('Aguardando_Instalacao', true, false, true).draw();
        });

        $('.vehiclesTotal').click(function() {
            $('#example').DataTable().columns(20).search('').draw();
        });



        /* Details vehicle */
        $(document).on("click", ".btn-vehicle-data", function() {
            var chassi = $(this).data('chassi');
            $.ajax({
                url: "{{url('')}}/fleetslarges/find/" + chassi,
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    $('#modelo_veiculo_aprimorado').val(response.modelo_veiculo_aprimorado)
                    $('.placa').val(response.placa)
                    $('.empresa').val(response.empresa)
                    $('#r12s_proximos').val(response.r12s_proximos)
                    $('#dif_date').val(response.dif_date)
                    $('.lp_longitude').val(response.lp_longitude)
                    $('.estado').val(response.estado)
                    $('.lp_latitude').val(response.lp_latitude)
                    $('.telefone').val(response.telefone)
                    $('.status').val(response.status)
                    $('.iccid').val(response.iccid)
                    $('.chassis').val(response.chassis)
                    $('.modelo_veiculo').val(response.modelo_veiculo)
                    $('.qtd_dispositivos').val(response.qtd_dispositivos)
                    $('.categoria_veiculo').val(response.categoria_veiculo)
                    $('.cidade').val(response.cidade)
                    $('.operadora').val(response.operadora)
                    $('.cliente').val(response.cliente)
                    $('.data_instalacao').val(response.data_instalacao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'))
                    $('.cod_empresa').val(response.cod_empresa)
                    $('.codigo_fipe').val(response.codigo_fipe)
                    $('.modelo').val(response.modelo)
                    $('.point').val(response.point)
                    $('.lp_ultima_transmissao').val(response.lp_ultima_transmissao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'))
                    $('.versao').val(response.versao)
                    $('.lp_satelite').val(response.lp_satelite)
                    $('.lp_ignicao').val(response.lp_ignicao)
                    $('.r12s_proximos').val(response.r12s_proximos)
                    $('#dif_date').val(response.dif_date)
                    $('.lp_voltagem').val(response.lp_voltagem)
                    $('#veiculo_em_loja').val(response.veiculo_em_loja != "" ? "NÃO" : "SIM")
                    $('#r12s_proximos').val(response.r12s_proximos)
                    $('#dif_date').val(response.dif_date)
                    $('.lp_velocidade').val(response.lp_velocidade + " km/h")
                    $('#point').val(response.point)
                    $('.filial').val(response.filial)
                    $('#status_veiculo_dt').val(response.status_veiculo_dt.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                    $('#status_veiculo').val(response.status_veiculo)
                    $('#sinistrado').val(response.sinistrado != "FALSE" ? "SIM" : "NÃO")
                    $('.end_cep').val(response.end_cep)
                    $('.end_logradouro').val(response.end_logradouro)
                    $('.end_bairro').val(response.end_bairro)
                    $('.end_uf').val(response.end_uf)
                    $('.cliente_foto').attr('src', response.cliente_foto);
                    $('#cliente_cpf').val(response.cliente_cpf)
                    $('#cliente_nome').val(response.cliente_nome)
                    $('#cliente_datadev').val(response.cliente_datadev.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                    $('#cliente_celular').val(response.cliente_celular)
                    $('#cliente_localdev').val(response.cliente_localdev)
                    $('#cliente_local_retirada').val(response.cliente_local_retirada)
                    $('#cliente_contrato').val(response.cliente_contrato)
                    $('#cliente_dataretirada').val(response.cliente_dataretirada.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                    $('#cliente_email').val(response.cliente_email)
                    $('#cliente_endereco').val(response.cliente_endereco)
                    $('.cidade').val(response.end_cidade)
                    $('#cliente_cnh').val(response.cliente_cnh)
                    $('.veiculo_odometro').val(response.veiculo_odometro)
                    $('#cliente_foto_cnh').attr('href', response.cliente_foto_cnh);
                    $('.cliente_foto').attr('href', response.cliente_foto)

                    if (response.status_veiculo != "LOCACAO") {
                        $("#btn_cliente").css({
                            "display": "none"
                        });
                    } else {
                        $("#btn_cliente").css({
                            "display": "inline"
                        });
                    }

                    updateTimeline(response.dt_entrada, response.dt_inicio_instalacao, response.dt_tecnico_acionado, response.dt_termino_instalacao)
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
</script>
@endsection
