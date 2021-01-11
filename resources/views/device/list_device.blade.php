<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Modelo</th>
            <th scope="col">Tecnologia</th>
            <th scope="col">Preço</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devices as $key => $val)
        <tr id="_tr_device_{{$key}}">
            <td>{{$key + 1}}</td>
            <td>{{$val['device']}}</td>
            <td>{{$val['tecnology']}}</td>
            <td>{{$val['price']}}</td>
            <td></td>
            <td>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-device" data-id="{{$key}}">
                        <span class="fa fa-fw fa-trash"></span>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#label-total').html('Valor Total - R$: {{ number_format($total, 2, ",", "." ) }}')
</script>