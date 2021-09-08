@extends('layouts.app_map')

@section("styles")
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />

<style>
    .kt-portlet .kt-portlet__head .kt-portlet__head-toolbar .kt-portlet__head-wrapper,
    .kt-portlet .kt-portlet__head .kt-portlet__head-toolbar,
    .div-device-status {
        width: 100%;
    }

    .div-device-status {
        margin-left: 20px;
        margin-top: 17px;

    }

    .div-btn-start {
        margin-top: 17px;
    }

    #last-address {
        margin-left: 17px;
        margin-bottom: 15px;
    }


    .modal-grid {
        float: right;
        margin-top: -5px;
    }

    .div-device-status div {
        border-left: 1px solid #eee;
    }

    .kt-section {
        margin: 0px !important;
    }

    .map-loading {
        width: 100%;
        height: 100%;
        background-color: #fff;
    }

    .text-orange {
        color: #ff8000
    }

    .alert,
    .kt-portlet {
        margin-bottom: 0px !important;
    }

    .hidden {
        display: none;
    }
</style>
@endsection

@section('content')

<div id="pairing-alert"></div>

<div class="kt-portlet kt-portlet--mobile">

    <div class="kt-section" id="div-progress-bar">
        <div class="progress">
            <div class="progress-bar progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
        </div>
    </div>

    <!-- HEADER -->
    <div class="row" style="width: 99%">
        <div class="col-sm-11">
            <div class="row div-device-status">
                <div class="col-sm-1 col-3">
                    <i class="fa fa-car-alt"></i> <label for="">Placa</label><br />
                    <b for="" id="placa">---</b>
                </div>

                <div class="col-sm-1 col-3">
                    <i class="fa fa-key"></i> <label for="">Ignição</label><br />
                    <b for="" id="lp_ignicao">---</b>
                </div>


                <div class="col-sm-1 col-6">
                    <i class="fa fa-car-alt"></i> <label for="">Velocidade</label><br />
                    <b for="" id="lp_velocidade">---</b>
                </div>


                <div class="col-sm-2 col-6">
                    <i class="fa fa-car-side"></i> <label for="">Chassis</label><br />
                    <b for="" id="chassis">---</b>
                </div>

                <div class="col-sm-2 col-6">
                    <i class="fa fa-car-side" id="icon-nivel-bateria"></i> <label for=""> Modelo</label><br />
                    <b for="" id="modelo_veiculo">---</b>
                </div>

                <div class="col-sm-2 col-6">
                    <i class="fa  fa-car-alt"></i> <label for="">Categoria</label><br />
                    <b for="" id="categoria_veiculo">---</b>
                </div>

                <div class="col-sm-2 col-6">
                    <i class="fa fa-rss"></i> <label for="">Última Transmissão</label><br />
                    <b for="" id="lp_ultima_transmissao">---</b>
                </div>
            </div>
        </div>

        <div class="col-sm-1 col-12 div-btn-start">
            <div class="form-row align-items-center">
                <div class="col-sm-2 col-3 my-1">
                    <a href="{{route('fleetslarges.index')}}" class="btn btn-warning mb-2" id="btn-start">Voltar</a>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <hr />
            <!--
            <button type="button" class="btn btn-link modal-grid" data-toggle="modal" data-target="#modalGrid" data-backdrop="static" data-keyboard="false"><i class="fa fa-table"></i> Histórico de Posições</button>
            <div id="last-address"></div>
            -->
        </div>
    </div>

</div>

<div id="mapid" class="mapid" style="width: 100%; height: 800px;float:left;"></div>

<div class="modal fade bd-print-grid" id="modal-grid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imprimir Grid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        De: <br />
                        <input class="form-control" type="date" min="1" max="72" id="input-date-from" value="">
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        Até: <br />
                        <input class="form-control" type="date" min="1" max="72" id="input-date-to" value="">
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <br /><b>Atenção</b> Intervalo máximo de 5 dias<br />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-block btn-primary" id="btn-print-grid"><i class="fa fa-print"></i> Imprimir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="modal-content">
            <div class="center"><i class="fa fa-pulse fa-spinner fa-5x"></i><br />Aguarde... </div>
        </div>
    </div>
</div>

@include('fleetslarge.monitoring.modalGrid')

@endsection

