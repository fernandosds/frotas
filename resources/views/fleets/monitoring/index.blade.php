@extends('layouts.app')


@section('styles')

<link href="{{asset('/css/leaflet.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('/css/leaflet_awesome_number_markers.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css" />
<style>
    #map {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        height: 75vh;
    }
</style>
@endsection

@section('content')
<h1>Mapa</h1>
<div id="map"></div>
@endsection

@section('scripts')

<script src="{{asset('/js/leaflet-src.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/leaflet_awesome_number_markers.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/leaflet-realtime.min.js')}}" type="text/javascript"></script>
<script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet-src.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster-src.js"></script>
<script src="https://unpkg.com/leaflet.featuregroup.subgroup"></script>
<script>
    var map = L.map('map'),
        trail = {
            type: 'Feature',
            properties: {
                id: 1
            },
            geometry: {
                type: 'LineString',
                coordinates: []
            }
        },
        realtime = L.realtime('{{url("fleets/monitoring/positions")}}', {
            interval: 60 * 1000,
            getFeatureId: function(f) {
                return f.properties.id;
            },
            onEachFeature(f, l) {
                l.bindPopup(function() {
                    return '<span> <b>Placa:</b>' + f.properties.placa + '</span><br>' +
                        '<span> <b>Vel.:</b>' + f.properties.velocidade + '</span><br>' +
                        '<span> <b>Data:</b>' + f.properties.Data_GPS + '</span><br>';
                });

            },
            pointToLayer: function(f, latlng) {
                return L.marker(latlng, {
                    'icon': new L.AwesomeNumberMarkers({
                        number: f.properties.number,
                        markerColor: f.properties.color
                    })

                });
            }

        }).addTo(map);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    realtime.on('update', function() {
        map.fitBounds(realtime.getBounds(), {
            maxZoom: 15
        });
    });
</script>
@endsection
