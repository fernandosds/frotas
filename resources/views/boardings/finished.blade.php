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
                    {{$title}}
                </h3>
            </div>
            @if (Auth::user()->email != 'admin@satcompany.com.br')
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{url('boardings/new')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i> Novo
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="kt-portlet__body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ísca</th>
                        <th scope="col">Transportadora</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Data</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tempo retante</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($boardings as $boarding)
                    <tr id="_tr_user_{{$boarding->id}}">
                        <th scope="row">{{$boarding->id}}</th>
                        <td>{{$boarding->device->model}}</td>
                        <td>{{$boarding->transporter}}</td>
                        <td>{{$boarding->board}}</td>
                        <td>{{date_format($boarding->created_at, "d/m/Y")}}</td>
                        <td id>
                            @if ($boarding->active)
                            <i class="fa fa-pulse fa-asterisk text-success"></i> Em andamento
                            @else
                            <i class="fa fa-times text-warning"></i> Encerrado
                            @endif
                        </td>
                        <td>{{ timeLeft($boarding->finished_at) }}</td>
                        <td>
                            <div class="pull-right">

                                @if ($boarding->active)
                                <button type="button" class="btn btn-sm  btn-warning btn-finish-boarding" data-id="{{$boarding->id}}">
                                    <span class="fa fa-times"></span> Encerrar
                                </button>
                                <a href="{{url('monitoring')}}/{{$boarding->device->model}}" class="btn btn-sm btn-success">
                                    <i class="fa fa-map-marker"></i> Monitorar
                                </a>
                                @endif

                                <a href="{{url('boardings/view')}}/{{$boarding->id}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Detalhes</a>

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
    // Deletar
    $('.btn-finish-boarding').click(function() {


        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-warning',
                cancelButton: 'btn btn-primary'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Tem certeza?',
            text: "Confirma encerrar embarque?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-times"></i> Encerrar!',
            cancelButtonText: '<i class="fa fa-arrow-left"></i> Manter!',
            reverseButtons: true
        }).then((result) => {

            if (result.value) {

                $.ajax({
                    type: 'GET',
                    url: '{{url("boardings/finish")}}/' + $(this).data('id'),
                    success: function(response) {

                        if (response.status == "success") {
                            Swal.fire({
                                type: 'success',
                                title: 'Ok',
                                text: 'Embarque encerrado com sucesso',
                                showConfirmButton: true,
                                timer: 10000
                            })
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Erro ao tentar encerrar embarque! ' + response.message,
                                showConfirmButton: true,
                                timer: 10000
                            })
                        }

                    }
                });

            }
        })
    })
</script>
@endsection
