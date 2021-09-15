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

    .content {
        background-color: #666;
    }

    #map {
        height: 90vh;
        width: 90vw;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css" />
@endsection

@section('content')

<div id="map" class="map" style="width: 100%; height: 800px;float:left;"></div>
<button id="returnButton">Voltar</button>

@endsection

@section('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster-src.js"></script>
<script src="https://unpkg.com/leaflet.featuregroup.subgroup"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.2.0/leaflet-realtime.min.js"></script>

<script>
    const greenCarIcon = new L.Icon({
        iconUrl: '{{url("markers/car_green.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    const redCarIcon = new L.Icon({
        iconUrl: '{{url("markers/car_red.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });



    function createRealtimeLayer(url, container) {
        return realtime = L.realtime(url, {
            interval: 30 * 1000,
            container: clusterGroup,
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                        'icon': feature.properties.ignicao == 1 ? greenCarIcon : redCarIcon
                    })
                    .bindPopup('<p>Placa: ' + feature.properties.placa + '</p> <p>Chassis: ' + feature.properties.chassis + '</p>');
            }
        })
    }


    var map = L.map('map', {
            center: [-12.452992588205499, -50.42986682751686],
            zoom: 5,
            zoomControl: true,
            maxZoom: 18,
            minZoom: 3,
        }),
        clusterGroup = L.markerClusterGroup().addTo(map),
        subgroup = L.featureGroup.subGroup(clusterGroup),
        realtime = createRealtimeLayer("{{route('fleetslarges.monitoring.carsPosition')}}", subgroup).addTo(map);

    L.tileLayer(
        "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}", {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: "mapbox/streets-v11",
            tileSize: 512,
            zoomOffset: -1,
            accessToken: "pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg"
        }
    ).addTo(map);

    realtime.on('update', function() {
        realtime.getBounds();
    });

    /**
     *
     * Botão voltar
     */
    $("#returnButton").click(function() {
        window.location.href = "{{route('fleetslarges.index')}}";
    });
</script>
@endsection
