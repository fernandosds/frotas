@extends('layouts.app')

@section('styles')
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
</style>
@endsection

@section('content')

<div class="kt-section " id="div-progress-bar-fleetlarge">
    <br />
    <div class="progress progress-sm">
        <div class="" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar_fleetlarge"></div>
    </div>
</div>

<div class="row" id="div-grid-vehicle">
    <div class="col-xl-6" id="divCard01">
        <div class="card text-white col-md-12 bg-primary" id="divColor01">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"> <span id="statusComunicando"></h1>
                <p class="card-text h5"><span id="statusCard01">TEMPO MÉDIO DE INSTALAÇÃO</p>
            </div>
        </div>
    </div>
    <div class="col-xl-6" id="divCard02">
        <div class="card text-white col-md-12 bg-primary" id="divColor02">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="statusAvaria"></h1>
                <p class="card-text h5"><span id="statusCard02">TEMPO MÉDIO PARA ACIONAR TECNICO</p>
            </div>
        </div>
    </div>
</div>

<div class="row" id="div-grid-vehicle2">
    <div class="col-xl-6" id="divCard04">
        <div class="card text-white col-md-12 bg-primary" id="divColor04">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="statusParadoEmLoja"></h1>
                <p class="card-text h5"><span id="statusCard04">TEMPO MÉDIO DE DESLOCAMENTO</p>
            </div>
        </div>
    </div>
    <div class="col-xl-6" id='divCard05'>
        <div class="card text-white col-md-12 bg-primary" id='divColor05'>
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="statusSemComunicacao"></h1>
                <p class="card-text h5"><span id="statusCard05">TEMPO MÉDIO DE ATENDIMENTO</p>
            </div>
        </div>
    </div>
</div>

<br />
<br />
<div class="row hidden" id="dashboardSantander">
    <div class="col-xl-3">
        <div class="card text-white bg-primary col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-12"><span id="statusSinistro"></span> </h1>
                <p class="card-text h5"><span id="statusCard06"></p>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card text-white bg-primary col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-12"><span id="statusParadoEmLoja"></h1>
                <p class="card-text h5"><span id="statusCard07"></p>
            </div>
        </div>
    </div>
    <div class="col-xl-3" id='divCard05'>
        <div class="card text-white bg-primary  col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-12"><span id="statusSemComunicacao"></h1>
                <p class="card-text h5"><span id="statusCard08"></p>
            </div>
        </div>
    </div>
    <div class="col-xl-3" id='divCard05'>
        <div class="card text-white bg-primary  col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-12"><span id="statusSemComunicacao"></h1>
                <p class="card-text h5"><span id="statusCard09"></p>
            </div>
        </div>
    </div>
</div>

<br />
<br />

<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">

            <br />
            <div class="kt-portlet kt-portlet--mobile" id="kt_content">

                <div class="col-md-12">
                    <br />
                    <table id="example" class="display" style="width:50%">
                        <thead>
                            <tr class="headerTable">
                                <th>Placa</th>
                                <th style="width: 220px;">Modelo</th>
                                <th class="hidden">Endereço</th>
                                <th class="hidden">Estado</th>
                                <th class="hidden">Velocidade</th>
                                <th class="hidden">Última Transmissão</th>
                                <th>Última Transmissão</th>
                                <th class="santanderOpen">Loja</th>
                                <th class="hidden">Empresa</th>
                                <th style="width: 150px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyVehicle">
                            @foreach ($fleetslarge as $driver)
                            <tr id='_tr_car_{{$driver["chassis"]}}'>
                                <td>{{$driver['placa']}}</td>
                                <td>{{$driver['modelo_veiculo']}}</td>
                                <td class="hidden">{{$driver['end_logradouro']}}, {{$driver['end_bairro']}} - {{$driver['cidade']}} {{$driver['end_uf']}}</td>
                                <td class="hidden">{{$driver['estado']}}</td>
                                <td class="hidden">{{$driver['lp_velocidade']}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver['lp_ultima_transmissao'])->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver['lp_ultima_transmissao']}}</span>{{\Carbon\Carbon::parse($driver['lp_ultima_transmissao'])->format('d/m/Y H:i:s')}}</td>
                                <td class="santanderOpen">{{$driver['cliente']}}</td>
                                <td class="hidden">{{$driver['empresa']}}</td>
                                <td>
                                    @if ($driver['sinistrado'] == 'TRUE')
                                    <button type="button" class="btn btn-danger btn-elevate btn-circle btn-icon btn-vehicle-data" id="btn-modalVehicle" data-toggle="modal" data-target="#modalVehicle" data-chassi="{{$driver['chassis']}}">
                                        <i class="fa fa-search-plus"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success  btn-elevate btn-circle btn-icon btn-vehicle-data" data-toggle="modal" data-target="#modalVehicle" data-chassi="{{$driver['chassis']}}">
                                        <i class="fa fa-search-plus"></i>
                                    </button>
                                    @endif
                                    <a href="{{route('fleetslarges.monitoring.index')}}/{{$driver['chassis']}}" class="btn btn-warning btn-elevate btn-circle btn-icon"><span class="fa fa-map-marked-alt"></span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('fleetslarge.dashboard.modalVehicle')

