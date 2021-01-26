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
                    {{$title}} Concluídos
                </h3>
            </div>

            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="kt-portlet__body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nº Contrato</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Data de criação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics as $logistic)
                    <tr id="_tr_user_{{$logistic->id}}">
                        <th scope="row">{{$logistic->id}}</th>
                        <td>{{$logistic->customer->name}}</td>
                        <td>{{ date_format($logistic->created_at, "d/m/Y") }}</td>
                        <td>
                            <div class="pull-right">                                
                                <a href="{{url('logistics/contracts/show')}}/{{$logistic->id}}" class="btn btn-sm btn-info"><span class="fa fa-eye"></span> Detalhes</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">

            </div>

        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
  
</script>
@endsection