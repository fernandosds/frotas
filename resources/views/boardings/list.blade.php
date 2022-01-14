@extends('layouts.app')

@section('styles')
<style>
    .chart-container {
        width: 150px !important;
        height: 125px !important;
    }

    .chart-row {
        border-top: 1px solid #eee;
        margin-top: 20px;
        padding-top: 20px;
    }

    .progress-bar-row {
        margin-top: 30px;
    }

    .btn-warning {
        height: 49px;
    }

    #btn-filtrar-clientes {
        height: 34px;
        margin-top: 28px;
    }
</style>
@endsection

@section('content')

@if (Auth::user()->email != 'admin@satcompany.com.br')
<div class="row">
    <div class="col-sm-12">
        <a href="{{url('boardings/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
            <i class="la la-plus"></i> Novo Embarque
        </a><br /><br />
    </div>
</div>
@endif

@if (Auth::user()->email == 'admin@satcompany.com.br')
<section class="section">
    <form action="{{route('index.boardings')}}" method="get">
        <div class="row">
            <div class="col-sm-4">
                <label for="input">Selecione um cliente</label>
                <select class="form-control" name="customer_id" id="customer_id">
                    <option value="">Todos os clientes</option>
                    @foreach( $customers as $customer )
                    <option value="{{$customer->id}}" {{ $customer->id == $customer_id ? 'selected' : ''}}>{{$customer->name}}</option>
                    @endforeach
                </select><br /><br />
            </div>
            <div class="col-sm-4">
                <label for="input">Digite um número de isca</label>
                <input class="form-control" type="text" name="device" id="device">
                <br /><br />
            </div>
            <div class="col-sm-4">
                <button type="submit" class="btn btn-sm  btn-success" id="btn-filtrar-clientes">
                    <span class="fa fa-fw fa-search"></span> Pesquisar
                </button>
            </div>
        </div>
    </form>
</section>
@endif

<div class="row">

    @if(!$boardings->count())
    <div class="kt-portlet kt-portlet--height-fluid">
        <div class="kt-widget14">
            <div class="kt-widget14__content">
                <i class="fa fa-exclamation-triangle"></i> &nbsp; Nenhum embarque em andamento no momento!
            </div>
        </div>
    </div>
    @endif

    @foreach ($boardings as $boarding)
    <div class="col-sm-6 col-xl-4 allBoarding" id="div-{{$boarding->id}}">
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
                <input type="hidden" name="device_number" id="device_number" class="form-control" maxlength="20" value="{{ $boarding->device->model?? '' }}">
                <div class="kt-widget14__content">
                    <div class="kt-widget14__chart">
                        <div id="container-speed-{{$boarding->id}}" class="chart-container"></div>
                    </div>
                    <div class="kt-widget14__legends">
                        <h3 class="kt-widget14__title">
                            <i class="fas fa-shipping-fast text-success"></i> {{$boarding->device->model}}
                        </h3>
                        {{$boarding->transporter ?? ''}}<br /><br />
                        <b>Última Transmissão</b><br />
                        <span id="span-last-transmission-{{$boarding->id}}"><i class="fa fa-spinner fa-pulse"></i> </span><br />
                    </div>
                </div>
                <div class="progress-bar-row">
                    <i class="far fa-flag"></i>
                    <i class="fa fa-flag-checkered pull-right"></i>
                    <div class="progress progress-sm" id="progress-{{$boarding->id}}"></div>
                </div>
                <div class="row chart-row">
                    @if ($boarding->active)
                    <div class="col-md-4">
                        <button type="button" class="btn btn-block btn-sm  btn-warning btn-finish-boarding" data-id="{{$boarding->id}}" @if( Auth::user()->email == 'admin@satcompany.com.br' ) disabled @endif>
                            <span class="fa fa-times"></span> Encerrar
                        </button>
                    </div>
                    <div class="col-md-4">
                        <a href="{{url('monitoring')}}/{{$boarding->device->model}}" class="btn btn-block btn-sm btn-success">
                            <i class="fa fa-map-marker"></i> Monitorar
                        </a>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <a href="{{url('boardings/view')}}/{{$boarding->id}}" class="btn btn-block btn-sm btn-primary"><i class="fa fa-eye"></i> Detalhes</a>
                    </div>
                </div>
                <div class="row chart-row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-sm btn-primary btn-register-ticket" data-toggle="modal" data-target="#modalTickets" data-backdrop="static" data-id="{{$boarding->device->model}}" @if( Auth::user()->email == 'admin@satcompany.com.br' ) disabled @endif>
                            <span class="fa fa-pencil-alt"></span> Registrar Atendimento
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>

