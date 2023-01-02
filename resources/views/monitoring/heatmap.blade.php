@extends('layouts.app_map')
@section("styles")

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
    <style>
        .kt-portlet .kt-portlet__head .kt-portlet__head-toolbar .kt-portlet__head-wrapper,
        .kt-portlet .kt-portlet__head .kt-portlet__head-toolbar, .div-device-status{
            width: 100%;
        }
        .div-device-status{
            margin-left: 20px;
            margin-top: 17px;

        }
        .div-btn-start{
            margin-top: 17px;
        }
        #last-address{
            margin-left: 17px;
            margin-bottom: 15px;
        }
        .modal-grid{
            float: right;
            margin-top: -5px;
        }
        .div-device-status div{
            border-left: 1px solid #eee;
        }
        .kt-section{margin: 0px !important;}
        .map-loading{
            width: 100%;
            height: 100%;
            background-color: #fff;
        }
        .text-orange{color:#ff8000}
        .alert, .kt-portlet{
            margin-bottom: 0px !important;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw-src.css" />
@endsection

@section('content')

    <div id="mapid" style="width: 100%; height: 900px;float:left;"></div>

@endsection

@section('scripts')

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js" integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script src="https://unpkg.com/esri-leaflet-heatmap@2.0.0"></script>

    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" integrity="" crossorigin=""></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" integrity="" crossorigin=""></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js" integrity="" crossorigin=""></script>


    <script>

        var heat = {};
        var circle = {};
        var minutes = 10;
        var chassi_device = '';

        /* Icons */
        var boxIcon     = new L.Icon({ iconUrl: '{{url("markers/marker-box-64.png")}}', iconSize: [64, 64], iconAnchor: [35, 62], popupAnchor: [1, -34], });
        var eventIcon   = new L.Icon({ iconUrl: '{{url("markers/marker-event-64.png")}}', iconSize: [64, 64], iconAnchor: [35, 62], popupAnchor: [1, -34], });
        var truckIcon   = new L.Icon({ iconUrl: '{{url("markers/marker-truck-64.png")}}', iconSize: [64, 64], iconAnchor: [35, 62], popupAnchor: [1, -34], });

        var mymap = L.map('mapid', {center: [-23.55007382401638, -46.63422236151765], zoom: 5})

        var baseLayers = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg', {
            attribution: '&copy; <a href="https://www.satcompany.com.br">SAT Company</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);

        // var markers = L.markerClusterGroup();
        
        function heatMap()
        {
            $.ajax({
                url: "{{route('heat.monitoring.heatmaplastpositon')}}",
                type: 'GET',
                success: function (data) {
                    
                    if(mymap.hasLayer(heat)){
                        mymap.removeLayer(heat);
                    }

                    // const marker = L.marker(data);
                    // markers.addLayer()

                    // Mapa de calor
                    heat = L.heatLayer(data, {
                        radius: 20,
                        max: 1.0,
                        blur: 15,
                        minOpacity: 0.7
                    }).addTo(mymap);

                    // clusterGroup = L.markerClusterGroup().addTo(mymap);
                   
                }
            });
        }

        $(document).ready(function(){
            heatMap();
        });
        
    </script>
@endsection

