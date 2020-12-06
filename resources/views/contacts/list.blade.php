<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">CPF/CNPJ</th>
            <th scope="col">Tipo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr id="_tr_user_{{$customer->id}}">
            <th scope="row">{{$customer->id}}</th>
            <td>{{$customer->name}}</td>
            <td>{{$customer->cpf_cnpj}}</td>
            <td>{{$customer->type}}</td>
            <td>
                <div class="pull-right">
                    <a href="{{url('customers/edit')}}/{{$customer->id}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                    <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-customer" data-id="{{$customer->id}}">
                        <span class="fa fa-fw fa-trash"></span> Deletar
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>