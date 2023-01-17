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
        .eventos {
        width: 34px;
        height: 34px;
        background: #f0f0f0;
        position: absolute;
        top: 256px;
        left: 10px;
        z-index: 455;
        display: flex;
        border-radius: 4px;
        border: 2px solid rgba(0, 0, 0, 0.2);
        transition: all .2s ease-in-out;
    }

    .eventos.active {
        height: 35vh;
        width: 45vw;
        opacity: 0.8;
    }

    .iconEvent {
        font-size: 13px;
        color: #000;
        padding: 7px 10px;
        cursor: pointer;
    }

    .tableEvents {
        flex: 1;
        justify-content: flex-start;
        align-items: flex-start;
        display: flex;
        margin: 0 auto;
        overflow-y: scroll;
    }

    .rowTime {
        flex-direction: row;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .rowTimeItem {
        width: 70px;
        margin: 0 5px;
    }

    .form-group label,
    .form-check label {
        color: #666 !important;
    }
    .customBtnLeafLet {
        box-sizing: border-box;
        background-clip: padding-box;
        border: 2px solid rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        width: 34px;
        height: 34px;
        position: absolute;
        z-index: 4444;
        left: 10px;
        top: 223px;
    }

    .markerList {
        border: 2px solid rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        min-width: 34px;
        min-height: 34px;
        position: absolute;
        padding: 5px 15px;
        z-index: 4445;
        left: 125px;
        top: 60px;
        background: #f0f0f0;
        display: flex;
        flex-wrap: wrap;
        opacity: 0.8;
        color: #000;
        font-weight: bold;
        width: 25vw;
        max-height: 50vh;
        overflow: scroll;
        overflow-x: hidden;
        justify-content: space-between;
        align-items: baseline;
        align-content: baseline;
    }

    .AllgroupGaragem {
        float: right;
    }

    .groupGaragem {
        border: 2px solid rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        min-width: 34px;
        min-height: 34px;
        position: absolute;
        padding: 5px 15px;
        z-index: 4445;
        left: 205px;
        top: 60px;
        background: #f0f0f0;
        display: flex;
        flex-wrap: wrap;
        opacity: 0.8;
        color: #000;
        font-weight: bold;
        width: 25vw;
        max-height: 50vh;
        overflow: scroll;
        overflow-x: hidden;
        justify-content: space-between;
        align-items: baseline;
        align-content: baseline;
    }

    .markerItem {
        padding: 5px 0px;
        width: 50%;
        box-sizing: border-box;
    }

    .markerItemGrupo {
        padding: 5px 0px;
        width: 50%;
        box-sizing: border-box;
    }

    .markerItemGrupoCercas {
        padding: 5px 0px;
        width: 50%;
        box-sizing: border-box;
    }

    .marker-check-label {
        padding-left: 5px;
        white-space: nowrap;
        overflow: clip;
        text-overflow: ellipsis;
        width: 60%;
    }

    .hidden {
        display: none;
    }

    .btnRemove {
        margin-right: 10px;
        color: rgb(255, 0, 0);
        cursor: pointer;
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
        border: 2px solid rgba(0, 0, 0, 0.2);
        background-clip: padding-box;
        border-radius: 5px;
        z-index: 400;
    }

    #markerButton {
        position: absolute;
        top: 10px;
        left: 125px;
        padding: 10px;
        z-index: 400;
        border: 2px solid rgba(0, 0, 0, 0.2);
        background-clip: padding-box;
        border-radius: 5px;
        z-index: 400;

    }

    #markerQtdeButton {
        position: absolute;
        top: 10px;
        left: 50px;
        padding: 10px;
        z-index: 400;
        border: 2px solid rgba(0, 0, 0, 0.2);
        background-clip: padding-box;
        border-radius: 5px;
        z-index: 400;

    }
    #checklist {
        position: absolute;
        top: 10px;
        left: 50px;
        padding: 10px;
        z-index: 400;
        border: 2px solid rgba(0, 0, 0, 0.2);
        background-clip: padding-box;
        border-radius: 5px;
        z-index: 400;

    }

    .content {
        background-color: #666;
    }

    #mymap {
        height: 100vh;
        width: 100vw;
    }
    .color-check {
        color: #fff;
        font-weight: bold;
    }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw-src.css" />
