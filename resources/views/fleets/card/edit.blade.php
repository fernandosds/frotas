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
                    {{$title}} <small></small>
                </h3>
            </div>
        </div>

        <form class="kt-form kt-form--label-right" id="form-create-card">

            <div class="row">

                <div class="col-sm-6">

                    @if(isset($card->id))

                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <h3><small>Número do Cartão:</small><br />{{$card->serial_number}}</h3>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{url('fleets/cards')}}" class="btn btn-default">Voltar</a>
                            </div>
                        </div>

                    </div>
                    @else

                    <input type="hidden" name="id" id="id" value="{{ $card->id ?? '' }}" />
                    @csrf

                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Nº de série</label>
                                <input type="text" name="serial_number" class="form-control" value="{{ $card->serial_number ?? '' }}">
                            </div>
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button type="button" class="btn btn-brand" id="btn-card-save">Cadastrar</button>
                                        <a href="{{url('fleets/cards')}}" class="btn btn-secondary">Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif

                </div>

                <div class="col-sm-5 border-left">

                    <br />
                    <h4>Veículos Vinculados <a href="{{url('fleets/cards/edit')}}/{{$card->id}}" class="btn btn-sm btn-default" id="btn-refresh-status"><i class="fa fa-redo"></i> Atualizar</a> </h4>

                    @if($cars_linkeds->count() == 0)
                    Nenhum veículo vinculado a este cartão.
                    @endif

                    <div class="row">
                        @foreach( $cars_linkeds as $car )

                        <div class="col-sm-6" id="div-car-{{$car->car->id}}">
                            <div class="alert alert-secondary  fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-truck"></i></div>
                                <div class="alert-text" id="text-close-{{$car->car->id ?? ''}}">{{$car->car->placa}}

                                    @if($car->status == "Iniciado")
                                        <br /><span class="text-warning"> <i class="fa fa-pulse fa-spinner"></i> Enviando comando...</span>
                                    @elseif($car->status == "sucesso")
                                        <br /><span class="text-success"> <i class="fa fa-check"></i> Vinculado!</span>
                                    @else
                                        <br /><span class="text-danger"> <i class="fa fa-times"></i> Erro, tente novamente!</span>
                                    @endif

                                </div>
                                <div class="alert-close">
                                    <button type="button" class="close btn-close-card" data-car_id="{{$car->car->id}}" data-card_id="{{$card->id}}">
                                        <span aria-hidden="true"><i class="la la-close"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @endforeach

                        <div class="col-sm-12">
                            <hr />
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ExemploModalCentralizado"><i class="fa fa-plus"></i> Vincular Veículos</button>
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TituloModalCentralizado">Vincular Veículos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if( $cars_available->count() > 0 )
                <form id="form-cars">
                    @csrf
                    <div class="row">
                        @foreach( $cars_available as $car_av )
                        <div class="col-sm-4 border-right">
                            <label class="kt-checkbox kt-checkbox--bold kt-checkbox--brand">
                                <input type="checkbox" name="cars[]" value="{{$car_av->id}}"> {{$car_av->placa}}
                                <span></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </form>
                @else
                <i class="fa fa-warning"></i> Não existem cartões disponíveis.
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btn-add-cars">Salvar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    // Update Status
    @if(isset($cars_linkeds))
        var devices = [
            @foreach( $cars_linkeds as $card_linked )
                {{$card_linked->id}},
            @endforeach
        ];
    @endif
    $.ajax({
        url: "{{url('/api/fleets/cards/update-status')}}",
        method: 'POST',
        data: {devices: devices}
    });
    $('#btn-refresh-status').click(function(){
        $(this).html('<i class="fa fa-spinner fa-pulse"></i> Aguarde...')
    })
    // Fim - update status

    $('#btn-add-cars').click(function() {
        var data = $('#form-cars').serialize() + '&card_id={{$card->id}}';
        $('#btn-add-cars').html('<i class="fa fa-spinner fa-pulse"></i> Aguarde...');

        $.ajax({
            url: "{{url('fleets/cards/add-cars')}}",
            method: 'POST',
            data: data,
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                $('#btn-add-cars').html('Salvar');
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

        $('#text-close-' + car_id).html('<i class="fa fa-spinner fa-pulse"></i> Removendo...')

        $.ajax({
            url: "{{url('fleets/cards/remove-car')}}/" + car_id + "/" + card_id,
            method: 'GET',
            success: function(response) {
                $('#div-car-' + car_id).hide()
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
     Gravar cartão
     */
    $(function() {
        var card_id = $('#id').val();
        $('#btn-card-save').click(function() {
            ajax_store(card_id, "fleets/cards", $('#form-create-card').serialize());
        });
    });
</script>
@endsection