@section('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js" integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>


<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" integrity="" crossorigin=""></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" integrity="" crossorigin=""></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js" integrity="" crossorigin=""></script>


<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    /**
     * Pega o chassi atual passado por parâmetro
     */
    chassi_url = window.location.href.split('/')[5];
    var modelo = "";

    var loading = '<i class="fa fa-spinner fa-pulse"></i>';
    $("#placa").html(loading);
    $("#lp_ignicao").html(loading);
    $("#lp_velocidade").html(loading);
    $("#chassis").html(loading);
    $("#modelo_veiculo").html(loading);
    $('#categoria_veiculo').html(loading);
    $('#lp_ultima_transmissao').html(loading);

    var heat = {};
    var marker = {};
    var marker_truck = {};
    var marker_event = {};
    var circle = {};
    var minutes = 10;
    var chassi_device = '';

    /* Icons */
    var boxIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-box-64.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    var eventIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-event-64.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    var truckIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-car.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    console.log(truckIcon);

    var mymap = L.map('mapid').setView([-23.55007382401638, -46.63422236151765], 15);

    var baseLayers = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg', {
        attribution: '&copy; <a href="https://www.satcompany.com.br">SAT Company</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);


    /**
     * Rastrea isca automaticamente
     */
    $(document).ready(function() {
        start()
    })

    /**
     * Rastrea isca
     */
    function start() {

        chassi_device = chassi_url;

        if (lastPosition(chassi_device)) {

            loadIconsDeviceStatus(chassi_device);

            // Progress bar
            $('#div-progress-bar').show();
            progressBar = 100;
            setInterval(function() {

                if (progressBar == 0) {
                    progressBar = 100;

                    lastPosition(chassi_device);
                    loadIconsDeviceStatus(chassi_device);

                } else {
                    progressBar = progressBar - 1;
                }
                $('#progress_bar').attr("style", "width:" + progressBar + "%")

            }, 1000);
        }
    }

    /**
     * Marker - Última posição válida
     */
    function lastPosition(chassi_device) {

        $.ajax({
            url: "{{url('')}}/fleetslarges/monitoring/last-position/" + chassi_device,
            type: 'GET',
            success: function(data) {
                if (data.lp_ignicao == "1") {
                    $("#lp_ignicao").css({
                        "color": "green"
                    });
                } else {
                    $("#lp_ignicao").css({
                        "color": "red"
                    });
                }

                $("#placa").html(data.placa);
                $("#lp_ignicao").html(data.lp_ignicao != "1" ? "OFF" : "ON");
                $("#lp_velocidade").html(data.lp_velocidade + " km/h");
                $("#chassis").html(data.chassis);
                $("#modelo_veiculo").html(data.modelo_veiculo);
                $("#categoria_veiculo").html(data.categoria_veiculo);
                $("#lp_ultima_transmissao").html(data.lp_ultima_transmissao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'));
                $(".modelo").html(data.modelo);

                modelo = data.modelo;

                if (mymap.hasLayer(marker)) {
                    mymap.removeLayer(marker);
                }
                if (mymap.hasLayer(circle)) {
                    mymap.removeLayer(circle);
                }
                /**
                if (mymap.hasLayer(marker_truck)) {
                    mymap.removeLayer(marker_truck);
                }
                 */
                if (mymap.hasLayer(marker_event)) {
                    mymap.removeLayer(marker_event);
                }

                var planes = [
                    ["7C6B07", -40.99497, 174.50808],
                    ["7C6B38", -41.30269, 173.63696],
                    ["7C6CA1", -41.49413, 173.5421],
                    ["7C6CA2", -40.98585, 174.50659],
                    ["C81D9D", -40.93163, 173.81726],
                    ["C82009", -41.5183, 174.78081],
                    ["C82081", -41.42079, 173.5783],
                    ["C820AB", -42.08414, 173.96632],
                    ["C820B6", -41.51285, 173.53274]
                ];


                mymap.panTo(new L.LatLng(-41.3058, 174.82082));

                for (var i = 0; i < planes.length; i++) {
                    marker = new L.marker([planes[i][1], planes[i][2]])
                        .bindPopup(planes[i][0])
                        .addTo(mymap);
                }


                $('#last-address').html(
                    '<b>Último endereço válido:</b> ' + data.end_logradouro +
                    ' <b>Cidade:</b> ' + data.end_cidade
                );



                /**
                mymap.panTo(new L.LatLng(data.lp_latitude, data.lp_longitude));

                marker = L.marker([data.lp_latitude, data.lp_longitude], {
                    icon: truckIcon
                }).addTo(mymap);

                $('#last-address').html(
                    '<b>Último endereço válido:</b> ' + data.end_logradouro +
                    ' <b>Cidade:</b> ' + data.end_cidade
                );
                */
                Swal.close()
            }
        });
        return true;
    }


    /**
     * Carrega endereço do grid
     */
    $("#modal-content").on("click", ".btn-see-address", function() {
        var grid_lat = $(this).data('lat');
        var grid_lng = $(this).data('lng');
        var cont = $(this).data('cont');

        $('#span-address-' + cont).html('<i class="fa fa-spinner fa-pulse"></i> Carregando endereço...')

        $.ajax({
            type: 'GET',
            url: '{{url("monitoring/get-address")}}/' + grid_lat + '/' + grid_lng,
            success: function(response) {
                $('#span-address-' + cont).html(response)
            }
        });

    })

    /**
     * Ícones - Status
     */
    function loadIconsDeviceStatus(chassi_device) {
        var loading = '<i class="fa fa-spinner fa-pulse"></i>';
        $("#placa").html(loading);
        $("#lp_ignicao").html(loading);
        $("#lp_velocidade").html(loading);
        $("#chassis").html(loading);
        $("#modelo_veiculo").html(loading);
        $('#lp_ultima_transmissao').html(loading);
        $('#categoria_veiculo').html(loading);
    }

    /**
     * Limpa ícones
     */
    function clearIcons() {
        $("#placa").html('---');
        $("#lp_ignicao").html('---');
        $("#lp_velocidade").html('---');
        $("#chassis").html('---');
        $("#modelo_veiculo").html('---');
        $('#lp_ultima_transmissao').html('---');
        $('#categoria_veiculo').html('---');
    }



    $('#btn-grid').click(function() {
        var chassis = chassi_url;
        $.ajax({
            type: 'POST',
            url: "{{route('fleetslarges.monitoring.grid')}}",
            async: true,
            data: {
                "_token": "{{ csrf_token() }}",
                "modelo": modelo,
                "chassis": chassis,
                "first_date": $('#first_date').val(),
                "last_date": $('#last_date').val()
            },
            success: function(response) {
                $('#list_grid').html(response);
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
</script>
@endsection
