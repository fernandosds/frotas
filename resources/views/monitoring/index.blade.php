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
        .div-device-status div{
            border-left: 1px solid #eee;
        }
        .kt-section{margin: 0px !important;}
        .map-loading{
            width: 100%;
            height: 100%;
            background-color: #fff;
        }
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
                <div class="col-sm-10">
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
                            <i class="fa  fa-clock"></i> <label for="">Tempo restante</label><br />
                            <b for="" id="time-left">---</b>
                        </div>

                    </div>
                </div>

                <div class="col-sm-2 col-12 div-btn-start">
                    <div class="form-row align-items-center">
                        <div class="col-sm-6 col-6 my-1">
                            <input type="text" class="form-control mb-2" id="chassi_device" placeholder="Chassi ou Ísca" value="{{$device ?? ''}}">
                        </div>
                        <div class="col-auto col-6 my-1">
                            <button type="button" class="btn btn-primary mb-2" id="btn-start">Monitorar</button>
                        </div>
                    </div>
                </div>

            </div>

<!--
            <div class="kt-portlet__head kt-portlet__head--lg">

                <div class="kt-portlet__head-toolbar">

                    <div class="kt-portlet__head-wrapper">

                        <div class="div-device-status">
                            <div class="row">
                                <div class="form-group col-xs-6 col-md-2">
                                    <i class="fa fa-microchip"></i> <label for="">Isca</label><br />
                                    <b for="" id="test-device-code">---</b>
                                </div>
                                <div class="form-group col-xs-6 col-md-2">
                                    <i class="fa fa-5x fa-thumbs-o-up"></i>
                                    <i class="fa fa-link"></i> <label for="">Pareamento</label><br />
                                    <b for="" id="pair_device">---</b>
                                </div>
                                <div class="form-group col-xs-6 col-md-2">
                                    <i class="fa fa-signal"></i> <label for="">Última Transmissão</label><br />
                                    <b for="" id="last-transmission">---</b>
                                </div>
                                <div class="form-group col-xs-6 col-md-2">
                                    <i class="fa fa-battery-empty" id="icon-nivel-bateria"></i> <label for=""> Nível de Bateria</label><br />
                                    <b for="" id="nivel-bateria">---</b>
                                </div>
                                <div class="form-group col-xs-6 col-md-2">
                                    <i class="fa  fa-cube"></i> <label for="">Tipo de ísca</label><br />
                                    <b for="" id="device-tipo">---</b>
                                </div>
                                <div class="form-group col-xs-6 col-md-2">
                                    <i class="fa  fa-clock"></i> <label for="">Tempo restante</label><br />
                                    <b for="" id="time-left">---</b>
                                </div>
                            </div>
                        </div>

                        <div class="kt-portlet__head-actions col-xs-12">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Nome</label>
                                <input type="text" class="form-control mb-2" id="chassi_device" placeholder="Chassi ou Ísca" value="{{$device ?? ''}}">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-2" id="btn-start">Monitorar</button>
                        </div>
                    </div>
                </div>

            </div>-->

            <div id="mapid" class="mapid" style="width: 100%; height: 700px;float:left;"> </div>

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
        var circle = {};

        var mymap = L.map('mapid').setView([-23.55007382401638, -46.63422236151765], 15);

        var baseLayers = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg', {
            attribution: '&copy; <a href="https://www.satcompany.com.br">SAT Company</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);

        // Autoload
        if( '{{$device}}'.length > 0 ){
            //$("#btn-start").click();
            //$("#btn-start").click();
            jQuery('#btn-start').trigger('click');
            document.getElementById('btn-start').click();
        }

        $('#btn-start').click(function(){

            Swal.fire({
                title: '<i class="fa fa-3x fa-spinner fa-pulse"></i>',
                html: '<h4>Aguarde, rastreadndo dispositivo...</h4>',
                showCancelButton: false,
                showConfirmButton: false
            })

            chassi_device = $("#chassi_device").val();
            setLocalization(chassi_device)

            // Progress bar
            $('#div-progress-bar').show();
            progressBar = 100;
            setInterval(function(){

                if(progressBar == 0){
                    progressBar = 100;
                    setLocalization(chassi_device)
                }else{
                    progressBar = progressBar - 1;
                }
                $('#progress_bar').attr("style", "width:"+progressBar+"%")

            },500); //},1000);

        })

        /**
         *
         * @param chassi_device
         */
        function setLocalization(chassi_device)
        {

            loadIconsDeviceStatus(chassi_device);

            // Map
            $.ajax({
                url: "{{url('monitoring/map')}}/"+chassi_device,
                type: 'GET',
                success: function(data) {

                    Swal.close()

                    if(mymap.hasLayer(marker)){
                        mymap.removeLayer(marker);
                    }
                    if(mymap.hasLayer(circle)){
                        mymap.removeLayer(circle);
                    }
                    if(mymap.hasLayer(heat)){
                        mymap.removeLayer(heat);
                    }

                    if(data.status == "success"){

                        $('#time-left').html(data.time_left);
                        position = data[0];

                        mymap.panTo(new L.LatLng(position.lat, position.lng));

                        // Posição aproximada
                        if( position.atualizado == 0 && position.qtd_satelite < 4 ){

                            circle = L.circle([position.lat, position.lng], {
                                color: 'gray',
                                fillColor: '#f03',
                                fillOpacity: 0.1,
                                radius: 800,
                                border: 0
                            }).addTo(mymap);

                        // Posição exata
                        }else{
                            marker = L.marker([position.lat, position.lng]).addTo(mymap);
                        }

                        // Mapa de calor
                        heat = L.heatLayer(data['heat_positions'], {
                            radius: 20,
                            max: 1.0,
                            blur: 15,
                            minOpacity: 0.7
                        }).addTo(mymap);


                        if(!position.pairing.status){
                            $('#pairing-alert').html('<div class="alert alert-warning center blink" role="alert">' +
                                '<strong>ATENÇÃO!</strong> &nbsp; '+position.pairing.message+'</div>');
                        }else{
                            $('#pairing-alert').html('<div class="alert alert-sucess center blink" role="alert">' +
                                '<strong>ATENÇÃO!</strong> &nbsp; '+position.pairing.message+'</div>');
                        }

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
        }

        /**
         *
         * @param device_number
         */
        function loadIconsDeviceStatus(device_number)
        {

            var loading = '<i class="fa fa-spinner fa-pulse"></i>';
            $("#test-device-code").html(loading);
            $("#pair_device").html(loading);
            $("#device-tipo").html(loading);
            $('#last-transmission').html(loading);
            $('#nivel-bateria').html(loading);

            $.ajax({
                type: 'GET',
                url: '{{url("monitoring/test-device")}}/'+device_number,
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