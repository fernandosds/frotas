<div class="modal-body" style="overflow: auto; width: 640px">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nº Série</th>
                <th scope="col">Tecnologia</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devices as $device)
            <tr id="_tr_device_{{$device->id}}">
                <td>{{$device->id}}</td>
                <td>{{$device->model}}</td>
                <td>{{$device->technologie->type}}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>