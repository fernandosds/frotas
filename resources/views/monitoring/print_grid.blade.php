<style>
    .demo {
        border:1px solid #C0C0C0;
        border-collapse:collapse;
        padding:5px;
        width: 100%
    }
    .demo th {
        border:1px solid #C0C0C0;
        padding:5px;
        background:#F0F0F0;
    }
    .demo td {
        border:1px solid #C0C0C0;
        padding:5px;
    }
    .head{
        font-family: Arial, Helvetica, sans-serif;
        padding: 5px;
        border-bottom: 1px solid #ccc;
    }
</style>

@if( $return['status'] == "success" )

    <div class="head">
        Impresso por: {{Auth::user()->name}} em {{date('Y/m/d')}}  - www.satcompany.com.br <hr />
    </div>

    <table class="demo">
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
                <td>{{ $position["rssi_hospedeiro"] }}</td>
                <td>{{ $position["endereco"] }}</td>
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


<script>

        window.print();

</script>