<table class="table table-hover table-dark">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Tecnologia</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Custo Unit.</th>
            <th scope="col">Custo Total.</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devices as $key => $val)
        <tr id="_tr_device_{{$key}}">
            <td>{{$key + 1}}</td>
            <td>{{$val['technologie_id']}}</td>
            <td>{{$val['quantity']}}</td>
            <td>R$ {{number_format($val['value'],2,",",".")}}</td>
            <td>R$ {{number_format($val['total'],2,",",".")}}</td>
            <td></td>
            <td>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-danger btn-delete-device" data-id="{{$key}}">
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