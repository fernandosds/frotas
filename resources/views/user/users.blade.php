@extends('layouts.index')

@section('content')


<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">NAME</th>
            <th scope="col">TYPE</th>
            <th scope="col">STATUS</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($users as $user) : ?>
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->type}}</td>
                <td>{{$user->status}}</td>
                <td>
                    <div class="pull-right">
                        <a href="{{route('edit.user', $user->id)}}" class="btn btn-sm btn-outline-info"><span class="fa fa-fw fa-edit"></span> Editar</a>
                        <a href="{{route('destroy', $user->id)}}" class="btn btn-sm  btn-outline-danger"><span class="fa fa-fw fa-trash"></span> Deletar</a>
                    </div>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
@endsection