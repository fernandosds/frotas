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
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
@endsection