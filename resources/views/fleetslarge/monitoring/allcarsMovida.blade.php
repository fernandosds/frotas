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
        height: 90vh;
        width: 90vw;
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
<button class="customBtnLeafLet btnSaveDraw"><i class="fa fa-save"></i></button>
<button id="returnButton">Voltar</button>

@endsection

@section('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster-src.js"></script>
<script src="https://unpkg.com/leaflet.featuregroup.subgroup"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.2.0/leaflet-realtime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

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
    const logoMovidaIcon = new L.Icon({
        iconUrl: '{{url("markers/logo_movida.png")}}',
        iconSize: [40, 40],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });




    function createRealtimeLayer(url, container) {
        return realtime = L.realtime(url, {
            interval: 30 * 1000,
            container: container,
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                        'icon': feature.properties.ignicao == 1 ? greenCarIcon : redCarIcon
                    })
                    .bindPopup('<p>Placa: ' + feature.properties.placa + '</p> <p>Chassis: ' + feature.properties.chassis + '</p>');
            }
        })
    }

    function lastPosition(url, container) {
            return realtime = L.realtime(url, {
                interval: 30 * 1000000000,
                container: container,
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {
                        'icon': logoMovidaIcon
                    });
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
        subgroup2 = L.featureGroup.subGroup(clusterGroup),
        subgroup3 = L.featureGroup.subGroup(clusterGroup),
        realtime1 = createRealtimeLayer("{{route('fleetslarges.monitoring.carsPosition', 1)}}", subgroup).addTo(map),
        realtime2 = createRealtimeLayer("{{route('fleetslarges.monitoring.carsPosition', 0)}}", subgroup2),
        movidaLojas = lastPosition("{{route('fleetslarges.monitoring.movidaPosition')}}", subgroup3);

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
        'Ignição OFF': realtime2,
        'Lojas': movidaLojas
    }).addTo(map);


    realtime1.on('update', function() {
        realtime1.getBounds();
    });

    let editableLayers = new L.FeatureGroup();
        map.addLayer(editableLayers);

        var MyCustomMarker = L.Icon.extend({
            options: {
                iconUrl: '{{url("markers/car_blue.png")}}',
                iconSize: [64, 64],
                iconAnchor: [35, 62],
                popupAnchor: [1, -34],
            }
        });

        let options = {
            position: 'topright',
            draw: {
                polyline: {
                    shapeOptions: {
                        color: '#f357a1',
                        weight: 10
                    }
                },
                polygon: {
                    allowIntersection: false, // Restricts shapes to simple polygons
                    drawError: {
                        color: '#e1e100', // Color the shape will turn when intersects
                        message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
                    },
                    shapeOptions: {
                        color: '#bada55'
                    }
                },
                circle: false, // Turns off this drawing tool
                rectangle: {
                    shapeOptions: {
                        clickable: false
                    }
                },
                marker: {
                    icon: new MyCustomMarker()
                }
            },
            edit: {
                featureGroup: editableLayers, //REQUIRED!!
                remove: false
            }
        };

        let drawControl = new L.Control.Draw(options);
        map.addControl(drawControl);

        map.on(L.Draw.Event.CREATED, function (e) {
            let type = e.layerType,
                layer = e.layer;

            if (type === 'marker') {
                layer.bindPopup('A popup!');
            }

            editableLayers.addLayer(layer);
        });

        $('.btnSaveDraw').click(function () {
            // Extract GeoJson from featureGroup
            var payloadMap = editableLayers.toGeoJSON();
            if (payloadMap.features.length > 0) {
                let payload = {
                    "_token": "{{ csrf_token() }}", data: { markers: payloadMap, name: '' }
                }
                Swal.fire({
                    title: 'Dê um nome para suas marcações',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Salvar',
                    showLoaderOnConfirm: true,
                    preConfirm: (name) => {
                        payload.data.name = name;
                        return fetch("{{route('map.markers.save')}}", {
                            method: "POST", headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }, body: JSON.stringify(payload)
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.json())
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    `Request failed: ${error}`
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value.isConfirmed) {
                        Swal.fire({
                            title: `Nova Marcação criada`,
                        });
                        editableLayers.clearLayers();
                    }
                })
                /*$.ajax("{{route('map.markers.save')}}", {method: "POST", data:{
                        "_token": "{{ csrf_token() }}",data:data}})
                    .done(function () {
                        alert("success");
                    })
                    .fail(function () {
                        alert("error");
                    })
                    .always(function () {
                        alert("complete");
                    });*/
            }
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
