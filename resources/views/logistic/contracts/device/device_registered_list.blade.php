<div class="modal-body" style="overflow: auto; width: 640px">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Nº Série</th>
                <th scope="col">Tipo</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
            <tr id="_tr_device_{{$device->id}}">
                <td>{{$loop->iteration}}</td>
                <td>{{$device->model}}</td>
                <td>{{$device->technologie->type ?? 'Disp. Movel'}}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
