@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <!--begin::Portlet-->
        <div class="kt-portlet kt-portlet--mobile">

            <!-- HEADER -->
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-menu__link-icon"><i class="fa fa-solid fa-wrench"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        <span class="kt-menu__link-text">&nbsp; Lista de iscas</span>
                    </h3>
                </div>

                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <a href="{{url('stocks/new')}}">
                            <button type="button" class="btn btn-primary btn-pill" title="Importar planilha"><i class="fa fa-file-excel"></i>
                                <span> Cadastrar Isca</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <br />
            <div class="kt-portlet kt-portlet--mobile" id="kt_content">

                <div class="col-md-12">
                    <br />
                    <table id="stock" class="display" style="width:50%">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">Id</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Tecnologia</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devices as $device)
                            <tr id="_tr_device_{{$device->id}}">
                                <td>{{$device->id}}</td>
                                <td>{{$device->model}}</td>
                                <td>@if($device->technologie) {{$device->technologie->type ?? ''}} @endif</td>
                                <td>{{$device->customer->name ?? ''}}</td>
                                @if($device->status == 'disponivel')
                                <td class="{{$device->status == 'disponivel' ? 'text-success' : ''}}">
                                    <b>{{'Disponivel'}}</b>
                                </td>
                                @endif
                                @if($device->status == 'indisponivel')
                                <td style="color: {{$device->status == 'indisponivel' ? '#6C7293' : ''}}">
                                    <b>{{'Indisponivel'}}</b>
                                </td>
                                @endif
                                @if($device->status == 'em andamento')
                                <td class="{{$device->status == 'em andamento' ? 'text-warning' : ''}}">
                                    <b>{{'Em andamento'}}</b>
                                </td>
                                @endif
                                @if($device->status == null)
                                <td style="color: {{$device->status == null ? '#f74747' : ''}}">
                                    <b>{{'A definir'}}</b>
                                </td>
                                @endif
                                <td style="width: 200px;">
                                    <div class="pull-left">
                                        <!-- @if($device->status == null)
                                                <a href="{{url('stocks/edit')}}/{{$device->id}}">
                                                    <button type="button"
                                                        class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle"
                                                        title="Editar isca"><span class="fa fa-fw fa-edit"></span>
                                                    </button>
                                                </a>
                                            @endif -->
                                        @if($device->status == 'disponivel' || $device->status == null || Auth::user()->email == 'raphael.falcao@satcompany.com.br' || Auth::user()->email == 'jhonatas.claro@satcompany.com.br')
                                            <a href="{{url('stocks/edit')}}/{{$device->id}}">
                                                <button type="button" class="btn btn-outline-hover-brand  btn-sm btn-icon btn-circle" title="Editar isca"><span class="fa fa-fw fa-edit"></span>
                                                </button>
                                            </a>
                                            <button type="button" title="Excluir produto" id="device_id" data-id="{{$device->id}}" class="btn btn-outline-hover-danger btn-sm btn-icon btn-circle btn-delete-device">
                                                <span class="fa fa-fw fa-trash"></span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        columns = [0, 1, 2, 3, 4, 5];
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        $('#stock').DataTable({

            "search": {
                "search": ''
            },
            dom: "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Grid de Estoque_' + date,
                    exportOptions: {
                        columns: columns
                    },
                    orientation: 'portrait',
                },
                {
                    extend: 'excel',
                    title: 'SAT Company :: Grid de Estoque_' + date,
                    exportOptions: {
                        columns: columns
                    }
                }
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Nenhum registro encontrado",
                "sEmptyTable": "Nenhum registro disponível nesta tabela",
                "sInfo": "Mostrando registros de _START_ até _END_ de um total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros de 0 até 0 de um total de 0 registros",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Carregando...",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sLast": "Último",
                    "sNext": "Seguinte",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Ativar para ordenar a coluna de maneira ascendente",
                    "sSortDescending": ": Ativar para ordenar a coluna de maneira descendente"
                }
            },

        });

    });

    $('.btn-delete-device').click(function() {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Tem certeza que deseja excluir ?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Não, cancelar!',
            reverseButtons: true
        }).then((result) => {
            console.log(result);
            if (result.value) {
                var id = $(this).data('id');
                $('#_tr_device_' + id).hide()
                var url = "{{url('stocks/delete')}}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id,
                    },
                    success: function(response) {
                        Swal.fire({
                            type: 'success',
                            title: 'Registro excluido com sucesso',
                            showConfirmButton: true,
                            timer: 10000
                        })
                    }
                })
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {

            }
        })
    });
</script>
@endsection
