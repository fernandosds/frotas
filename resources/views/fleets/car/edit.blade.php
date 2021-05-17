@extends('layouts.app')

@section('styles')
<style>
    #btn-search-placa {
        margin-top: 7px;
    }
</style>
@endsection

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
                    {{$title}} <small>Novo</small>
                </h3>
            </div>
        </div>

        <form class="kt-form kt-form--label-right" id="form-create-car">

            <input type="hidden" name="id" id="id" value="{{ $car->id ?? '' }}" />

            @csrf
            <div class="kt-portlet__body">

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputName">Placa</label>
                                <input type="text" name="placa" id="inputplaca" class="form-control" maxlength="7" value="{{ $car->placa ?? '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <span class="">&nbsp;</span><br />
                                <button class="btn btn-default btn-block" id="btn-search-placa" type="button"><i class="fa fa-search"></i> Consultar</button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputCpfCnpj">Chassi</label>
                                <input type="text" id="input_chassi" name="chassi" class="form-control" maxlength="17" value="{{ $car->chassi ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inpuCity">Tipo (caminhão, passeio, etc...)</label>
                                <input type="text" class="form-control" name="type" value="{{ $car->type ?? '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inpuCity">Dispositivo</label>
                                <input type="text" class="form-control" name="device" value="{{ $car->device ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputAddress">Modelo</label>
                                <input type="text" class="form-control" name="model" value="{{ $car->model ?? '' }}">
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputAddress">Montadora</label>
                                <input type="text" id="input_automaker" class="form-control" name="automaker" value="{{ $car->automaker ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputComplement">Ano Fabricação</label>
                                <input type="text" class="form-control" name="year" value="{{ $car->year ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputNumber">Cor</label>
                                <input type="text" class="form-control" name="color" value="{{ $car->color ?? '' }}">
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button type="button" class="btn btn-brand" id="btn-car-save">Cadastrar</button>
                                        <a href="{{url('fleets/cars')}}" class="btn btn-secondary">Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 border-left">
                        @if(Route::is('car.edit'))
                        <br />
                        <h4>Motoristas Vinculados <a href="{{url('fleets/cars/edit')}}/{{$car->id}}" class="btn btn-sm btn-default" id="btn-refresh-status"><i class="fa fa-redo"></i> Atualizar</a> </h4>

                        @if($cards_linkeds->count() == 0)
                        Nenhum cartão vinculado a este veículo.
                        @endif

                        <div class="row">
                            @foreach( $cards_linkeds as $card )

                            @if(isset($card->card))
                            <div class="col-sm-6" id="div-card-{{$card->card->id ?? ''}}">
                                <div class="alert alert-secondary  fade show" role="alert">
                                    <div class="alert-icon"><i class="flaticon2-browser-1"></i></div>
                                    <div class="alert-text" id="text-close-{{$card->card->id ?? ''}}">{{$card->card->drivers[0]->name?? ''}} {{$card->status}}

                                        @if($card->status == "Iniciado")
                                            <br /><span class="text-warning"> <i class="fa fa-pulse fa-spinner"></i> Enviando comando...</span>
                                        @elseif($card->status == "sucesso")
                                            <br /><span class="text-success"> <i class="fa fa-check"></i> Vinculado!</span>
                                        @else
                                            <br /><span class="text-danger"> <i class="fa fa-times"></i> Erro, tente novamente!</span>
                                        @endif

                                    </div>
                                    <div class="alert-close">
                                        <!-- data-dismiss="alert" aria-label="Close" -->
                                        <button type="button" class="close btn-close-card" data-card_id="{{$card->card->id ?? ''}}" data-car_id="{{$car->id}}">
                                            <span aria-hidden="true"><i class="la la-close"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @endforeach

                            <div class="col-sm-12">
                                <hr />
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ExemploModalCentralizado"><i class="fa fa-plus"></i>
                                    Vincular Motoristas
                                </button>
                            </div>

                        </div>

                    </div>
                    @endif
                </div>

            </div>
        </form>

    </div>
</div>


<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalCentralizado">Vincular Motoristas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if( $cards_available->count() > 0 )
                <form id="form-cards">
                    @csrf
                    <div class="row">
                        @foreach( $cards_available as $card_av )
                        <div class="col-sm-4 border-right">
                            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                <input type="checkbox" name="cards[]" value="{{$card_av->id}}"> {{$card_av->drivers[0]->name}}
                                <span></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </form>
                @else
                <i class="fa fa-warning"></i> Não existem motoristas disponíveis.
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn-add-cards">Salvar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    // Update Status
    @if(isset($cards_linkeds))
        var devices = [
            @foreach( $cards_linkeds as $card_linked )
                {{$card_linked->id}},
            @endforeach
        ];

        $.ajax({
            url: "{{url('/api/fleets/cards/update-status')}}",
            method: 'POST',
            data: {devices: devices}
        });
        $('#btn-refresh-status').click(function(){
            $(this).html('<i class="fa fa-spinner fa-pulse"></i> Aguarde...')
        })
    @endif
    // Fim - update status

    $('#btn-add-cards').click(function() {
        var data = $('#form-cards').serialize() + '&car_id={{$car->id}}';
        $('#btn-add-cards').html('<i class="fa fa-spinner fa-pulse"></i> Aguarde...');

        $.ajax({
            url: "{{url('fleets/cards/add-cards')}}",
            method: 'POST',
            data: data,
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                $('#btn-add-cards').html('Salvar');
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                    showConfirmButton: true,
                    timer: 10000
                })
            }
        });

    })

    $('.btn-close-card').click(function() {
        var car_id = $(this).data('car_id')
        var card_id = $(this).data('card_id')

        $('#text-close-' + card_id).html('<i class="fa fa-spinner fa-pulse"></i> Removendo...')

        $.ajax({
            url: "{{url('fleets/cards/remove-car')}}/" + car_id + "/" + card_id,
            method: 'GET',
            success: function(response) {
                ///$('#div-card-' + card_id).hide()
            },
            error: function(error) {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                    showConfirmButton: true,
                    timer: 10000
                })
            }
        });
    })

    /**
         Gravar carro
         */
    $(function() {

        var car_id = $('#id').val();
        $('#btn-car-save').click(function() {
            ajax_store(car_id, "fleets/cars", $('#form-create-car').serialize());
        });

    });


    /**
     Pesquisar placa de carro
     */
    $(function() {

        $('#btn-search-placa').click(function() {

            var placa = $('#inputplaca').val();
            var url = "{{url('')}}/api-device/get-device/" + placa;

            if (placa != "") {
                $(this).html('<i class="fa fa-spinner fa-pulse"></i> Aguarde..')
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == "success") {
                            $('#input_chassi').val(response.data.chassi);
                            $('input[name=automaker]').val(response.data.marca);
                            $('input[name=model]').val(response.data.modelo);
                            $('input[name=year]').val(response.data.ano);
                            $('input[name=color]').val(response.data.cor);
                            $('input[name=type]').val(response.data.categoria);
                            $('input[name=device]').val(response.data.device);
                            $('#btn-search-placa').html('<i class="fa fa-search"></i> Consultar')
                        } else {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Vaículo não encontrado na base de dados.',
                                showConfirmButton: true,
                                timer: 10000
                            })
                            $('#btn-search-placa').html('<i class="fa fa-search"></i> Consultar')
                        }
                    }
                });
            } else {
                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Informe uma placa.',
                    showConfirmButton: true,
                    timer: 10000
                })
                $('#btn-search-placa').html('<i class="fa fa-search"></i> Consultar')
            }
        });
    });
</script>
@endsection
