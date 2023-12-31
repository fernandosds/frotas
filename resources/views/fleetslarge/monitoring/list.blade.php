<div class="modal-body">
    <table id="gridDatatable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Dispositivo</th>
                <th class="hidden">Data recebimento</th>
                <th>Data recebimento</th>
                <th class="hidden">Data GPS</th>
                <th>Data GPS</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th class="hidden">Angulo</th>
                <th>Qt. Satélite</th>
                <th class="hidden">Sinal</th>
                <th class="hidden">Tensão</th>
                <th>Velocidade</th>
                <th>Endereço</th>
                <th>Ignição</th>
            </tr>
        </thead>
        <tbody>
            @foreach($positions as $position)
            <tr>
                <td>{{ $position['id_dispositivo'] }}</td>
                <td><span style="display:none">{{$position['data_recebimento']}}</span>{{\Carbon\Carbon::parse($position['data_recebimento'])->format('d/m/Y H:i:s')}}</td>
                <td class="hidden">{{ \Carbon\Carbon::parse($position['data_recebimento'])->format('d/m/Y H:i:s') }}</td>
                <td><span style="display:none">{{$position['data_gps']}}</span>{{\Carbon\Carbon::parse($position['data_gps'])->format('d/m/Y H:i:s')}}</td>
                <td class="hidden">{{ \Carbon\Carbon::parse($position['data_gps'])->format('d/m/Y H:i:s') }}</td>
                <td>{{ $position['latitude'] }}</td>
                <td>{{ $position['longitude'] }}</td>
                <td class="hidden">{{ $position['angulo'] }}</td>
                <td>{{ $position['qt_satelite'] }}</td>
                <td class="hidden">{{ $position['sinal'] }}</td>
                <td class="hidden">{{ $position['tensao'] }}</td>
                <td>{{ $position['velocidade'] }} km/h</td>
                <td>{{ $position['endereco'] }}</td>
                <td>{{ $position['ignicao'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        var date = $.datepicker.formatDate('dd_mm_yy', new Date());
        var dataTable = $('#gridDatatable').DataTable({
            dom: "<'row'<'col-md-4'l><'col-md-8'Bf>>" +
                "<'row'<'col-md-6'><'col-md-6'>>" +
                "<'row'<'col-md-12't>><'row'<'col-md-12'ip>>",
                "order": [[1, "desc"]],
            buttons: [{
                    extend: 'pdf',
                    title: 'SAT Company :: Relatorio de Posicoes_' + date,
                    exportOptions: {
                        columns: [0, 2, 4, 5, 6, 7, 9, 10, 11, 12, 13]
                    }
                },
                {
                    extend: 'excel',
                    title: 'SAT Company :: Relatorio de Posicoes_' + date,
                    exportOptions: {
                        columns: [0, 2, 4, 5, 6, 7, 9, 10, 11, 12, 13]
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
            columnDefs: [{
                targets: [2],
                orderData: [0, 1]
            }, {
                targets: [2],
                orderData: [1, 0]
            }, {
                targets: [4],
                orderData: [4, 0]
            }],

        });
    });
</script>
