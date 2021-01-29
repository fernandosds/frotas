@extends('layouts.app')

@section('content')

<div class="kt-portlet">
    <div class="kt-portlet kt-portlet--mobile">

        <!-- HEADER -->
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-contract"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Histórico de Contratos
                </h3>
            </div>

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">

                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuário Cadastro</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data de Cadastro</th>
                        <th scope="col">Tipo de Isca</th>
                        <th scope="col">Valor Contrato</th>
                    </tr>
                </thead>
                <tbody>
                 
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

</script>
@endsection