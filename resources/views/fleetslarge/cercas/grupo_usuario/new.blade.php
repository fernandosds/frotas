@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
<<<<<<< HEAD .btn-distribuir {
    display: grid;
    row-gap: 15px;
    margin-top: 5rem;
    margin-left: 3rem;
}

=======.btn-distribuir {
    display: grid;
    row-gap: 15px;
    margin-top: 8rem;
    margin-left: 2rem;
}

>>>>>>>69203617124881c3fa9902177658b18d0daf85bb
</style>

<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <i class="la la-user"></i>
                Grupo de Usuários
            </h3>
        </div>
    </div>

    <!--begin::Form-->
    <form class="kt-form kt-form--label-right" id="form-create-cerca">
        @csrf
        <input type="hidden" name="id" id="id" value="{{ $cerca->id ?? '' }}" />
        <div class="kt-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Nome Grupo:</label>
                    <input type="text" class="form-control" id="name">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-4" style="margin-top: 5px;">
                    <label for="exampleSelect2" class="col-form-label">Usuarios: </label></br>
                    <select class="form-control col-md-10 leftBox seguradoresLeft" name="id" id="seguradoresRight"
                        multiple size="10">
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    <<<<<<< HEAD <span class="form-text text-muted"> *Selecione um ou mais usuários e os direcione para
                        o quadro á
                        direita.</span>
                        =======
                        <span class="form-text text-muted"> <i class="flaticon-questions-circular-button"></i> Selecione
                            um ou mais usuários e os direcione para o quadro á direita.</span>
                        >>>>>>> 69203617124881c3fa9902177658b18d0daf85bb
                </div>
                <div class="col-lg-2">
                    <div class="kt-input-icon kt-input-icon--right btn-distribuir">
                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                            onClick="moveSelected('seguradoresLeft')" title="Atribuir"><i
                                class="la la-arrow-right"></i></button>
                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                            onClick="moveSelected('seguradoresRight')" title="Desfazer atribuição"><i
                                class="la la-arrow-left"></i></button>
                    </div>
                </div>
                <div class="col-lg-4" style="margin-top: 9px;">
                    <div class="kt-input-icon kt-input-icon--right">
                        <label for="exampleSelect2" class="col-form-label">Incluir usuários no grupo: </label>
                        <select multiple size="10" class="form-control col-md-10 rightBox seguradoresRight"
                            id="seguradoresLeft" name='seguradoras[]'>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">

                    <div class="col-lg-3 ml-lg-auto">
                        <button type="button" class="btn btn-success" id="btn-user-save">Confirmar</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

$('#btn-user-save').click(function() {
    cerca_id = $('#id').val();
    var data = {
        _token: '{{csrf_token()}}',
        users: $(`#seguradoresLeft option`).toArray().map(o => o.innerHTML),
        nameGroup: $('#name').val()
    }
    // console.log($('#name').val());
    ajax_store(cerca_id, "fleetslarges/grupos", data);

});
</script>

@endsection