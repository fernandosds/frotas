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
</style>
@endsection

@section('content')

<div class="kt-section " id="div-progress-bar-fleetlarge">
    <br />
    <div class="progress progress-sm">
        <div class="progress-bar kt-bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar_fleetlarge"></div>
    </div>
</div>
<div class="row" id="div-grid-vehicle">
    <div class="col-xl-4">
        <div class="card text-white bg-success col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4">{{$totalJson}}</h1>
                <p class="card-text h5">Total de veículos cadastrados.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-success col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"> <span id="statusComunicando"></h1>
                <p class="card-text h5">Total de veículos comunicando.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-warning  col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="statusAvaria"></h1>
                <p class="card-text h5">Total de veículos com avaria.</p>
            </div>
        </div>
    </div>
</div>

<div class="row" id="div-grid-vehicle2">
    <div class="col-xl-4">
        <div class="card text-white bg-danger col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="statusSinistro"></span> </h1>
                <p class="card-text h5">Total de veículos sinistrados.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-primary col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"><span id="statusParadoEmLoja"></h1>
                <p class="card-text h5">Total de veículos parado em loja.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-warning  col-md-12">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"> 0</h1>
                <p class="card-text h5">Total de veículos sem comunicação.</p>
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
                    <table id="example" class="display nowrap" style="width:50%">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th class="hidden">Endereço</th>
                                <th>Localidade</th>
                                <th class="hidden">Satelite</th>
                                <th class="hidden">Velocidade</th>
                                <th class="hidden">Voltagem</th>
                                <th>Última Transmissão</th>
                                <th>Sinistrado</th>
                                <th>Filial</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyVehicle">
                            @foreach ($fleetslarge as $driver)
                            <tr id='_tr_car_{{$driver["chassis"]}}'>
                                <td>{{$driver['placa']}}</td>
                                <td>{{$driver['modelo_veiculo']}}</td>
                                <td class="hidden">---</td>
                                <td>{{$driver['estado']}}</td>
                                <td class="hidden">{{$driver['lp_satelite']}}</td>
                                <td class="hidden">{{$driver['lp_velocidade']}}</td>
                                <td class="hidden">{{$driver['lp_voltagem']}}</td>
                                <td>{{\Carbon\Carbon::parse($driver['lp_ultima_transmissao'])->format('d/m/Y H:i:s')}}</td>
                                <td>{{$driver['sinistrado'] == 'TRUE' ? 'Sim' : 'Nao'}}</td>
                                <td>{{$driver['filial']}}</td>
                                <td>{{$driver['status_veiculo']}}</td>
                                <td>
                                    <button type="button" class="btn  btn-pill  btn-sm btn-vehicle-data" data-toggle="modal" data-target="#modalVehicle" data-chassi="{{$driver['chassis']}}">
                                        <span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill"><i class="fa fa-search-plus"></i>Detalhes</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('fleetslarge.dashboard.modalVehicle')

    @endsection

    @section('scripts')
    <script>
        /**
        $(function() {
            setTimeout(function() {
                location.reload();
            }, 180000);
        });
*/
        start()
        /**
         * Rastrea isca automaticamente
         */
        $(document).ready(function() {
            reloadValue()
        })

        function reloadValue() {

            $.ajax({
                url: "{{url('')}}/fleetslarges/show/status/sinistrado",
                type: 'GET',
                success: function(response) {
                    if (response.data[0] == "") {
                        return $('#statusSinistro').html(0)
                    }
                    $('#statusSinistro').html(response.data.length)
                }
            });
            $.ajax({
                url: "{{url('')}}/fleetslarges/show/status/comunicando",
                type: 'GET',
                success: function(response) {
                    if (response.data[0] == "") {
                        return $('#statusComunicando').html(0)
                    }
                    $('#statusComunicando').html(response.data.length)
                }
            });
            $.ajax({
                url: "{{url('')}}/fleetslarges/show/status/emloja",
                type: 'GET',
                success: function(response) {
                    if (response.data[0] == "") {
                        return $('#statusParadoEmLoja').html(0)
                    }
                    $('#statusParadoEmLoja').html(response.data.length)
                }
            });
            $.ajax({
                url: "{{url('')}}/fleetslarges/show/status/avaria",
                type: 'GET',
                success: function(response) {
                    if (response.data[0] == "") {
                        return $('#statusAvaria').html(0)
                    }
                    $('#statusAvaria').html(response.data.length)
                }
            });
        }

        /**
         * Rastrea isca
         */
        function start() {
            // Progress bar
            $('#div-progress-bar-fleetlarge').show();
            progressBar = 100;
            setInterval(function() {
                if (progressBar == 0) {
                    $("#div-grid-vehicle").load(" #div-grid-vehicle > *");
                    $("#div-grid-vehicle2").load(" #div-grid-vehicle2 > *");
                    reloadValue()
                    progressBar = 100;
                } else {
                    progressBar = progressBar - 1;
                }
                $('#progress_bar_fleetlarge').attr("style", "width:" + progressBar + "%")

            }, 1000);
        }

        $(document).ready(function() {
            $('#example').DataTable({
                dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                    "<'row'<'col-md-6'><'col-md-6'>>" +
                    "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible:not(.notexport)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(.notexport)'
                        }
                    },
                    {
                        extend: 'copy'
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
                columnDefs: [{
                    targets: [0],
                    orderData: [0, 1]
                }, {
                    targets: [1],
                    orderData: [1, 0]
                }, {
                    targets: [4],
                    orderData: [4, 0]
                }],
            });

        });

        /* Details vehicle */
        $('.btn-vehicle-data').click(function() {
            var chassi = $(this).data('chassi');
            $.ajax({
                url: "{{url('')}}/fleetslarges/find/" + chassi,
                type: 'GET',
                success: function(response) {
                    $('#modelo_veiculo_aprimorado').val(response.modelo_veiculo_aprimorado)
                    $('#placa').val(response.placa)
                    $('#empresa').val(response.empresa)
                    $('#r12s_proximos').val(response.r12s_proximos)
                    $('#dif_date').val(response.dif_date)
                    $('#lp_longitude').val(response.lp_longitude)
                    $('#estado').val(response.estado)
                    $('#lp_latitude').val(response.lp_latitude)
                    $('#telefone').val(response.telefone)
                    $('#status').val(response.status)
                    $('#iccid').val(response.iccid)
                    $('#chassis').val(response.chassis)
                    $('#modelo_veiculo').val(response.modelo_veiculo)
                    $('#modelo_veiculo_span').html(response.modelo_veiculo)
                    $('#qtd_dispositivos').val(response.qtd_dispositivos)
                    $('#categoria_veiculo').val(response.categoria_veiculo)
                    $('#cidade').val(response.cidade)
                    $('#operadora').val(response.operadora)
                    $('#cliente').val(response.cliente)
                    $('#data_instalacao').val(response.data_instalacao)
                    $('#cod_empresa').val(response.cod_empresa)
                    $('#codigo_fipe').val(response.codigo_fipe)
                    $('#modelo').val(response.modelo)
                    $('#point').val(response.point)
                    $('#lp_ultima_transmissao').val(response.lp_ultima_transmissao)
                    $('#versao').val(response.versao)
                    // $('#endereco').val(response.endereco)
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
    </script>
    @endsection
