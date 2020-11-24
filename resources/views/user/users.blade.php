@extends('layouts.index')

@section('content')

<table class="table">
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
                    <form action="{{route('edit.user', $user->id)}}" method="GET">
                        <td>
                            <p data-placement="top" data-toggle="tooltip" title="Update"><button class="btn btn-success btn-xs"><span class="fa fa-pencil fa-fw"></span></button></p>
                        </td>
                    </form>
                    <form action="{{route('destroy', $user->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{method_field('DELETE')}}
                        <td>
                            <p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs"><span class="fa fa-fw fa-trash"></span></button></p>
                        </td>
                    </form>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
@endsection