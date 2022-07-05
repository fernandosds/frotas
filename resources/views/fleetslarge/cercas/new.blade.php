@extends('layouts.app')

@section('content')
<style type="text/css">
	.btn-distribuir {
		display: grid;
		row-gap: 15px;
        margin-top: 5rem;
        margin-left: 3rem;
	}
</style>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Grupo de Cercas e Veículos
            </h3>
        </div>
    </div>

        <!--begin::Form-->
        <form class="kt-form kt-form--label-right">
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>Nome Cerca:</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label for="exampleSelect2" class="col-form-label">Placas: </label>

                        <select class="form-control leftBox seguradoresLeft col-md-10" id="seguradoresRight" multiple size="10">
                            @foreach($cars as $driver)
                                <option value="">{{$driver->placa}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-lg-2">
                        <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                            <button type="button" class="btn btn-primary btn-sm btn-icon" onClick="moveSelected('seguradoresLeft')" title="Atribuir"><i class="la la-arrow-right"></i></button>
                            <button type="button" class="btn btn-primary btn-sm btn-icon" onClick="moveSelected('seguradoresRight')" title="Desfazer atribuição"><i class="la la-arrow-left"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="kt-input-icon kt-input-icon--right">
                            <label for="exampleSelect2" class="col-form-label">Placa direcionada: </label>
                            <select multiple size="10" class="form-control col-md-10 rightBox seguradoresRight" id="seguradoresLeft" name='seguradoras[]'>
                                <!-- <option value=""></option> -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-3 ml-lg-auto">
                            <button type="button" class="btn btn-success">Confirmar</button>
                            <a href="#" class="btn btn-secondary">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->

</div>

@endsection

@section('scripts')
<script>
function moveSelected(classNAme) {
		const leftBox = $('.' + classNAme);
		var $options = $("." + classNAme + " option:selected").clone();
		$('.' + leftBox.attr('id')).append($options);
		$("." + classNAme + " option:selected").remove();
		var my_options = $('.' + leftBox.attr('id') + " option");
		my_options.sort(function(a, b) {
			if (a.text > b.text) return 1;
			else if (a.text < b.text) return -1;
			else return 0
		})
		$('.' + leftBox.attr('id')).empty().append(my_options);
	}

</script>

@endsection
