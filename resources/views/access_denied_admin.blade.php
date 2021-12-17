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

                    Acesso Negado!
                </h3>

                O usuário admin só tem permissão para visualizar todos os embarques.<br /><br />

                Para usar este recurso, entre com outro usuário! <br /><br />

            </div>

        </div>
    </div>
</div>

@endsection
