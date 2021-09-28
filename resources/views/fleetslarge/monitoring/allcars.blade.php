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
        top: 10px;
        left: 55px;
        padding: 10px;
        z-index: 400;
        border: 2px solid rgba(0,0,0,0.2);
        background-clip: padding-box;
        border-radius: 5px;
        z-index: 400;
    }

    .content {
        background-color: #666;
    }

    #map {
        height: 100vh;
        width: 100vw;
    }

    .customBtnLeafLet{
        box-sizing: border-box;
        background-clip: padding-box;
        border: 2px solid rgba(0,0,0,0.2);
        border-radius: 4px;
        width: 34px;
        height: 34px;
        position: absolute;
        z-index: 4444;
        right: 10px;
        top: 266px;
    }

</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw-src.css" />

@endsection

@section('content')

<div id="map" class="map"></div>
<button id="returnButton">Voltar</button>

@endsection

@section('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster-src.js"></script>
<script src="https://unpkg.com/leaflet.featuregroup.subgroup"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.2.0/leaflet-realtime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script>

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
                interval: 60 * 1000,
                container: container,
                getFeatureId: function (f) {
                    return f.properties.placa;
                },
                cache: true,
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                        'icon': feature.properties.ignicao == 'ON' ? greenCarIcon : redCarIcon
                    })
                    .bindPopup('<p>Placa: ' + feature.properties.placa + '</p> <p>Chassis: ' + feature.properties.chassis + '</p>');
            }
        })
    }
    /*let heat;

    $.ajax({
            url: "{{route('fleetslarges.monitoring.carsPosition')}}",
            type: 'GET',
            success: function (data) {
                const planes = data.features;
                let heatMarkers = [];
                for (var i = 0; i < planes.length; i++) {
                    heatMarkers.push([ planes[i].geometry.coordinates[1], planes[i].geometry.coordinates[0], 0.5]);// lat, lng, intensity
                }
                heat = L.heatLayer(heatMarkers, { radius: 25 }).addTo(map);
            }
        });*/



    var map = L.map('map', {
            center: [-12.452992588205499, -50.42986682751686],
            zoom: 5,
            zoomControl: true,
            maxZoom: 18,
            minZoom: 3,
        }),
            clusterGroup = L.markerClusterGroup().addTo(map),
            subgroup = L.featureGroup.subGroup(clusterGroup),
            subgroup2 = L.featureGroup.subGroup(clusterGroup),
            realtime1 = createRealtimeLayer("{{route('fleetslarges.monitoring.carsPosition', 1)}}", subgroup).addTo(map),
            realtime2 = createRealtimeLayer("{{route('fleetslarges.monitoring.carsPosition', 0)}}", subgroup2).addTo(map);

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

    L.control.layers(null, {
            'Ignição ON': realtime1,
            'Ignição OFF': realtime2
        }, {
        collapsed: false
    }).addTo(map);
//,    'Mapa de Calor': heat

        realtime1.on('update', function () {
            realtime1.getBounds();
        });

    let editableLayers = new L.FeatureGroup();
    map.addLayer(editableLayers);

    /**
     *
     * Botão voltar
     */
    $("#returnButton").click(function() {
        window.location.href = "{{route('fleetslarges.index')}}";
    });
</script>
@endsection
