
<div class="modal-body">

    @if( $return['status'] == "success" )

    <table class="table table-striped">
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
                    <td>{{ $position["id_hospedeiro"] }}</td>
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
                    <td>{{ $position["rssi_hospedeiro"] }}</td>
                    <td></td>
                </tr>
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

<!--
"DATA_GPS_HOSPEDE" => "11/02/2021 10:58:21"
      "atualizado" => "2"
      "id" => "99a00105"
      "id_hospedeiro" => "99203480"
      "latitude_hospede" => "-23.06487"
      "latitude_hospedeiro" => "-23.06487"
      "longitude_hospede" => "-46.64619"
      "longitude_hospedeiro" => "-46.64619"
      "nivel_bateria" => "50.00%"
      "rssi_hospedeiro" => "118"

-->