@endsection

@section('scripts')
<script>
    resetGrid()
    /**
     * Rastrea isca automaticamente
     */
    $(document).ready(function() {
        reloadValue()
    })

    // $('#dashboardSantander').removeClass('hidden'); ** JÁ TEM 4 GRIDS OCULTO COM A CLASSE HIDDEN, DESCOMENTAR ESTA LINHA QUANDO SURGIR A NECESSIDADE.
    $('#timeline').removeClass('hidden');

    function reloadValue() {
        $.ajax({
            url: "{{route('fleetslarges.showAllStatus')}}",
            type: 'GET',
            success: function(response) {
                $('#statusAvaria').html(response.data.grid05.replace(/(\d*):(\d*):(\d*).*/, '$1:$2:$3'))
                $('#statusParadoEmLoja').html(response.data.grid02.replace(/(\d*):(\d*):(\d*).*/, '$1:$2:$3'))
                $('#statusSemComunicacao').html(response.data.grid04.replace(/(\d*):(\d*):(\d*).*/, '$1:$2:$3'))
                $('#statusComunicando').html(response.data.grid01.replace(/(\d*):(\d*):(\d*).*/, '$1:$2:$3'))
            }
        });
    }

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
                reloadValue()
                progressBar = 100;
            } else {
                progressBar = progressBar - 1;
            }
            $('#progress_bar_fleetlarge').attr("style", "width:" + progressBar + "%")
        }, 1000);
    }

    $(document).ready(function() {
        columns = [0, 1, 2, 3, 4, 5, 7, 8];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        $('#example').DataTable({
            dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Grid de Veiculos_' + date,
                    exportOptions: {
                        columns: columns
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

    });

    /* Details vehicle */
    $('.btn-vehicle-data').click(function() {
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

    /**
     * Update Timeline cliente Santander
     */
    function updateTimeline(dt_entrada, dt_inicio_instalacao, dt_tecnico_acionado, dt_termino_instalacao) {
        if (dt_entrada != '') {
            $('#dt_entrada').html(dt_entrada.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*).*/, '$3.$2.$1 às $4:$5:$6'))
            $('#status_dt_entrada').addClass('timelinePointActive');
        } else {
            $('#dt_entrada').html('Aguarde...')
        }

        if (dt_tecnico_acionado != '') {
            $('#dt_tecnico_acionado').html(dt_tecnico_acionado.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*).*/, '$3.$2.$1 às $4:$5:$6'))
            $('#status_dt_tecnico_acionado').addClass('timelinePointActive');
        } else {
            $('#dt_tecnico_acionado').html('Aguarde...')
        }

        if (dt_inicio_instalacao != '') {
            $('#dt_inicio_instalacao').html(dt_inicio_instalacao.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*).*/, '$3.$2.$1 às $4:$5:$6'))
            $('#status_dt_inicio_instalacao').addClass('timelinePointActive');
        } else {
            $('#dt_inicio_instalacao').html('Aguarde...')
        }

        if (dt_termino_instalacao != '') {
            $('#dt_termino_instalacao').html(dt_termino_instalacao.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*).*/, '$3.$2.$1 às $4:$5:$6'))
            $('#status_dt_termino_instalacao').addClass('timelinePointActive');
        } else {
            $('#dt_termino_instalacao').html('Aguarde...')
        }

    }
</script>
@endsection