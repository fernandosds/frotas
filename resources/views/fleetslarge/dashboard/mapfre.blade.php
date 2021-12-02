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
</style>
@endsection

@section('content')

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
                                <th>Cliente</th>
                                <th>Placa</th>
                                <th>Placa Mercosul</th>
                                <th>Modelo</th>
                                <th>Tecnologia</th>
                                <th>Chassis</th>
                                <th class="hidden">Última Transmissão</th>
                                <th>Última Transmissão</th>
                                <th style="width: 200px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyVehicle">
                            @foreach ($carros as $driver)
                            <tr id='_tr_car_{{$driver["chassis"]}}'>
                                <td>{{$driver['cliente']}}</td>
                                <td>{{$driver['placa']}}</td>
                                <td>{{$driver['placa_mercosul']}}</td>
                                <td>{{$driver['BI_FIPE_TAB → modelo']}}</td>
                                <td>{{$driver['tecnologia']}}</td>
                                <td>{{$driver['chassis']}}</td>
                                <td class="hidden">{{\Carbon\Carbon::parse($driver['lp_ultima_transmissao'])->format('d/m/Y H:i:s')}}</td>
                                <td><span style="display:none">{{$driver['lp_ultima_transmissao']}}</span>{{\Carbon\Carbon::parse($driver['lp_ultima_transmissao'])->format('d/m/Y H:i:s')}}</td>
                                <td>
                                    <button type="button" class="btn btn-success  btn-elevate btn-circle btn-icon btn-vehicle-mapfre-data" data-toggle="modal" data-target="#modalMapfre" data-chassi="{{$driver['chassis']}}">
                                        <i class="fa fa-search-plus"></i>
                                    </button>
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

@include('fleetslarge.dashboard.modalMapfre')

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        columns = [0, 1, 2, 3, 4, 5, 7];
        columsPdf = [0, 1, 2, 3, 4, 5, 7];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        $('#example').DataTable({
            dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Grid Mapfre_' + date,
                    exportOptions: {
                        columns: columsPdf
                    },
                    orientation: 'landscape',
                },
                {
                    extend: 'excel',
                    title: 'SAT Company :: Grid Mapfre_' + date,
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



    /* Details vehicle Mapfre */
    $('.btn-vehicle-mapfre-data').click(function() {
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
                $('#r12s_proximos').val(response.r12s_proximos)
                $('.lp_velocidade').val(response.lp_velocidade + " km/h")
                $('.filial').val(response.filial)
                $('#status_veiculo_dt').val(response.status_veiculo_dt.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 T $4:$5:$6 - $7:$8'))
                $('#status_veiculo').val(response.status_veiculo)
                $('#sinistrado').val(response.sinistrado != "FALSE" ? "SIM" : "NÃO")
                $('.end_cep').val(response.end_cep)
                $('.end_logradouro').val(response.end_logradouro)
                $('.end_bairro').val(response.end_bairro)
                $('.end_uf').val(response.end_uf)
                $('#cliente').val(response.cliente)
                $('.veiculo_odometro').val(response.veiculo_odometro)

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

    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "textName",
    });

    $(document).on('click', '.spanText', function() {
        if ($(this).attr('value') == 'instalado') {
            $('.textName').val('instalado').focus().click()
        }
    });
</script>
@endsection
