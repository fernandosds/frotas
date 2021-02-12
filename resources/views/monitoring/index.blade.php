@extends('layouts.app')

@section("styles")
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""
    />
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
    </style>
@endsection

@section('content')

    <div id="pairing-alert"></div>

    <div class="kt-portlet">

        <div class="kt-portlet kt-portlet--mobile">

            <div class="kt-section hide" id="div-progress-bar">
                <div class="progress progress-sm">
                    <div class="progress-bar kt-bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
                </div>
            </div>

            <!-- HEADER -->
            <div class="row">
                <div class="col-sm-9">
                    <div class="row div-device-status">
                        <div class="col-sm-2 col-6">
                            <i class="fa fa-microchip"></i> <label for="">Isca</label><br />
                            <b for="" id="test-device-code">---</b>
                        </div>

                        <div class="col-sm-2 col-6">
                            <i class="fa fa-link"></i> <label for="">Pareamento</label><br />
                            <b for="" id="pair_device">---</b>
                        </div>

                        <div class="col-sm-2 col-6">
                            <i class="fa fa-signal"></i> <label for="">Última Transmissão</label><br />
                            <b for="" id="last-transmission">---</b>
                        </div>

                        <div class="col-sm-2 col-6">
                            <i class="fa fa-battery-empty" id="icon-nivel-bateria"></i> <label for=""> Nível de Bateria</label><br />
                            <b for="" id="nivel-bateria">---</b>
                        </div>

                        <div class="col-sm-2 col-6">
                            <i class="fa  fa-cube"></i> <label for="">Tipo de ísca</label><br />
                            <b for="" id="device-tipo">---</b>
                        </div>

                        <div class="col-sm-2 col-6">
                            <i class="fa  fa-clock"></i> <label for="">Término previsto</label><br />
                            <b for="" id="time-left">---</b>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 col-12 div-btn-start">
                    <div class="form-row align-items-center">
                        <div class="col-sm-3 col-4 my-1">
                            <input type="number" class="form-control mb-2" id="minutes" placeholder="Tempo" value="500">
                        </div>
                        <div class="col-sm-5 col-8 my-1">
                            <input type="text" class="form-control mb-2" id="chassi_device" placeholder="Ísca" value="{{$device ?? '99A00105'}}">
                        </div>
                        <div class="col-auto col-4 my-1">
                            <button type="button" class="btn btn-primary mb-2" id="btn-start">Monitorar</button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12"><hr />

                    <button type="button" class="btn btn-link btn-sm pull-right modal-grid" data-toggle="modal" data-target=".bd-example-modal-xl"><i class="fa fa-table"></i> Histórico de Posições</button>
                    <div id="last-address"></div>
                </div>

            </div>


            <div id="mapid" class="mapid" style="width: 100%; height: 800px;float:left;"> </div>

        </div>
    </div>

    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="modal-content">
                <div class="center"><i class="fa fa-pulse fa-spinner fa-5x"></i><br />Aguarde... </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    <script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js" integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    <script src="https://unpkg.com/esri-leaflet-heatmap@2.0.0"></script>

    <script>

        var heat = {};
        var marker = {};
        var marker_r12 = {};
        var marker_event = {};
        var circle = {};
        var minutes = 10;
        var chassi_device = '';

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
         * Rastrea isca
         */
        $('#btn-start').click(function(){

            Swal.fire({
                title: '<i class="fa fa-3x fa-spinner fa-pulse"></i>',
                html: '<h4>Aguarde, localizando dispositivo...</h4>',
                showCancelButton: false,
                showConfirmButton: false
            })

            chassi_device = $("#chassi_device").val();

            if(lastPosition(chassi_device)){

                loadIconsDeviceStatus(chassi_device);
                heatMap(chassi_device);

                // Progress bar
                $('#div-progress-bar').show();
                progressBar = 100;
                setInterval(function(){

                    if(progressBar == 0){
                        progressBar = 100;

                        lastPosition(chassi_device);
                        loadIconsDeviceStatus(chassi_device);

                    }else{
                        progressBar = progressBar - 1;
                    }
                    $('#progress_bar').attr("style", "width:"+progressBar+"%")

                },1000);
            }

        })

        /**
         * Mapa de calor
         */
        function heatMap(chassi_device)
        {

            if($('#minutes').val() == ""){
                minutes = 10;
            }else{
                minutes = $('#minutes').val();
            }

            // Map
            $.ajax({
                url: "{{url('monitoring/map/heat')}}/"+chassi_device+'/'+minutes,
                type: 'GET',
                success: function(data) {

                    if(mymap.hasLayer(heat)){
                        mymap.removeLayer(heat);
                    }

                    // Mapa de calor
                    heat = L.heatLayer(data, {
                        radius: 20,
                        max: 1.0,
                        blur: 15,
                        minOpacity: 0.7
                    }).addTo(mymap);

                }
            });
        }

        /**
         * Marker - Última posição válida
         */
        function lastPosition(chassi_device)
        {

            $.ajax({
                url: "{{url('/monitoring/map/last-position')}}/" + chassi_device,
                type: 'GET',
                success: function (data) {

                    if(data.status == "error"){
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Ísca não embarcada',
                            showConfirmButton: true,
                            timer: 10000
                        });
                        return false;
                    }

                    Swal.close()

                    if(data.last_positions.status == "sucesso"){

                        if(mymap.hasLayer(marker)){
                            mymap.removeLayer(marker);
                        }
                        if(mymap.hasLayer(circle)){
                            mymap.removeLayer(circle);
                        }
                        if(mymap.hasLayer(marker_r12)){
                            mymap.removeLayer(marker_r12);
                        }
                        if(mymap.hasLayer(marker_event)){
                            mymap.removeLayer(marker_event);
                        }

                        position = data.last_positions['body'][0];

                        mymap.panTo(new L.LatLng(position.Latitude, position.Longitude));

                        // Posição aproximada
                        if( position.Atualizado == 0 && position.Satelites < 4 ){

                            circle = L.circle([position.Latitude, position.Longitude], {
                                color: 'gray',
                                fillColor: '#f03',
                                fillOpacity: 0.1,
                                radius: 800,
                                border: 0
                            }).addTo(mymap);

                            // Posição exata
                        }else{
                            marker = L.marker([position.Latitude, position.Longitude]).addTo(mymap);
                        }

                        console.log(data.pairing)
                        // Mostra evento de despareamento
                        if(!data.pairing.status){

                            var redIcon = new L.Icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });

                            var greenIcon = new L.Icon({
                                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                iconSize: [25, 41],
                                iconAnchor: [12, 41],
                                popupAnchor: [1, -34],
                                shadowSize: [41, 41]
                            });


                            marker_event = L.marker([data.pairing.event.position.lat, data.pairing.event.position.lon], {icon: greenIcon}).addTo(mymap);
                            marker_r12 = L.marker([data.pairing.r12.last_position.lat, data.pairing.r12.last_position.lon], {icon: redIcon}).addTo(mymap);
                        }



                        $('#last-address').html(
                            '<b>Último endereço válido:</b> '+data.address+

                            '<b> - Satélites:</b> '+position.Satelites+
                            '<b> - Modo:</b> '+position.Modo
                        );

                        if(!data.pairing.status){
                            $('#pairing-alert').html('<div class="alert alert-danger center blink" role="alert">' +
                                '<strong><i class="fa fa-unlink"></i> ATENÇÃO!</strong> &nbsp; '+data.pairing.message+'</div>');
                        }else{
                            $('#pairing-alert').html('<div class="alert alert-success center blink" role="alert">' +
                                '<strong><i class="fa fa-link"></i> ATENÇÃO!</strong> &nbsp; '+data.pairing.message+'</div>');
                        }

                        $('#time-left').html(data.time_left);

                    }else{

                        clearIcons()
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Dispositivo não encontrado',
                            showConfirmButton: true,
                            timer: 10000
                        })
                    }

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

            $('#span-address-'+cont).html('<i class="fa fa-spinner fa-pulse"></i> Carregando endereço...')

            $.ajax({
                type: 'GET',
                url: '{{url("monitoring/get-address")}}/' + grid_lat + '/' + grid_lng,
                success: function (response) {

                    $('#span-address-'+cont).html(response)
                }
            });

        })

        /**
         * Carrega grid
         */
        $('.modal-grid').click(function(){

            $.ajax({
                url: "{{url('monitoring/get-grid')}}/" + chassi_device+"/"+minutes,
                type: 'GET',
                success: function (data) {

                    $('#modal-content').html(data)

                }
            })


        })

        /**
         * Ícones - Status
         */
        function loadIconsDeviceStatus(chassi_device)
        {

            var loading = '<i class="fa fa-spinner fa-pulse"></i>';
            $("#test-device-code").html(loading);
            $("#pair_device").html(loading);
            $("#device-tipo").html(loading);
            $('#last-transmission').html(loading);
            $('#nivel-bateria').html(loading);
            $('#nivel-bateria').html(loading);

            $.ajax({
                type: 'GET',
                url: '{{url("monitoring/test-device")}}/'+chassi_device,
                success: function(response) {

                    if (response.status == "success") {

                        $("#div-new-boarding").removeClass('hidden')

                        $('#device_id').val(response.device_id);
                        $('#pair_device').html(response.pair_device);
                        $("#test-device-code").html(response.model);
                        $('#last-transmission').html(response.last_transmission)
                        $('#device-tipo').html(response.device_type)


                        // Battery
                        var battery_level = response.battery_level;
                        $('#nivel-bateria').html(battery_level)
                        $('#icon-nivel-bateria').removeClass('fa fa-battery-empty');
                        $('#icon-nivel-bateria').removeClass('fa fa-battery-quarter');
                        $('#icon-nivel-bateria').removeClass('fa fa-battery-half');
                        $('#icon-nivel-bateria').removeClass('fa fa-battery-three-quarters');
                        $('#icon-nivel-bateria').removeClass('fa fa-battery-full');
                        if (parseInt(battery_level) < 20) {
                            $('#icon-nivel-bateria').addClass('fa fa-battery-empty');
                        } else if (parseInt(battery_level) < 40) {
                            $('#icon-nivel-bateria').addClass('fa fa-battery-quarter');
                        } else if (parseInt(battery_level) < 60) {
                            $('#icon-nivel-bateria').addClass('fa fa-battery-half');
                        } else if (parseInt(battery_level) < 80) {
                            $('#icon-nivel-bateria').addClass('fa fa-battery-three-quarters');
                        } else {
                            $('#icon-nivel-bateria').addClass('fa fa-battery-full');
                        }

                    } else {

                        clearIcons()

                        if(alert){
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 10000
                            })
                        }


                    }

                }
            })

        }

        /**
         * Limpa ícones
         */
        function clearIcons()
        {
            $("#test-device-code").html('---');
            $("#pair_device").html('---');
            $("#device-tipo").html('---');
            $('#last-transmission').html('---');
            $('#nivel-bateria').html('---');
            $('#pairing-alert').html('---');
            $('#time-left').html('---');
        }

    </script>
@endsection