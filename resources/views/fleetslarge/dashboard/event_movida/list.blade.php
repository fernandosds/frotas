@if(isset($events))
<h4>Dados da Ocorrência</h4>
<div style="height: 250px; overflow-y: scroll;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Placa do Veículo</th>
                <th scope="col">Data</th>
                <th scope="col">Ocorrencia</th>
                <th scope="col">Status</th>
                <th scope="col">Data de Recuperação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td>{{$event['placa_veiculo']}}</td>
                <td>{{\Carbon\Carbon::parse($event['data'])->format('d/m/Y H:i:s')}}</td>
                <td>{{$event['ocorrencia']}}</td>
                <td>{{$event['status']}}</td>
                <td>{{\Carbon\Carbon::parse($event['data_recuperacao'])->format('d/m/Y H:i:s')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="row">
    <div class="form-group col-md-12">

    </div>
</div>
@endif
