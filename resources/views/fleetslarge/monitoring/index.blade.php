@extends('layouts.app_map')

@section("styles")
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />


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

    .hidden, .load {
        display: none;
    }

    .modal .modal-content {
        width: 1000px;
    }

    .streetViewBtn{
        position: absolute;
        top: 265px;
        left: 10px;
        background-color: #eee;
        z-index: 440;
        border: 2px solid rgba(0, 0, 0, 0.2);
        background-clip: padding-box;
        border-radius: 5px;
        color: #fdbf2d;
        font-size: 20px;
        transition: all 0.5s ease;
        width: 44px;
        height: 44px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .streetViewBtn:hover{
        font-size: 28px;
        text-shadow: 1px 1px 5px black;
    }

    .btnSearchRoute{
        background-color: #eee;
        background-clip: padding-box;
        border-radius: 5px;
        font-size: 16px !important;
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        position: absolute;
        bottom: 1px;
    }

    .noBorder{
        border:none !important;
    }

    .inputError{
        border: 1px solid rgb(255, 0, 0);
    }

    .dis{pointer-events:none}

    path.leaflet-interactive.animate {
        stroke-dasharray: 1920;
        stroke-dashoffset: 1920;
        animation: dash 20s linear 3s forwards;
    }

@keyframes dash {
    to {
        stroke-dashoffset: 0;
    }
}
</style>
@endsection

@section('content')

<div id="pairing-alert"></div>

<div class="kt-portlet kt-portlet--mobile">

    <div class="kt-section" id="div-progress-bar">
        <div class="progress">
            <div class="" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
        </div>
    </div>

    <!-- HEADER -->
    <div class="row" style="width: 99%">
        <div class="col-sm-11">
            <div class="row div-device-status">
                <div class="col-sm-1 col-3">
                    <i class="fa fa-car-alt"></i> <label for="">Placa</label><br />
                    <b for="" id="placa">---</b>
                </div>

                <div class="col-sm-1 col-3">
                    <i class="fa fa-key"></i> <label for="">Ignição</label><br />
                    <b for="" id="lp_ignicao">---</b>
                </div>


                <div class="col-sm-1 col-6">
                    <i class="fa fa-car-alt"></i> <label for="">Velocidade</label><br />
                    <b for="" id="lp_velocidade">---</b>
                </div>


                <div class="col-sm-2 col-6">
                    <i class="fa fa-car-side"></i> <label for="">Chassis</label><br />
                    <b for="" id="chassis">---</b>
                </div>

                <div class="col-sm-1 col-6">
                    <i class="fa fa-car-side" id="icon-nivel-bateria"></i> <label for=""> Modelo</label><br />
                    <b for="" id="modelo_veiculo">---</b>
                </div>

                <div class="col-sm-1 col-6">
                    <i class="fa  fa-car-alt"></i> <label for="">Categoria</label><br />
                    <b for="" id="categoria_veiculo">---</b>
                </div>

                <div class="col-sm-2 col-6">
                    <i class="fa fa-rss"></i> <label for="">Última Transmissão</label><br />
                    <b for="" id="lp_ultima_transmissao">---</b>
                </div>

                <div class="col-sm-3 col-6">
                    <i class="fa fa-search"></i> <label for="">Filtrar Transmissões</label><br />
                    <div class="row noBorder">
                        <div class="col-sm-5 noBorder">
                            <label for="">Data Inicial</label>
                            <input class="form-control date_route" type="date" value="{{Carbon\Carbon::create()}}" id="start_date_route">
                        </div>
                        <div class="col-sm-5 noBorder">
                            <label for="">Data Final</label>
                            <input class="form-control date_route" type="date" value="{{Carbon\Carbon::create()}}" id="last_date_route">
                        </div>

                        <div class="col-sm-2 noBorder">
                            <div class="btnSearchRoute noBorder">
                                <i class="fa fa-search find"></i>
                                <i class="fas fa-spinner fa-spin load"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-1 col-12 div-btn-start">
            <div class="form-row align-items-center" style="float:right;">
                <div class="col-sm-2 col-3 my-1 right">
                    <a href="{{route('fleetslarges.index')}}" class="btn btn-warning mb-2" id="btn-start">Voltar</a>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <hr />
            <button type="button" class="btn btn-link modal-grid" data-toggle="modal" data-target="#modalGrid" data-backdrop="static" data-keyboard="false"><i class="fa fa-table"></i> Histórico de Posições</button>
            <div id="last-address"></div>
        </div>
    </div>

</div>
<div class="streetViewBtn"><i class="fas fa-street-view"></i></div>
<div id="mapid" class="mapid" style="width: 100%; height: 800px;float:left;"></div>

<div class="modal fade bd-print-grid" id="modal-grid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Imprimir Grid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        De: <br />
                        <input class="form-control" type="date" min="1" max="72" id="input-date-from" value="">
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        Até: <br />
                        <input class="form-control" type="date" min="1" max="72" id="input-date-to" value="">
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <br /><b>Atenção</b> Intervalo máximo de 5 dias<br />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-block btn-primary" id="btn-print-grid"><i class="fa fa-print"></i> Imprimir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="modal-content">
            <div class="center"><i class="fa fa-pulse fa-spinner fa-5x"></i><br />Aguarde... </div>
        </div>
    </div>
</div>

@include('fleetslarge.monitoring.modalGrid')

@endsection

@section('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://unpkg.com/esri-leaflet@2.5.3/dist/esri-leaflet.js" integrity="sha512-K0Vddb4QdnVOAuPJBHkgrua+/A9Moyv8AQEWi0xndQ+fqbRfAFd47z4A9u1AW/spLO0gEaiE1z98PK1gl5mC5Q==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>


<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" integrity="" crossorigin=""></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" integrity="" crossorigin=""></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js" integrity="" crossorigin=""></script>


<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chroma-js/2.1.0/chroma.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.polyline.snakeanim@0.2.0/L.Polyline.SnakeAnim.min.js"></script>
<script>
    /**
     * Pega o chassi atual passado por parâmetro
     */
    chassi_url = "{{$chassi}}";
    var modelo = "";
    searchRouteBlock = true;

    var loading = '<i class="fa fa-spinner fa-pulse"></i>';
    $("#placa").html(loading);
    $("#lp_ignicao").html(loading);
    $("#lp_velocidade").html(loading);
    $("#chassis").html(loading);
    $("#modelo_veiculo").html(loading);
    $('#categoria_veiculo').html(loading);
    $('#lp_ultima_transmissao').html(loading);

    var heat = {};
    var marker = {};
    var marker_truck = {};
    var marker_event = {};
    var circle = {};
    var minutes = 10;
    var chassi_device = '';

    /* Icons */
    var boxIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-box-64.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    var eventIcon = new L.Icon({
        iconUrl: '{{url("markers/marker-event-64.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });
    var truckIcon = new L.Icon({
        iconUrl: '{{url("markers/black_icon.png")}}',
        iconSize: [64, 64],
        iconAnchor: [35, 62],
        popupAnchor: [1, -34],
    });

    var mymap = L.map('mapid').setView([-25.675470, -48.461930], 15);

    var baseLayers = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGF1bG9zZXJnaW9waHAiLCJhIjoiY2trZnRkeXduMDRwdzJucXlwZXh3bmtvZCJ9.TaVN_xJSnhd64wOkK69nyg', {
        attribution: '&copy; <a href="https://www.satcompany.com.br">SAT Company</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);

    /**
     * Rastrea isca automaticamente
     */
    $(document).ready(function() {
        start()
    })

    /**
     * Rastrea isca
     */
    function start() {

        chassi_device = chassi_url;

        if (lastPosition(chassi_device)) {

            loadIconsDeviceStatus(chassi_device);

            // Progress bar
            $('#div-progress-bar').show();
            progressBar = 100;
            setInterval(function() {
                $('#progress_bar').addClass('progress-bar progress-bar-striped');
                if (progressBar < 11) {
                    $('#progress_bar').removeClass('progress-bar progress-bar-striped');
                    $('#progress_bar').addClass("progress-bar progress-bar-striped bg-danger");
                }
                if (progressBar == 0) {
                    $('#progress_bar').removeClass('progress-bar progress-bar-striped bg-danger');
                    $('#progress_bar').addClass('progress-bar progress-bar-striped');
                    progressBar = 100;

                    lastPosition(chassi_device);
                    loadIconsDeviceStatus(chassi_device);

                } else {
                    progressBar = progressBar - 1;
                }
                $('#progress_bar').attr("style", "width:" + progressBar + "%")

            }, 1000);
        }
    }

    let streetPositionLink = '';

    /**
     * Marker - Última posição válida
     */
    function lastPosition(chassi_device) {
        $.ajax({
            url: "{{url('')}}/fleetslarges/monitoring/last-position/" + chassi_device,
            type: 'GET',
            success: function(data) {
                searchRouteBlock = false;
                if (data.lp_ignicao == "1") {
                    $("#lp_ignicao").css({
                        "color": "green"
                    });
                } else {
                    $("#lp_ignicao").css({
                        "color": "red"
                    });
                }

                $("#placa").html(data.placa);
                $("#lp_ignicao").html(data.lp_ignicao != "1" ? "OFF" : "ON");
                $("#lp_velocidade").html(data.lp_velocidade + " km/h");
                $("#chassis").html(data.chassis);
                $("#modelo_veiculo").html(data.modelo_veiculo);
                $("#categoria_veiculo").html(data.categoria_veiculo);
                $("#lp_ultima_transmissao").html(data.lp_ultima_transmissao.replace(/(\d*)-(\d*)-(\d*) (\d*):(\d*):(\d*).*/, '$3/$2/$1 $4:$5:$6'));
                $(".modelo").html(data.modelo);

                modelo = data.modelo;

                if (mymap.hasLayer(marker)) {
                    mymap.removeLayer(marker);
                }
                if (mymap.hasLayer(circle)) {
                    mymap.removeLayer(circle);
                }
                /**
                if (mymap.hasLayer(marker_truck)) {
                    mymap.removeLayer(marker_truck);
                }
                 */
                if (mymap.hasLayer(marker_event)) {
                    mymap.removeLayer(marker_event);
                }

                streetPositionLink = 'http://maps.google.com/maps?q=&cbll=' + data.lp_latitude + ',' + data.lp_longitude +'&layer=c';

                mymap.panTo(new L.LatLng(data.lp_latitude, data.lp_longitude));

                marker = L.marker([data.lp_latitude, data.lp_longitude], {
                    icon: truckIcon
                }).addTo(mymap);

                $('#last-address').html(
                    '<b>Último endereço válido:</b> ' + data.endereco
                );
                Swal.close()
            }
        });
        return true;
    }

    var searchRouteGroup = L.featureGroup().addTo(mymap);
    $('.btnSearchRoute').click(function(){

        $('.date_route').removeClass('inputError');
        if(searchRouteBlock){
            return;
        }
        if($("#start_date_route").val() == '' || $("#last_date_route").val() == ''){
            if($("#start_date_route").val() == ''){
                $("#start_date_route").addClass('inputError');
            }
            if($("#last_date_route").val() == ''){
                $("#last_date_route").addClass('inputError');
            }
            return;
        }

        $(".btnSearchRoute").addClass("dis");
        $('.find').hide();
        $('.load').show();

        const payload = {
            "_token": "{{ csrf_token() }}",
            "start_date": $("#start_date_route").val(),
            "last_date": $("#last_date_route").val(),
            "chassis": chassi_url,
            "modelo": modelo,
        }
         $.ajax({
            url: "{{route('fleetslarges.monitoring.routes')}}",
            type: 'POST',
            data:payload,
            success: function (data) {
                searchRouteGroup.clearLayers();
                const points = data.positions;

                const colors = chroma.scale(["#ff0800", "#03ff00"]).mode("lch").colors(points.length);
                let yourWaypoints = [];
                let aux = 0;
                points.map((point) =>{
                    if(!isNaN(point.latitude) && !isNaN(point.longitude)){
                        const pointB = new L.LatLng(point.latitude, point.longitude);
                        yourWaypoints.push(pointB);
                        L.circleMarker([point.latitude, point.longitude], {
                            radius: 15,
                            fillOpacity: 0.5,
                            color: colors[aux],
                        }).bindPopup('<strong><br>'+ aux+' - Data da posição:</strong> ' + moment(point.data_gps).format('DD/MM/YYYY HH:mm:ss'))
                        .on('mouseover', function (e) {
                            e.target.setStyle({
                                radius: 20

                            });

                            this.openPopup();

                        })
                        .on('mouseout', function (e) {
                            e.target.setStyle({
                                radius: 15

                            });
                            this.closePopup();
                        }).addTo(searchRouteGroup);

                        aux++;
                    }

                });
                var firstpolyline = new L.polyline(yourWaypoints, {
                    color: 'red',
                    weight: 3,
                    opacity: 0.5,
                    smoothFactor: 1,
                    snakingSpeed: 200
                }).addTo(searchRouteGroup).snakeIn();
            },
            complete:function(){
                $('.find').show();
                $('.load').hide();
                $(".btnSearchRoute").removeClass("dis");
            }
        });

    });


    /**
     * Carrega endereço do grid
     */
    $("#modal-content").on("click", ".btn-see-address", function() {
        var grid_lat = $(this).data('lat');
        var grid_lng = $(this).data('lng');
        var cont = $(this).data('cont');

        $('#span-address-' + cont).html('<i class="fa fa-spinner fa-pulse"></i> Carregando endereço...')

        $.ajax({
            type: 'GET',
            url: '{{url("monitoring/get-address")}}/' + grid_lat + '/' + grid_lng,
            success: function(response) {
                $('#span-address-' + cont).html(response)
            }
        });

    })

    /**
     * Ícones - Status
     */
    function loadIconsDeviceStatus(chassi_device) {
        var loading = '<i class="fa fa-spinner fa-pulse"></i>';
        $("#placa").html(loading);
        $("#lp_ignicao").html(loading);
        $("#lp_velocidade").html(loading);
        $("#chassis").html(loading);
        $("#modelo_veiculo").html(loading);
        $('#lp_ultima_transmissao').html(loading);
        $('#categoria_veiculo').html(loading);
    }

    /**
     * Limpa ícones
     */
    function clearIcons() {
        $("#placa").html('---');
        $("#lp_ignicao").html('---');
        $("#lp_velocidade").html('---');
        $("#chassis").html('---');
        $("#modelo_veiculo").html('---');
        $('#lp_ultima_transmissao').html('---');
        $('#categoria_veiculo').html('---');
    }

    $(".streetViewBtn").click(function(){
        window.open(streetPositionLink, '_blank');
    });


    $('#btn-grid').click(function() {
        var chassis = chassi_url;
        $.ajax({
            type: 'POST',
            url: "{{route('fleetslarges.monitoring.grid')}}",
            async: true,
            data: {
                "_token": "{{ csrf_token() }}",
                "modelo": modelo,
                "chassis": chassis,
                "first_date": $('#first_date').val(),
                "last_date": $('#last_date').val()
            },
            success: function(response) {
                $('#list_grid').html(response);
            },
            error: function(error) {
                if (error.responseJSON.status == "internal_error") {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                        showConfirmButton: true,
                        timer: 10000
                    })

                } else if (error.responseJSON.status == "validation_error") {
                    var items = error.responseJSON.errors;
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'Os seguintes erros foram encontrados: ' + items,
                        footer: ' '
                    })

                } else {
                    var items = error.responseJSON.errors;
                    var errors = $.map(items, function(i) {
                        return i.join('<br />');
                    });
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        html: 'Os seguintes erros foram encontrados: ' + errors,
                        footer: ' '
                    })
                }

            }
        });
    });
</script>
@endsection
