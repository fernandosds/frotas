@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" />
<style>

</style>
@endsection

@section('content')

<div class="kt-section " id="div-progress-bar-fleetlarge">
    <br />
    <div class="progress progress">
        <div class="" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
            id="progress_bar_fleetlarge"></div>
        <p id="contador"></p>
    </div>
</div>

<div class="row" id="div-grid-vehicle">
    <div class="col-md-6" id="#">
        <div class="card text-white col-md-12 bg-primary" id="#">
            <div class="card-body">
                <br />
                <h3 class="card-title display-4"> <span id="aInstalacao"></span></h3>
                <p class="card-text h5"><span>AGUARDANDO INSTALAÇÕES</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="#">
        <div class="card text-white col-md-12 bg-primary">
            <div class="card-body">
                <br />
                <h3 class="card-title display-4"> <span id="eInstalacao"></span></h3>
                <p class="card-text h5"><span>INSTALAÇÕES EFETUADAS</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="#">
        <div class="card text-white col-md-12 bg-primary">
            <div class="card-body">
                <br />
                <h3 class="card-title display-4"> <span id="tpInstalacao"></span></h3>
                <p class="card-text h5"><span> TOTAL INSTALAÇÕES</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="#">
        <div class="card text-white col-md-12 bg-primary" id="#">
            <div class="card-body">
                <br />
                <h3 class="card-title display-4"> <span id="nullInstalacao"></span></h3>
                <p class="card-text h5"><span>INSTALAÇÕES SEM MENSAGEM</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="#">
        <div class="card text-white col-md-12 bg-primary" id="#">
            <div class="card-body">
                <br />
                <h3 class="card-title display-4"> <span id="tmatecnico"></span></h3>
                <p class="card-text h5"><span>TEMPO MÉDIO PARA ACIONAR TÉCNICO</p>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="#">
        <div class="card text-white col-md-12 bg-primary" id="#">
            <div class="card-body">
                <br />
                <h1 class="card-title display-4"> <span id="tmiservico"><span></h1>
                <p class="card-text h5"><span>TEMPO MÉDIO DESLOCAMENTO</p>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script>
resetGrid()

function resetGrid() {
    // Progress bar
    $('#div-progress-bar-fleetlarge').show();
    progressBar = 0;
    setInterval(function() {
        $('#progress_bar_fleetlarge').addClass('progress-bar kt-bg-primary');
        if (progressBar < 11) {
            $('#progress_bar_fleetlarge').removeClass('progress-bar kt-bg-primary');
            $('#progress_bar_fleetlarge').addClass("progress-bar kt-bg-danger");
        }
        if (progressBar == 0) {
            $('#progress_bar_fleetlarge').removeClass('progress-bar kt-bg-danger');
            $('#progress_bar_fleetlarge').addClass('progress-bar kt-bg-primary');
            reloadValue()
            progressBar = 100;
        } else {
            progressBar = progressBar - 1;
            document.getElementById("contador").innerHTML = progressBar;
        }
        $('#progress_bar_fleetlarge').attr("style", "width:" + progressBar + "%")
    }, 1000);
}

function reloadValue() {
    $.ajax({
        url: "{{ route('fleetslarges.dadosDashSantander')}}",
        type: 'GET',
        success: function(data) {
            //console.log(data);
            //alert('Sucesso localizou url');
            $("#aInstalacao").html(data.aInstalacao);
            $("#eInstalacao").html(data.eInstalacao);
            $("#tpInstalacao").html(data.tpInstalacao);
            $("#nullInstalacao").html(data.nullInstalacao);
            $("#tmatecnico").html(data.tmatecnico);
            $("#tmiservico").html(data.tmiservico);
        },
        error: function(data) {
            console.log(data);
            Swal.fire({
                type: 'error',
                title: 'Não foi possível carregar página, sair e entrar no sistema novamente !',
                text: data.message,
                showConfirmButton: true,
                timer: 10000
            })
        }
    });
}
</script>

@endsection
