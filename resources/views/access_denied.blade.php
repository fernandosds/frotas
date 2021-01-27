@extends('layouts.app')

@section('content')

    <div class="row justify-content-md-center">
        <div class="kt-portlet col col-lg-4">
            <div class="kt-portlet kt-portlet--mobile">

                <!-- CONTENT -->
                <div class="kt-portlet__body center">

                    <h3>
                    <span class="fa-stack fa-lg center">
                      <i class="fa fa-ban text-danger"></i>
                    </span>

                    Acesso Negado!</h3>

                    {{Auth::user()->name}}, seu usuário não possui privilégios suficientes para acessar o recurso solicitado.<br /><br />

                    Em caso de dúvidas entre em contato com: <br /><br />

                    @foreach($managements as $management)

                        <b>{{$management->name}} <br /><small>{{$management->email}}</small></b><br />

                    @endforeach

                </div>

            </div>
        </div>
    </div>

@endsection
