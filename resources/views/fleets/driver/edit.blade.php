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
                    Motorista <small>Novo</small>
                </h3>
            </div>
        </div>

        <form class="kt-form kt-form--label-right" id="form-create-driver">
            <div class="row">
                <div class="col-sm-6">
                    <input type="hidden" name="id" id="id" value="{{ $driver->id ?? '' }}" />
                    @csrf
                    <div class="kt-portlet__body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="inputName">Nome</label>
                                <input type="text" name="name" class="form-control" value="{{ $driver->name ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Nº Cartão</label>
                                <select class="form-control" name="card_id" id="card_id">
                                    <option value=" ">Não adicionar cartão</option>
                                    <option value="{{$driver->card_id}}" {{old('card_id',$driver->card_id)==($driver->card_id ?? '')? 'selected':''}}>{{$driver->card->serial_number ?? ''}}</option>
                                    @foreach($cards as $card)
                                    <option value="{{$card->id}}" {{old('card_number',$card->id)== ($driver->card_id ?? '')? 'selected':' '}}>{{$card->serial_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="">Endereço</label>
                                <input type="text" class="form-control automaker" name="address" value="{{ $driver->address ?? '' }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputAddress">Data de Admissão</label>
                                <input type="date" class="form-control" name="admission" value="{{ $driver->admission ?? '' }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCpfCnpj">CPF</label>
                                <input type="text" id="input_cpf" name="cpf" class="form-control input_cpf_cnpj" maxlength="14" value="{{ $driver->cpf ?? '' }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputComplement">Telefone</label>
                                <input type="text" class="form-control mask_input_contact" name="phone" value="{{ $driver->phone ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-8">
                                <label for="inputNumber">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $driver->email ?? '' }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputAddress">CNH</label>
                                <input type="text" class="form-control" name="cnh" maxlength="11" value="{{ $driver->cnh ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                                <div class="form-group col-md-4">
                                    <label for="inputAddress">Validade da CNH</label>
                                    <input type="date" class="form-control" name="validation" value="{{ $driver->validation ?? '' }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="">Categoria A</label>
                                    <div class="form-group">
                                        <div class="kt-radio-inline">
                                            <label class="kt-checkbox">
                                                <input type="checkbox" name="category[]" value="A" {{ ($driver->category == 'A' || $driver->category == 'AB' || $driver->category == 'AC' || $driver->category == 'AD' || $driver->category == 'AE' ? 'checked' : '')}}>A
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputCategory">Outras Catogorias</label>
                                    <select class="form-control" name="category[]" id="category">
                                        <option value="">Sem categoria</option>
                                        <option value="B" {{ ($driver->category ?? null) == 'B' || ($driver->category ?? null) == 'AB' ? 'selected' : ''}} id="option">B</option>
                                        <option value="C" {{ ($driver->category ?? null) == 'C' || ($driver->category ?? null) == 'AC'? 'selected' : ''}} id="option">C</option>
                                        <option value="D" {{ ($driver->category ?? null) == 'D' || ($driver->category ?? null) == 'AD'? 'selected' : ''}} id="option">D</option>
                                        <option value="E" {{ ($driver->category ?? null) == 'E' || ($driver->category ?? null) == 'AE'? 'selected' : ''}} id="option">E</option>
                                    </select>
                                </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="inputAddress">Status</label>
                                <select class="form-control" name="status">
                                    <option value="0" {{ ($driver->status ?? null) == '0' ? 'selected' : ''}}>Ativo</option>
                                    <option value="1" {{ ($driver->status ?? null) == '1' ? 'selected' : ''}}>Inativo</option>
                                </select>
                            </div>

                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button type="button" class="btn btn-brand" id="btn-driver-save">Cadastrar</button>
                                        <a href="{{url('fleets/drivers')}}" class="btn btn-secondary">Voltar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5 border-left">
                    <br />
                    <h4>Veículos Vinculados <a href="{{url('fleets/drivers/edit')}}/{{$driver->id}}" class="btn btn-sm btn-default" id="btn-refresh-status"><i class="fa fa-redo"></i> Atualizar</a> </h4>
                    @if($cars_linkeds->count() == 0)
                    Nenhum veículo vinculado a este cartão.
                    @endif
                    <div class="row">
                        @foreach( $cars_linkeds as $car )
                        <div class="col-sm-6" id="div-car-{{$car->car->id}}">
                            <div class="alert alert-secondary  fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-truck"></i></div>
                                <div class="alert-text" id="text-close-{{$car->car->id ?? ''}}">{{$car->car->placa}} {{$car->status}}
                                    @if($car->status == "Iniciado")
                                    <br /><span class="text-warning"> <i class="fa fa-pulse fa-spinner"></i> Enviando comando...</span>
                                    @elseif($car->status == "sucesso")
                                    <br /><span class="text-success"> <i class="fa fa-check"></i> Vinculado!</span>
                                    @endif
                                </div>
                                <div class="alert-close">
                                    <!-- data-dismiss="alert" aria-label="Close" -->
                                    <button type="button" class="close btn-close-card" data-car_id="{{$car->car->id}}" data-card_id="{{$car->placa}}">
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
                <form id="form-cars-drivers">
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
                <button type="button" class="btn btn-primary" id="btn-add-cars-driver">Salvar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Update Status
    @if(isset($driver -> card -> serial_number))
    var devices = [
        @foreach($cars_linkeds as $card_linked) {
            {
                $card_linked -> id
            }
        },
        @endforeach
    ];
    @endif
    $.ajax({
        url: "{{url('/api/fleets/cards/update-status')}}",
        method: 'POST',
        data: {
            devices: devices
        }
    });
    $('#btn-refresh-status').click(function() {
        $(this).html('<i class="fa fa-spinner fa-pulse"></i> Aguarde...')
    })
    // Fim - update status


    $('#btn-add-cars-driver').click(function() {
        var data = $('#form-cars-drivers').serialize() + '&card_id={{$driver->card_id}}';
        $('#btn-add-cars-driver').html('<i class="fa fa-spinner fa-pulse"></i> Aguarde...');

        $.ajax({
            url: "{{url('/fleets/cards/add-cars')}}",
            method: 'POST',
            data: data,
            success: function(response) {
                location.reload();
            },
            error: function(error) {
                $('#btn-add-cars-driver').html('Salvar');
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
        var card_id = $('#card_id').val()
        $('#text-close-' + car_id).html('<i class="fa fa-spinner fa-pulse"></i> Removendo...')

        $.ajax({
            url: "{{url('fleets/cards/remove-car')}}/" + car_id + "/" + card_id,
            method: 'GET',
            success: function(response) {
                //$('#div-car-' + car_id).hide()
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
         Gravar motorista
         */
    $(function() {

        var driver_id = $('#id').val();

        $('#btn-driver-save').click(function() {
            ajax_store(driver_id, "fleets/drivers", $('#form-create-driver').serialize());
        });

    });
</script>
@endsection
