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

    .markerItem {
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

    .hidden{
        display: none;
    }

    .btnRemove{
        margin-right: 10px;
        color: rgb(255, 0, 0);
        cursor: pointer;
    }

    .eventos{
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

    .eventos.active{
        height: 35vh;
        width: 45vw;
        opacity: 0.8;
    }

    .iconEvent{
        font-size: 13px;
        color: #000;
        padding: 7px 10px;
        cursor: pointer;
    }

    .tableEvents{
        flex: 1;
        justify-content: flex-start;
        align-items: flex-start;
        display: flex;
        margin: 0 auto;
        overflow-y: scroll;
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
            <tr><th>Data</th><th>Placa</th><th>Descricão</th></tr>
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
<div class='markerList hidden'></div>

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

    $('.eventos').on('click', function () {
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
    const logoMovidaIcon = new L.Icon({
        iconUrl: '{{url("markers/logo_movida.png")}}',
        iconSize: [40, 40],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });

    function createRealtimeLayer(url, container) {
        return realtime = L.realtime(url, {
            interval: 60 * 1000,
            container: container,
            getFeatureId: function(f) {
                return f.properties.placa;
            },
            cache: true,
            pointToLayer: function(feature, latlng) {
                let carIcon = feature.properties.ignicao == 'ON' ? greenCarIcon : redCarIcon;

                if (feature.properties.ignicao == 'ON' && !feature.properties.cliente_posicao_recente) {
                    carIcon = greenAlertCarIcon
                }

                if (feature.properties.ignicao == 'OFF' && !feature.properties.cliente_posicao_recente) {
                    carIcon = redAlertCarIcon
                }
                if(feature.properties.deliver == true){
                    carIcon = orangeCarIcon;
                }

                return L.marker(latlng, {
                        'icon': carIcon
                    })
                    .bindPopup('<strong>' + feature.properties.placa + '</strong>' +
                        '<br /><br /><strong><br>Modelo do veículo:</strong>  ' + feature.properties.modelo_veiculo + ' ' +
                        '<br /><strong><br>Chassis:</strong>  ' + feature.properties.chassis + ' ' +
                        '<br /><strong><br>Local de Devolução:</strong>  ' + feature.properties.filial + ' ' +
                        '<br /><strong><br>Local de retirada:</strong>  ' + (feature.properties.cliente_local_retirada ?? '') + ' ' +
                        '<br /><strong><br>Data da retirada:</strong>  ' + (feature.properties.cliente_dataretirada ? feature.properties.cliente_dataretirada.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6') : '') + ' ' +
                        '<br /><strong><br>Data de devolução:</strong>  ' + (feature.properties.cliente_datadev ? feature.properties.cliente_datadev.replace(/(\d*)-(\d*)-(\d*)T(\d*):(\d*):(\d*)-(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6') : '') + ' ' +
                        '<br /><strong><br> Dist. loja devol. | Dist. local ret. | Dist. end. resid. </strong> <br> ' +
                        ' &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;' + feature.properties.cliente_distancia_local_devolucao + '.km &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' + feature.properties.cliente_distancia_local_retirada + '.km &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' + feature.properties.cliente_distancia_endereco_residencial + '.km' +
                        ' ');
            }
        })
    }

    function lastPosition(url, container) {
        var markerList = [];
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                const planes = data.data;
                for (var i = 0; i < planes.length; i++) {
                    var marker = L.marker(L.latLng(planes[i].lp_latitude, planes[i].lp_longitude), {
                        icon: logoMovidaIcon
                    });
                    marker.bindPopup('<strong>' + planes[i].loja +
                        '<br /><br /><br> Endereço:</strong> ' + planes[i].endereco + ' ' +
                        '<br /><strong><br>Complemento:</strong>  ' + planes[i].complemento + ' ' +
                        '<br /><strong><br>Número:</strong> ' + planes[i].numero + ' ' +
                        '<br /><strong><br>Bairro:</strong>  ' + planes[i].bairro + ' ' +
                        '<br /><strong><br>Cidade:</strong>  ' + planes[i].cidade + ' ' +
                        '<br /><strong><br>Região:</strong>  ' + planes[i].regiao + ' ' +
                        '<br /><strong><br>Sigla:</strong>  ' + planes[i].sigla + ' ' +
                        '<strong><br /><br> Horário de Atendimento:</strong> ' + planes[i].horario_atendimento + ' ');
                    markersCluster.addLayer(marker);
                }
            }
        });
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
        realtime2 = createRealtimeLayer("{{route('fleetslarges.monitoring.carsPosition', 0)}}", subgroup2).addTo(map),
        realtime3 = createRealtimeLayer("{{route('fleetslarges.monitoring.carsForDeliver', 1)}}", subgroup3).addTo(map);

    var markersCluster = L.markerClusterGroup().addTo(map);
    lastPosition("{{route('fleetslarges.monitoring.movidaPosition')}}", markersCluster)
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

    L.control.layers(null, {
        'Ignição ON': realtime1,
        'Ignição OFF': realtime2,
        'Entrega Hoje': realtime3,
        'Lojas': markersCluster
    }, {
        collapsed: false
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
                html:'<div class="form-group">'+
                    '<label> Nome da Cerca</label>'+
                    '<input type="text" class="form-control" id="cercaName" placeholder="Nome da Cerca">'+
                    '</div>'+
                    '<div class="form-group">'+
                    '<label>Tipo de cerca</label>'+
                    '<select class="form-control" id="cercaType">'+
                    '<option value="in">Entrada</option>'+
                    '<option value="out">Saída</option>'+
                    '</select></div>',
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                showLoaderOnConfirm: true,
                preConfirm: (value) => {
                    payload.data.name = $('#cercaName').val();
                    payload.data.type = $('#cercaType').val();
                    return fetch("{{route('map.markers.save')}}", {
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
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.value.isConfirmed) {
                    Swal.fire({
                        title: `Nova Cerca criada`, type:'success'
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

    let listLayers = [];

    $('.markerList').on('click', '.btnRemove', function () {
        Swal.fire({
            title: `Remover a cerca "` + $(this).data('name') + `" ?`,
            text: 'Essa ação não pode ser desfeita, para confirmar digite o nome da cerca.',
            type:"warning",
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Remover',
            showLoaderOnConfirm: true,
            preConfirm: (cerca) => {
                console.log(cerca);
                console.log($(this).data('name'));
                if(cerca !== $(this).data('name').toString()){
                    Swal.showValidationMessage(
                        "Nome da cerca diferente do informado!"
                    );
                }else{
                    let payload = {
                        "_token": "{{ csrf_token() }}",
                        data: {
                            id: $(this).data('id'),
                            name: $(this).data('name')
                        }
                    }
                    return fetch("{{route('map.markers.delete')}}", {
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
                    title: `Cerca removida!`, type: 'success'
                });
                editableLayers.clearLayers();
                getList();
            }
        });
    });

    $('.markerList').on('click','.checkMarkers',function(){
        const idLayer = $(this).val();
        if($(this).is(':checked')){
            $.ajax("{{route('map.markers.list')}}/"+ $(this).val(), {
                method: "GET",
            })
                .done(function (response) {
                    const data = response.result;
                    const myData=data.markers;
                    const layerName=data.name;
                    const layerType=data.type == 'in'?"Entrada":'Saída';
                    var myStyle = {
                        "color": "#ff7800",
                        "weight": 5,
                        "opacity": 0.65
                    };
                     var geojson = L.geoJson(data.markers,{style: myStyle, onEachFeature: function (feature, layer) {
                            layer.bindPopup('Cerca:<b>' + layerName + '</b> - Tipo:<b>' + layerType+ '</b>');
                        }}).addTo(map);
                     listLayers.push({"id": idLayer, "layer":geojson});

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

    function getList() {
        $.ajax("{{route('map.markers.list')}}", {
                method: "GET",
            })
            .done(function(response) {
                const data = response.result;
                $('.markerList').empty();
                data.map(function(element) {
                    $('.markerList').append('<div class="markerItem">' +
                        '<i class="fa fa-trash btnRemove" data-id="'+ element._id+'" data-name="'+ element.name+'"></i>' +
                        '<input type="checkbox" class="checkMarkers"' +
                        'id="' + element._id + '"  value="' + element._id + '">' +
                        '<label class="marker-check-label" for="' + element._id + '">' +
                        element.name + '</label></div >');
                });
            })
            .fail(function() {});
    }

    function getEvents() {
            $.ajax("{{route('fleetslarges.monitoring.events')}}", {
                method: "GET",
            })
                .done(function (response) {
                    moment.locale('pt-br');
                    const data = response;
                    $('.tableEventsRows').empty();
                    data.map(function (element) {
                        $('.tableEventsRows').append('<tr><td>'+ moment(element.data).format('DD/MM/YYYY HH:mm:ss')+'</td><td>' + element.placa_veiculo +'</td><td>' + element.descricao +'</td></tr>');
                    });
                })
                .fail(function () { });
        }
    getList();
    getEvents();
</script>
@endsection
