<table class="table table-hover">
    <thead>
        <tr align="center">
            <th scope="col">Dados</th>
            <th scope="col">Descrição Atendimento</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devices as $device)
        <tr id="_tr_user_{{$device->id}}" class="tableListDeviceHistory">
        <tr>
            <td width="30%" align="left" class="bg-info">
                <b>Protocolo:</b> {{$device->id}} <br>
                <b>Usuário:</b> {{$device->user->name}} <br>
                <b>Cliente:</b> {{$device->customer->name}} <br>
                <b>Data:</b> {{$device->created_at->format('d/m/Y H:i:s')}}<br>
                <b>Dispositivo:</b> {{$device->device->model}} <br>
            </td>
            <td width="70%" class="p-3 mb-2 bg-secondary text-dark">
                {{$device->message}}
            </td>
        </tr>
        </tr>
        @endforeach
    </tbody>
</table>
