@extends('layouts.app')

@section('content')

    <!-- CONTENT -->
    <div class="kt-portlet__body">

        <h3>Acesso Negado!</h3>
        {{Auth::user()->name}}, seu usuário não possui privilégios suficientes para acessar o recurso solicitado.

    </div>

@endsection
