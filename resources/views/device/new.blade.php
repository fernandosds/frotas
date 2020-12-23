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
                        {{$title}} <small>Novo</small>
                    </h3>
                </div>
            </div>

            <form class="kt-form kt-form--label-right" id="form-create-device">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $device->id ?? '' }}" />

                <div class="kt-portlet__body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputSerialNumber">Número de série</label>
                            <input type="text" name="serial_number" class="form-control" value="{{ $device->serial_number ?? '' }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="inputTipoIsca">Tipo de isca</label>
                            <select class="form-control" name="type_of_device_id">
                                <option value=" ">Selecione um tipo</option>
                                <option value="1" {{ ($device->type_of_device_id ?? null) == 1 ? 'selected' : ''}}>Transportadora</option>
                                <option value="2" {{ ($device->type_of_device_id ?? null) == 2 ? 'selected' : ''}}>VAC</option>
                                <option value="3" {{ ($device->type_of_device_id ?? null) == 3 ? 'selected' : ''}}>Pallet</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputBateryLevel">Bateria</label>
                        <input type="text" class="form-control" name="batery_level" value="{{ $device->batery_level ?? '' }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Data validação</label>
                            <input type="date" class="form-control" name="validation" value="{{ $device->validation ?? '' }}">
                        </div>

                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 ml-lg-auto">
                                    <button type="button" class="btn btn-brand" id="btn-device-save">Cadastrar</button>
                                    <a href="{{url('devices')}}" class="btn btn-secondary">Voltar</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(function() {

        $('#btn-device-save').click(function() {

            var device_id = $('#id').val();

            ajax_store(device_id, "devices", $('#form-create-device').serialize());

        });

    });
</script>
@endsection