@include('boardings.modalServiceHistory')

@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    var gaugeOptions = {
        chart: {
            type: 'solidgauge',
            borderWidth: 0
        },

        title: null,

        pane: {
            center: ['50%', '85%'],
            size: '100%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },

        exporting: {
            enabled: false
        },

        tooltip: {
            enabled: false
        },

        // the value axis
        yAxis: {
            stops: [
                [0.1, '#DF5353'], // green
                [0.5, '#DDDF0D'], // yellow
                [0.9, '#55BF3B'] // red
            ],
            lineWidth: 0,
            tickWidth: 0,
            minorTickInterval: null,
            tickAmount: 2,
            title: {
                y: -70
            },
            labels: {
                y: 16
            }
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };

    @foreach($boardings as $boarding)

    $.ajax({
        type: 'GET',
        url: '{{url("api-device/last-position")}}/{{$boarding->device->model}}',
        success: function(response) {

            $("#progress-{{$boarding->id}}").html('<div class="progress-bar kt-bg-primary" role="progressbar" style="width: {{ minLeftChart($boarding->finished_at, $boarding->created_at) }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>')


            if (response.status == "sucesso") {

                // The speed gauge
                Highcharts.chart('container-speed-{{$boarding->id}}', Highcharts.merge(gaugeOptions, {
                    chart: {
                        borderWidth: 0,
                        spacing: 0,
                        spacingTop: -50
                    },
                    yAxis: {
                        min: 0,
                        max: 100,
                        title: {
                            text: 'Nível de Bateria'
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Tempo restante',
                        data: [parseInt(response['Tensão'])],
                        dataLabels: {
                            format: '<div style="text-align:center">' +
                                '<span style="font-size:25px">{y} %</span><br/>' +
                                '</div>'
                        }
                    }]

                }));
                $('#span-last-transmission-{{$boarding->id}}').html(response['Data_GPS'] + '<br />' + response['last_address'])

            } else {
                $('#span-last-transmission-{{$boarding->id}}').html('Não foi possível carregar as informações!')
            }

        }
    });

    @endforeach

    // Deletar
    $('.btn-finish-boarding').click(function() {

        var div_id = $(this).data('id');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-warning',
                cancelButton: 'btn btn-primary'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Tem certeza?',
            text: "Confirma encerrar embarque?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-times"></i> Encerrar!',
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Manter!',
            reverseButtons: true
        }).then((result) => {

            if (result.value) {

                $.ajax({
                    type: 'GET',
                    url: '{{url("boardings/finish")}}/' + $(this).data('id'),
                    success: function(response) {

                        if (response.status == "success") {
                            Swal.fire({
                                type: 'success',
                                title: 'Ok',
                                text: 'Embarque encerrado com sucesso',
                                showConfirmButton: true,
                                timer: 10000
                            })

                            $('#div-' + div_id).hide();

                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Erro ao tentar encerrar embarque! ' + response.message,
                                showConfirmButton: true,
                                timer: 10000
                            })
                        }
                    }
                });
            }
        })
    })


    /**
         Exibir historicos atendimentos
    */
    var device_number;

    $('.btn-register-ticket').click(function() {
        device_number = $(this).data('id');
        refreshListHistory(device_number);
    })

    /**
         Função para atualizar a div do atendimento
    */
    function refreshListHistory(device_number) {
        $.ajax({
            type: 'GET',
            url: "{{url('boardings/history/show')}}/" + device_number,
            success: function(response) {
                $('#list_history').html(response)
            }
        })
    }


    /**
         Gravar Historico Atendimento
         */
    $(function() {
        $('#btn-history-save').click(function() {
            $.ajax({
                url: "{{url('')}}/boardings/history/save",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "device_number": device_number,
                    "message": $('#formTextArea').val(),
                },
                success: function(response) {
                    console.log(response)
                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Registro salvo com sucesso',
                            showConfirmButton: true,
                            timer: 10000
                        }).then((result) => {
                            refreshListHistory(device_number);
                            console.log(device_number);
                            $("#formTextArea").val("");
                        })
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro ao tentar salvar! ' + response.message,
                            showConfirmButton: true,
                            timer: 10000
                        })
                    }

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
        });
    });
</script>
@endsection
