@extends('layouts.app')

@section('content')

<div class="kt-portlet">
    <div class="kt-portlet kt-portlet--mobile">

        <!-- HEADER -->
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand {{$icon}}"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Histórico de {{$title}}
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
                        <th scope="col">Nº</th>
                        <th scope="col">Usuário Cadastro</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data de Cadastro</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contract as $contract)
                    <tr id="_tr_contract_history_{{$contract->id}}">
                        <td>{{$contract->id}}</td>
                        <td>{{$contract->user->name}}</td>
                        <td>{{$contract->customer->name}}</td>
                        <td>{{date_format($contract->created_at, "d/m/Y")}}</td>
                        <td>
                            <div class="pull-right">
                                <a href="{{ url('contracts/show') }}/{{$contract->id}}" class="btn btn-primary">Detalhes</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
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