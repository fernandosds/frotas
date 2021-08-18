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
        min-width: 101%;
        margin-left: 100;
    }

    .modal-personalizado.modal-content {
        min-height: 70vh;
    }
</style>
@endsection

@section('content')
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-section" id="div-progress-bar-fleetlarge">
        <div class="progress progress-sm">
            <div class="progress-bar kt-bg-primary" role="progressbar" style="width:81%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="card text-white bg-success col-md-12">
            <div class="card-body">
                <h5 class="card-title"> 2.550
                    <button type="button" class="btn btn-success" id="btn-find-device" data-toggle="modal" data-target=".bd-datatable-modal-lg"><i class="fa fa-search-plus"></i></button>
                </h5>
                <p class="card-text">Total de veículos.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-success col-md-12">
            <div class="card-body">
                <h5 class="card-title">40
                    <button type="button" class="btn btn-success" id="btn-find-device"><i class="fa fa-search-plus"></i></button>
                </h5>
                <p class="card-text">Total de veículos comunicando.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-warning  col-md-12">
            <div class="card-body">
                <h5 class="card-title">15
                    <button type="button" class="btn btn-warning" id="btn-find-device"><i class="fa fa-search-plus"></i></button>
                </h5>
                <p class="card-text">Total de veículos em manutenção.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4">
        <div class="card text-white bg-danger col-md-12">
            <div class="card-body">
                <h5 class="card-title"> 2.550
                    <button type="button" class="btn btn-danger" id="btn-find-device"><i class="fa fa-search-plus"></i></button>
                </h5>
                <p class="card-text">Total de veículos sinistrados.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-primary col-md-12">
            <div class="card-body">
                <h5 class="card-title">40
                    <button type="button" class="btn btn-primary" id="btn-find-device"><i class="fa fa-search-plus"></i></button>
                </h5>
                <p class="card-text">Total de veículos em pátio.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card text-white bg-warning  col-md-12">
            <div class="card-body">
                <h5 class="card-title">15
                    <button type="button" class="btn btn-warning" id="btn-find-device"><i class="fa fa-search-plus"></i></button>
                </h5>
                <p class="card-text">Total de veículos sem comunicação.</p>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-datatable-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style=" overflow-y: auto !important; padding: 0px 15%;">
    <div class="modal-dialog modal-personalizado">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Registros dos veículos cadastrados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            ---
        </div>
    </div>
</div>
<br />
<br />
<div class="col-lg-12">
    <!--begin::Portlet-->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <small>Veículos cadastrados</small>
                </h3>
            </div>
        </div>
        <div class="kt-portlet kt-portlet--mobile" id="kt_content">
            <div class="row">

                <div class="col-md-12">
                    <table id="example" class="display nowrap" style="width:50%">
                        <thead>
                            <tr>
                                <th>Veículo</th>
                                <th>Marca</th>
                                <th>Placa</th>
                                <th>Chassis</th>
                                <th>Localidade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>GM - Chevrolet</td>
                                <td>Blazer Jimmy 4.3 V6</td>
                                <td>CGF5034</td>
                                <td>4LPVJfV2DBL711495</td>
                                <td>Rio de Janeiro</td>
                                <td><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Roubado</span></td>
                            </tr>
                            <tr>
                                <td>Fiat</td>
                                <td>Palio Weekend Trekking 1.8 mpi Flex 8V</td>
                                <td>CGF5034</td>
                                <td>57P2UlNM09LbX4956</td>
                                <td>São Paulo</td>
                                <td><span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Veículo sem comunicar</span></td>
                            </tr>
                            <tr>
                                <td>JAC</td>
                                <td>T6 2.0 JET Flex 5p Mec.</td>
                                <td>GCP0904</td>
                                <td>342SE6A4W5GUA6339</td>
                                <td>São Paulo</td>
                                <td><span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">Parado na loja</span></td>
                            </tr>

                            <tr>
                                <td>HYUNDAI</td>
                                <td>Sonata 2.4 16V 182cv 4p Aut.</td>
                                <td>BWG4553</td>
                                <td>1SJS2K3KKALD21613</td>
                                <td>Porto Alegre</td>
                                <td><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Roubado</span></td>
                            </tr>

                            <tr>
                                <td>NISSAN</td>
                                <td>AX 6.5D Turbo Diesel</td>
                                <td>OVA3769</td>
                                <td>89C32TCZ7ADS35975</td>
                                <td>Maceió</td>
                                <td><span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Veículo sem comunicar</span></td>
                            </tr>

                            <tr>
                                <td>MERCEDES BENZ</td>
                                <td>J2 1.4 16V 5p Mec.</td>
                                <td>PJZ6826</td>
                                <td>70D1V63TLW6GM6198</td>
                                <td>Salvador</td>
                                <td><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Roubado</span></td>
                            </tr>

                            <tr>
                                <td>CITROEN</td>
                                <td>Xantia 2.0 16V</td>
                                <td>PNR4842</td>
                                <td>81ZJVN4YAFAHM1049</td>
                                <td>Goiânia</td>
                                <td><span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Disponível</span></td>
                            </tr>

                            <tr>
                                <td>RENAULT</td>
                                <td>Express 1.6/ RL 1.6</td>
                                <td>OEO9980</td>
                                <td>8FZU7ACUKSEHJ4587</td>
                                <td>Fortaleza</td>
                                <td><span class="kt-badge  kt-badge--warning kt-badge--inline kt-badge--pill">Veículo sem comunicar</span></td>
                            </tr>

                            <tr>
                                <td>VW - VOLKSWAGEN</td>
                                <td>Quantum 1.8 Mi/ 1.8i</td>
                                <td>HPS1631</td>
                                <td>8MMVUKP0NPA2X8643</td>
                                <td>Brasilia</td>
                                <td><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Roubado</span></td>
                            </tr>

                            <tr>
                                <td>TOYOTA</td>
                                <td>PRIUS HYBRID 1.8 16V 5p Aut.</td>
                                <td>QUQ3282</td>
                                <td>7C0MRENA5DESA7489</td>
                                <td>Florianópolis</td>
                                <td><span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">Parado na loja</span></td>
                            </tr>

                            <tr>
                                <td>FIAT</td>
                                <td>Uno Furgão 1.5/ 1.3</td>
                                <td>EWX4533</td>
                                <td>2XR7A9A3APY6S4553</td>
                                <td>Curitiba</td>
                                <td><span class="kt-badge  kt-badge--danger kt-badge--inline kt-badge--pill">Roubado</span></td>
                            </tr>

                            <tr>
                                <td>FIAT</td>
                                <td>Uno Furgão 1.5/ 1.3</td>
                                <td>LEZ6999</td>
                                <td>44FSD1SEXRVVV4619</td>
                                <td>Aracaju</td>
                                <td><span class="kt-badge  kt-badge--success kt-badge--inline kt-badge--pill">Disponível</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
        $('#div-progress-bar-fleetlarge').ready(function() {
            progressBar = 100;
            if (progressBar == 0) {
                progressBar = 100;
                progressBar = progressBar - 1;
            }
            $('#progress_bar').attr("style", "width:" + progressBar + "%")
        }, 180000);


        $(document).ready(function() {
            $('#example').DataTable({
                buttons: [
                    'excelHtml5'
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
    </script>
    @endsection
