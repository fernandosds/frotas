<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Telefone</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th><input type="text" id="phone" name="phone" /></th>
            <th><input type="text" id="email" name="email" /></th>
            <th>
            <button type="button" class="btn btn-sm btn-outline-info"> <span class="fa fa-fw fa-edit"></span> Cadastrar</button>
                
                <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-contact">
                    <span class="fa fa-fw fa-trash"></span> Deletar
                </button>
            </th>
        </tr>

    </tbody>
</table>


@section('scripts')
<script>
    /* Deletar */
    $('.btn-delete-contact').click(function() {
        var id = $(this).data('id');
        var url = "{{url('customers/contacts/delete')}}/" + id;
        ajax_delete(id, url)
    })
</script>
@endsection