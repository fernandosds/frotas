@extends('layouts.app')

@section("styles")
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""
    />
@endsection

@section('content')

    <div class="kt-portlet">
        <div class="kt-portlet kt-portlet--mobile">

            <div class="kt-section hide" id="div-progress-bar">
                <div class="progress progress-sm">
                    <div class="progress-bar kt-bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
                </div>
            </div>

            <!-- HEADER -->
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand {{$icon}}"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{$title}}
                    </h3>
                </div>

                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">

                        <div class="kt-portlet__head-actions">
                            <div class="col-auto">
                                <label class="sr-only" for="inlineFormInput">Nome</label>
                                <input type="text" class="form-control mb-2" id="chassi_device" placeholder="Chassi ou Ísca" value="99112581">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary mb-2" id="btn-teste">Monitorar</button>
                        </div>
                    </div>
                </div>

            </div>

            <div id="mapid" class="mapid" style="width: 100%; height: 700px;float:left;"></div>

        </div>
    </div>

@endsection

@section('scripts')

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <script>

        var progressBar = 100;
        var mymap = L.map('mapid').setView([-23.569745954891225, -46.61343478451177], 15);
        var marker = L.marker([-23.569745954891225, -46.61343478451177]).addTo(mymap);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'your.mapbox.access.token'
        }).addTo(mymap);

        $('#btn-teste').click(function(){

            chassi_device = $("#chassi_device").val();
            setLocalization(chassi_device)

            // Progress bar
            $('#div-progress-bar').show();
            progressBar = 100;
            setInterval(function(){

                console.log(progressBar)

                if(progressBar == 0){
                    progressBar = 100;
                    setLocalization(chassi_device)
                }else{
                    progressBar = progressBar - 1;
                }
                $('#progress_bar').attr("style", "width:"+progressBar+"%")

                //$('#progress_bar').attr("style", "width:"+progressBar+"%")
                //if(progressBar < 1){
                //    progressBar = 110;
                //}
                //console.log(progressBar)
                //progressBar = progressBar - 10;

            },1000);

        })

        function setLocalization(chassi_device)
        {

            // Map
            $.ajax({
                url: "{{url('monitoring/map')}}/"+chassi_device,
                type: 'GET',
                success: function(data) {

                    if(data.status == "success"){

                        position = data[0];
                        mymap.removeLayer(marker)
                        marker = L.marker([position.lat, position.lng]).addTo(mymap);
                        mymap.panTo(new L.LatLng(position.lat, position.lng));
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Dispositivo não encontrado',
                            showConfirmButton: true,
                            timer: 2500
                        })
                    }

                }
            });
        }

    </script>
@endsection