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

    #markerGroupButton {
        position: absolute;
        top: 10px;
        left: 205px;
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

    #map {
        height: 100vh;
        width: 100vw;
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

    .headerGroupCar {}

    .AllGroupCars {
        float: right;
    }

    .groupCars {
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
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw-src.css" />

@endsection

@section('content')
<div class="eventos">
    <i class="fas fa-clipboard-list iconEvent"></i>
    <div class='tableEvents hidden'>
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Placa</th>
                    <th>Descricão</th>
                </tr>
            </thead>
            <tbody class="tableEventsRows">

            </tbody>
        </table>
    </div>
</div>
<div id="map" class="map"></div>
<button class="customBtnLeafLet btnSaveDraw"><i class="fa fa-save"></i></button>
<button id="returnButton">Voltar</button>
<button id="markerButton">Cercas</button>
<button id="markerGroupButton">Grupos</button>
<div class='markerList hidden'></div>
<div class='groupCars hidden'></div>

@endsection

@section('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster-src.js"></script>
<script src="https://unpkg.com/leaflet.featuregroup.subgroup"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.2.0/leaflet-realtime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {

        $('.eventos').on('click', function() {
            $(this).toggleClass('active');
            $('.tableEvents').toggleClass('hidden');
        });

        const greenCarIcon = new L.Icon({
            iconUrl: '{{url("markers/car_green.png")}}',
            iconSize: [64, 64],
            iconAnchor: [35, 62],
            popupAnchor: [1, -34],
        });
        const greenAlertCarIcon = new L.Icon({
            iconUrl: '{{url("markers/car_green_alert.png")}}',
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
        const redAlertCarIcon = new L.Icon({
            iconUrl: '{{url("markers/car_red_alert.png")}}',
            iconSize: [64, 64],
            iconAnchor: [35, 62],
            popupAnchor: [1, -34],
        });

        const orangeCarIcon = new L.Icon({
            iconUrl: '{{url("markers/car_orange.png")}}',
            iconSize: [64, 64],
            iconAnchor: [35, 62],
            popupAnchor: [1, -34],
        });

<<<<<<< HEAD
=======

>>>>>>> 12e0d52e4a0706ba8dce04759cdb0446d68bf95b
        var map = L.map('map', {
                center: [-12.452992588205499, -50.42986682751686],
                zoom: 5,
                zoomControl: true,
                maxZoom: 18,
                minZoom: 3,
            },
            clusterGroup = L.markerClusterGroup().addTo(map),
<<<<<<< HEAD
            subgroup = L.featureGroup.subGroup(clusterGroup));
=======
            subgroup = L.featureGroup.subGroup(clusterGroup);
<<<<<<< HEAD
        //realtime1 = createRealtimeLayer("{{route('map.markers.AllGrupo')}}", subgroup).addTo(map);
>>>>>>> 12e0d52e4a0706ba8dce04759cdb0446d68bf95b
=======

>>>>>>> 7cd6cf34c56333a89d7e9ff7979135ddd3907e85

        var markersCluster = L.markerClusterGroup().addTo(map);

        map.addLayer(markersCluster);

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
            position: 'topleft',
            draw: {
                polyline: false,
                circlemarker: false,
                marker: false,
                circle: false, // Turns off this drawing tool
                polygon: {
                    allowIntersection: false, // Restricts shapes to simple polygons
                    drawError: {
                        color: '#e1e100', // Color the shape will turn when intersects
                    },
                    shapeOptions: {
                        color: '#bada55'
                    }
                },
                rectangle: {
                    shapeOptions: {
                        clickable: false
                    }
                },

            },
            edit: {
                featureGroup: editableLayers, //REQUIRED!!
            }
        };

        let drawControl = new L.Control.Draw(options);
        map.addControl(drawControl);

        map.on(L.Draw.Event.CREATED, function(e) {
            let type = e.layerType,
                layer = e.layer;

            if (type === 'marker') {
                layer.bindPopup('A popup!');
            }

            editableLayers.addLayer(layer);
        });

        $("body").on("focus", ".rowTimeItem", function() {
            $('.lenght_of_stay').mask('######', {
                translation: {
                    '#': {
                        pattern: /[0-9]/
                    }
                }
            });
        });

        $('.btnSaveDraw').click(function() {
            // Extract GeoJson from featureGroup
            var payloadMap = editableLayers.toGeoJSON();
            if (payloadMap.features.length > 0) {
                let payload = {
                    "_token": "{{ csrf_token() }}",
                    data: {
                        markers: payloadMap,
                        name: ''
                    }
                }
                Swal.fire({
                    title: 'Configure sua nova cerca!',
                    html: '<div class="form-group">' +
                        '<label> Nome da Cerca</label>' +
                        '<input type="text" class="form-control" id="cercaName" placeholder="Nome da Cerca">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Tipo de cerca</label>' +
                        '<select class="form-control" id="cercaType">' +
                        '<option value="in">Entrada</option>' +
                        '<option value="out">Saída</option>' +
                        '</select></div>' +
                        '<div class="form-group" style="margin-bottom:5px" >' +
                        '<label for="stay_time">Tempo de permanencia <small>Em minutos</small></label>' +
                        '</div><div class="form-group rowTime">' +
                        '<input type="text" class="form-control rowTimeItem lenght_of_stay" name="lenght_of_stay">' +
                        '</div>' +
                        '<div class="form-check">' +
                        '<input type="checkbox" class="form-check-input 24hrs" id="to_deliver" name="24hr">' +
                        '<label class="form-check-label" for="24hrs">Alertar somente se entrega do veículo for nas próximas 24hrs</label>' +
                        '</div>',
                    showCancelButton: true,
                    confirmButtonText: 'Salvar',
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        payload.data.name = $('#cercaName').val();
                        payload.data.type = $('#cercaType').val();
                        payload.data.lenght_of_stay = $('.lenght_of_stay').val();
                        payload.data.to_deliver = $('#to_deliver').is(':checked');
                        return fetch("{{route('map.markers.poligono.save')}}", {
                                method: "POST",
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(text => {
                                        console.log(text.errors);
                                        let errors = [];
                                        if (text.errors['data.name']) {
                                            errors.push(text.errors['data.name'][0]);
                                        }

                                        if (text.errors['data.lenght_of_stay']) {
                                            errors.push(text.errors['data.lenght_of_stay'][0]);
                                        }

                                        if (text.errors['data.to_deliver']) {
                                            errors.push(text.errors['data.to_deliver'][0]);
                                        }

                                        if (text.errors['data.markers']) {
                                            errors.push(text.errors['data.markers'][0]);
                                        }

                                        if (text.errors['data.type']) {
                                            errors.push(text.errors['data.type'][0]);
                                        }

                                        throw new Error(errors.reduce((x, y) => '<br>' + x + ',<br> ' + y));

                                    })
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    error
                                )
                            });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value.isConfirmed) {
                        Swal.fire({
                            title: `Nova Cerca criada`,
                            type: 'success'
                        });
                        editableLayers.clearLayers();
                        getList();
                    }
                });
            }
        });

        /**
         *
         * Botão voltar
         */
        $("#returnButton").click(function() {
            window.location.href = "{{route('fleetslarges.index')}}";
        });

        $("#markerButton").click(function() {
            $('.markerList').toggleClass("hidden");
        });

        $("#markerGroupButton").click(function() {
            $('.groupCars').toggleClass("hidden");
        });

        let listLayers = [];

        // Remove a cerca criada
        $('.markerList').on('click', '.btnRemove', function() {
            Swal.fire({
                title: `Remover a cerca "` + $(this).data('name') + `" ?`,
                text: 'Essa ação não pode ser desfeita, para confirmar digite o nome da cerca.',
                type: "warning",
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Remover',
                showLoaderOnConfirm: true,
                preConfirm: (cerca) => {
                    if (cerca !== $(this).data('name').toString()) {
                        Swal.showValidationMessage(
                            "Nome da cerca diferente do informado!"
                        );
                    } else {
                        let payload = {
                            "_token": "{{ csrf_token() }}",
                            data: {
                                id: $(this).data('id'),
                                name: $(this).data('name')
                            }
                        }
                        return fetch("{{route('map.markers.poligono.delete')}}", {
                                method: "DELETE",
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(text => {
                                        throw new Error(text.errors['data.name'][0]);
                                    })
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    error
                                )
                            });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.value.isConfirmed) {
                    Swal.fire({
                        title: `Cerca removida!`,
                        type: 'success'
                    });
                    editableLayers.clearLayers();
                    getList();
                }
            });
        });

        // Exibe a cerca no mapa
        $('.markerList').on('click', '.checkMarkers', function() {
            const idLayer = $(this).val();
            //console.log(idLayer)
            if ($(this).is(':checked')) {
                $.ajax("{{route('map.markers.poligono.list')}}/" + $(this).val(), {
                        method: "GET",
                    })
                    .done(function(response) {
                        const data = response.result;
                        const myData = data.markers;
                        const layerName = data.name;
                        const layerType = data.type == 'in' ? "Entrada" : 'Saída';
                        var myStyle = {
                            "color": "#ff7800",
                            "weight": 5,
                            "opacity": 0.65
                        };
                        var geojson = L.geoJson(data.markers, {
                            style: myStyle,
                            onEachFeature: function(feature, layer) {
                                layer.bindPopup('Cerca:<b>' + layerName + '</b> - Tipo:<b>' + layerType + '</b>');
                            }
                        }).addTo(map);
                        listLayers.push({
                            "id": idLayer,
                            "layer": geojson
                        });

                        //L.geoJSON(data.markers, { style: $(this).val() }).addTo(map);
                    })
                    .fail(function() {});
            } else {
                const layer = listLayers.filter(item => item.id == idLayer);
                layer[0].layer.clearLayers();

                for (let i = 0; i < listLayers.length; i++) {
                    if (listLayers[i].id == idLayer) {
                        listLayers.splice(i, 1);
                    }
                }
            }
        });


        //Exibe o grupo de veículos
        $('.groupCars').on('click', '.checkMarkersGrupo', function() {
            const idLayer = $(this).val();

            var grupo = new Array();
            $('input.checkMarkersGrupo:checkbox:checked').each(function() {
                grupo.push($(this).val());
            });

            var form_data = {
                _token: '{{csrf_token()}}',
                grupo: grupo,
            }

            if ($(this).is(':checked')) {
                $.ajax("{{route('map.markers.grupoRelacionamento')}}/", {
                        method: "POST",
                        data: form_data
                    })
                    .done(function(response) {
                        const data = response.data;
                        const myData = data;

                        var myStyle = {
                            "color": "#ff7800",
                            "weight": 5,
                            "opacity": 0.65
                        };
                        var geojson = L.geoJson(data, {
                            style: myStyle,
                            pointToLayer: function(feature, latlng) {
                                let carIcon = feature.properties.ignicao == 'ON' ? greenCarIcon : redCarIcon;

                                return L.marker(latlng, {
                                        'icon': carIcon
                                    })

                                    .bindPopup('<strong>' + feature.properties.placa + '</strong>' +
                                        '<br /><strong><br>Modelo do veículo:</strong>  ' + feature.properties.modelo_veiculo + ' ' +
                                        '<br /><strong><br>Chassis:</strong>  ' + feature.properties.chassis.toUpperCase() + ' ' +
                                        '<br /><strong><br>Velocidade:</strong>  ' + (feature.properties.lp_velocidade ? feature.properties.lp_velocidade + ' km/h' : ' ') + ' ' +
                                        ' ');

                            }
                        }).addTo(map);
                        
                        listLayers.push({
                            "id": idLayer,
                            "layer": geojson
                        });
                        console.log(listLayers);
                    })
                    .fail(function() {});
            } else {
                const layer = listLayers.filter(item => item.id == idLayer);
                layer[0].layer.clearLayers();
                for (let i = 0; i < listLayers.length; i++) {
                    if (listLayers[i].id == idLayer) {
                        listLayers.splice(i, 1);
                    }
                }
            }
        });

        // Exibe a lista de grupos
        function getListGrupo() {
            $.ajax("{{route('map.markers.all')}}", {
                    method: "GET",
                })
                .done(function(response) {
                    const grupos = response.data;
                    console.log('grupos getListGrupo:  ' + grupos)
                    $('.groupCars').empty();
                    grupos.map(function(element) {
                        $('.groupCars').append('<div class="markerItemGrupo">' +
                            '<input type="checkbox" class="checkMarkersGrupo"' +
                            'id="' + element.id + '" value="' + element.id + '">' +
                            '<label class="marker-check-label" for="' + element.id + '">' +
                            element.nome + '</label></div >');
                    });
                })
                .fail(function() {});
        }

        // Exibe a lista de poligonos / cercas
        function getList() {
            $.ajax("{{route('map.markers.poligono.list')}}", {
                    method: "GET",
                })
                .done(function(response) {
                    const data = response.result;
                    console.log('data getList: ' + data)
                    $('.markerList').empty();
                    data.map(function(element) {
                        $('.markerList').append('<div class="markerItem">' +
                            '<i class="fa fa-trash btnRemove" data-id="' + element._id + '" data-name="' + element.name + '"></i>' +
                            '<input type="checkbox" class="checkMarkers"' +
                            'id="' + element._id + '"  value="' + element._id + '">' +
                            '<label class="marker-check-label" for="' + element._id + '">' +
                            element.name + '</label></div >');
                    });
                })
                .fail(function() {});
        }


        getList();
        getListGrupo();



    });
</script>
@endsection
