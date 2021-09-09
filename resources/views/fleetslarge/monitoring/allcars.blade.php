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

    #returnButton {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px;
        z-index: 400;
    }
</style>
@endsection

@section('content')

<div id="pairing-alert"></div>
<!--
<div class="kt-portlet kt-portlet--mobile">



    <div class="col-sm-2 col-3 my-1">
        <a href="{{route('fleetslarges.index')}}" class="btn btn-warning mb-2" id="btn-start">Voltar</a>
    </div>

</div>-->

<div class="kt-section" id="div-progress-bar">
    <div class="progress">
        <div class="" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
    </div>
</div>
<div id="mapid" class="mapid" style="width: 100%; height: 800px;float:left;"></div>
<button id="returnButton">Voltar</button>


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
    var heat = {};
    var marker = {};
    var marker_truck = {};
    var marker_event = {};
    var circle = {};
    var minutes = 10;
    var chassi_device = '';

    /* Icons */

    var redcarIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-car-red-icon.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    var greencarIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-car-green-icon.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });

    var mymap = L.map('mapid').setView([-15.7801, -47.9292], 5);

    var baseLayers = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg', {
        attribution: '&copy; <a href="https://www.satcompany.com.br">SAT Company</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);


    $(document).ready(function() {
        start()
        lastPosition()
    })

    /**
     *
     * Botão voltar
     */
    $("#returnButton").click(function() {
        window.location.href = "{{route('fleetslarges.index')}}";
    });



    /**
     * Rastrea os carros
     */
    function start() {
        // Progress bar
        $('#div-progress-bar').show();
        progressBar = 100;
        setInterval(function() {
            $('#progress_bar').addClass('progress-bar progress-bar-striped');
            if (progressBar < 11) {
                $('#progress_bar').removeClass('progress-bar progress-bar-striped');
                $('#progress_bar').addClass("progress-bar progress-bar-striped bg-danger");
            }
            if (progressBar == 0) {
                $('#progress_bar').removeClass('progress-bar progress-bar-striped bg-danger');
                $('#progress_bar').addClass('progress-bar progress-bar-striped');
                progressBar = 100;

                lastPosition(chassi_device);
                loadIconsDeviceStatus(chassi_device);

            } else {
                progressBar = progressBar - 1;
            }
            $('#progress_bar').attr("style", "width:" + progressBar + "%")

        }, 1000);
    }

    /**
     * Marker - Última posição válida
     */
    function lastPosition() {
        $.ajax({
            url: "{{url('')}}/fleetslarges/monitoring/cars/position/",
            type: 'GET',
            success: function(data) {
                modelo = data.modelo;
                console.log(data.data)

                if (mymap.hasLayer(marker)) {
                    mymap.removeLayer(marker);
                }
                if (mymap.hasLayer(circle)) {
                    mymap.removeLayer(circle);
                }

                if (mymap.hasLayer(marker_event)) {
                    mymap.removeLayer(marker_event);
                }

                const planes = data.data;
                //mymap.panTo(new L.LatLng(-15.7801, -47.9292));

                for (var i = 0; i < planes.length; i++) {
                    if (planes[i].ignicao == 1) {
                        new L.marker([planes[i].lp_latitude, planes[i].lp_longitude], {
                                icon: greencarIcon
                            })
                            .bindPopup('<p>Placa:' + planes[i].placa + '</p> <p>Chassis: ' + planes[i].chassis + '</p>')
                            .addTo(mymap);
                    }
                    if (planes[i].ignicao == 0) {
                        new L.marker([planes[i].lp_latitude, planes[i].lp_longitude], {
                                icon: redcarIcon
                            })
                            .bindPopup('<p>Placa:' + planes[i].placa + '</p> <p>Chassis: ' + planes[i].chassis + '</p>')
                            .addTo(mymap);
                    }
                }
                Swal.close()
            }
        });
    }
</script>
@endsection
