
<div class="modal-body">

    @if( $return['status'] == "success" )

    <table class="table table-striped" id="table-grid">
        <thead>
            <tr>
                <th>Data</th>
                <th>Atualizado</th>
                <th>Ísca</th>
                <th>Hospedeiro</th>
                <th>Nível da bateria</th>
                <th>RSSI Hospedeiro</th>
                <th>Endereço</th>
            </tr>
        </thead>
        <tbody>
        <?php $cont = 1; ?>
            @foreach($return['positions'] as $position)
                <tr>
                    <td>{{ $position["DATA_GPS_HOSPEDE"] }}</td>
                    <td>
                        @if( $position["atualizado"] == 0 )
                            <i class="fa fa-frown-o"></i> Inválido
                        @elseif( $position["atualizado"] == 1 )
                            <i class="fa fa-smile-o"></i> Válido
                        @else
                            <i class="fa fa-ofmeh-o"></i> Impreciso
                        @endif
                    </td>
                    <td>{{ $position["id"] }}</td>
                    <td>
                        @if( $position["id_hospedeiro"] == $return['pair_device'] )
                            <span class="text-success">{{ $position["id_hospedeiro"] }}</span> <i class="fa fa-check-circle text-success"></i>
                        @else
                            {{ $position["id_hospedeiro"] }}
                        @endif
                    </td>
                    <td>

                        @if( $position["nivel_bateria"] == "100.00%" )
                            <i class="text-green fa fa-battery-full"></i> {{ $position["nivel_bateria"] }}
                        @elseif( $position["nivel_bateria"] == "75.00%" )
                            <i class="text-warning fa fa-battery-three-quarters"></i> {{ $position["nivel_bateria"] }}
                        @elseif( $position["nivel_bateria"] == "50.00%" )
                            <i class="text-orange fa fa-battery-half"></i> {{ $position["nivel_bateria"] }}
                        @else
                            <i class="text-danger fa fa-battery-quarter"></i> {{ $position["nivel_bateria"] }}
                        @endif

                    </td>
                    <td>{{ $position["rssi_hospedeiro"] }}
                        <div class="progress progress-sm">


                            <?php
                                if( $position["rssi_hospedeiro"] < 50 ){
                                    $class = "danger";
                                }elseif( $position["rssi_hospedeiro"] < 75 ){
                                    $class = "warning";
                                }else{
                                    $class = "success";
                                }

                            ?>


                            <div class="progress-bar kt-bg-{{$class}}" role="progressbar" style="width: {{ $position["rssi_hospedeiro"] / 1.27 }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_bar"></div>
                        </div>
                    </td>


                    <td id="span-address-{{$cont}}">
                        <button type="button" class="btn btn-default btn-sm pull-rigth btn-see-address" data-cont={{$cont}} data-lat="{{$position["latitude_hospede"]}}" data-lng="{{$position["longitude_hospede"]}}">Ver Endereço</button>
                    </td>
                </tr>
                <?php $cont ++; ?>
            @endforeach
        </tbody>
    </table>

    @else
        <div class="center">
            <h4><i class="fa fa-exclamation-triangle"></i> Nenhum registro. </h4><hr />
            {{$return['message']}}
        </div>
    @endif

</div>

<script>


    $(document).ready(function () {
    $('#table-grid').DataTable({
        "aoColumns": [
            { "sType": "date" },
            null,
            null,
            null,
            null,
            null,
            null
        ],
        dom: 'Bfrtip',
        buttons: [
            'print'
        ],
        "aaSorting": [0, 'desc']
    });
    });
</script>
