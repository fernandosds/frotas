<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Telefone</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contacts as $contact)
        <tr id="_tr_user_{{$contact->id}}">
            <td>{{$contact->phone}}</td>
            <td>{{$contact->email}}</td>
            <td></td>
            <td>
                <div class="pull-right">
                    <button type="button" class="btn btn-sm  btn-outline-danger btn-delete-contact" data-id="{{$contact->id}}">
                        <span class="fa fa-fw fa-trash"></span>
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>