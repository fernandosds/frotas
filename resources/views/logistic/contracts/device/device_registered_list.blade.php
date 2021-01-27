<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tecnologia</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devices as $device)
        <tr id="_tr_device_{{$device->id}}" >
            <td>{{$device->id}}</td>
            <td>{{$device->model}}</td>
            <td>{{$device->technologie_id}}</td>
            <td>
                <div class="pull-right">
                    
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>