@extends('layouts.app')

@section('content')

    <!-- CONTENT -->
    <div class="kt-portlet__body">
        <h3>
        <span class="fa-stack fa-lg center">
          <i class="fa fa-ban text-danger"></i>
        </span>

        Acesso Negado!</h3>
        {{Auth::user()->name}}, seu usuário não possui privilégios suficientes para acessar o recurso solicitado.agora

    </div>

@endsection