@endsection

@section('content')

    <div id="mapid" style="width: 100%; height: 1000px;float:left;"></div>
    
    <fieldset id="markerQtdeButton" style="border-color: #fff;">
        <legend>Filtros</legend>
        <div>
        <input type="checkbox" id="one" value="10000" onclick="filterCar(10000)" name="one" checked>
        <label for="one" class="color-check">10.000</label>
        </div>
        <div>
        <input type="checkbox" value="20000" id="two" onclick="filterCar(20000)"name="one">
        <label for="two" class="color-check">20.000</label>
        </div>
        <div>
        <input type="checkbox" value="40000" id="four" onclick="filterCar(40000)" name="one">
        <label for="four" class="color-check">40.000</label>
        </div>
        <div>
        <input type="checkbox" id="allcars" name="one" onclick="filterCar(true)">
        <label for="allcars" class="color-check">Todos os veículos</label>
        </div>
    </fieldset>
    <div id="loading" style="display: block;">
        <i class="fa fa-spinner fa-pulse"></i> Aguarde...
    </div>


@endsection

@include('monitoring.geojson_brasil')

@section('scripts')

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js" integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script src="https://unpkg.com/esri-leaflet-heatmap@2.0.0"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster-src.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" integrity="" crossorigin=""></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" integrity="" crossorigin=""></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js" integrity="" crossorigin=""></script>
    <script src="https://cdn.rawgit.com/hayeswise/Leaflet.PointInPolygon/v1.0.0/wise-leaflet-pip.js"></script>



    <script>
        var filter = 10000;
        $("input:checkbox").on('click', function() {
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";

                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
                filter = 10000;
            }
        });

        
        function filterCar(filters){
            heatMap(filters);
        }
        var heat = {};
        var circle = {};
        var minutes = 10;
        var chassi_device = '';
        var marker_geojson = {};
        var layer_group = {};

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

        var marker = {};
        var layer = L.geoJson(arr_brasil).addTo(mymap);

        var popup = L.popup();
        
        function heatMap(filter)
        {
            $.ajax({
                url: "{{route('heat.monitoring.heatmaplastpositon')}}",
                type: 'GET',
                data: {filter: filter},
                beforeSend: function(){
                    swal.fire({
                        title: 'Aguarde...',
                        text: 'Está sendo processado as informações!',
                        onOpen: function() {
                            swal.showLoading()
                        }
                    })
                },
                success: function (data) {
                    var arr_marker = new Array();
                    if(mymap.hasLayer(layer_group)){
                        mymap.removeLayer(layer_group);
                    }

                    var markers = new L.markerClusterGroup();
                    data.map(function(latlng){
                        let lat = latlng[0];
                        let lng = latlng[1]; 

                        //Remover posição zero
                        if(lat == 0 || lng == 0){   
                            return true;                   
                        }

                        let confirmMaker = L.marker([lat, lng]);
                        
                        layer.eachLayer(function(memberLayer) {
                            if (memberLayer.contains(confirmMaker.getLatLng())) {
                                // markers.addLayer(L.marker(latlng).bindPopup("lat: " + lat +" lng: "+lng));
                                arr_marker.push(markers.addLayer(L.marker(latlng).bindPopup("lat: " + lat +" lng: "+lng)));
                                // mymap.addLayer(markers);
                            }
                        });


                    });
                    layer_group = L.layerGroup(arr_marker);
                    layer_group.addTo(mymap);
                    console.log(arr_marker);
                    
                    // // Mapa de calor
                    // heat = L.heatLayer(data.map(function(latlng){
                    //     let verifyPositionArea = polygon.contains(confirmMaker.getLatLng());
                    //     if(verifyPositionArea != true){

                    //     }
                    // }), {
                    //     radius: 12,
                    //     max: 1.0,
                    //     blur: 15,
                    //     minOpacity: 0.7
                    // }).addTo(mymap);

                   
                }, complete: function(){
                    swal.fire({
                        title: 'Dados processados',
                        timer: 5000,
                        showConfirmButton: true,
                        onClose: function() {
                            swal.hideLoading()
                        }
                    })
                }
            });
        }

        $(document).ready(function(){
            heatMap(10000);
        });
        
    </script>
@endsection

