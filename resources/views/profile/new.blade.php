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
                    {{$title}} <small>Profile</small>
                </h3>
            </div>
        </div>

        <form class="kt-form kt-form--label-right" id="form-update-profile">
            @csrf
            <div class="kt-portlet__body">
                <div class="form-group form-group-last kt-hide">
                    <div class="alert alert-danger" role="alert" id="kt_form_1_msg">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Altere algumas coisas e tente enviar novamente.
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="la la-close"></i></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Nome</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input type="text" class="form-control" name="name" placeholder="Entre com o nome" value="{{ $profile->name ?? '' }}" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Email *</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input type="text" class="form-control" name="email" placeholder="Entre com o email" value="{{ $profile->email ?? '' }}" required="True">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Senha</label>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <input type="password" class="form-control" name="password" placeholder="Digite sua senha" value="">
                        <span class="form-text text-muted">Min 6, Máx 8 dígitos</span>
                    </div>
                    <label class="col-form-label col-lg-2 col-sm-12">Confirma Senha</label>
                    <div class="col-lg-2 col-md-2 col-sm-12">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirme sua senha" value="">
                    </div>
                </div>

            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button type="button" class="btn btn-brand" id="btn-profile-save">Confirmar</button>
                            <a href="{{url('/')}}" class="btn btn-secondary">Voltar</a>
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

        /* Atualizar profile */

        $('#btn-profile-save').click(function() {


            $.ajax({
                url: "{{url('profiles/update')}}",
                method: 'PUT',
                data: $('#form-update-profile').serialize(),
                success: function(response) {

                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Usuário atualizado com sucesso!',
                            showConfirmButton: true
                        });

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Erro ao tentar salvar!',
                            text: response.message,
                            showConfirmButton: true
                        })
                    }

                },
                error: function(error) {

                    if (error.responseJSON.status == "internal_error") {
                        console.log(error.responseJSON.errors)
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro interno, entre em contato com o desenvolvedor do sistema!',
                            showConfirmButton: true,
                            timer: 2500
                        })
                    } else {
                        var items = error.responseJSON.errors;
                        var errors = $.map(items, function(i) {
                            return i.join('<br />');
                        });
                        Swal.fire({
                            type: 'error',
                            title: 'Erro!',
                            html: 'Os seguintes erros foram encontrados: ' + errors,
                            footer: ' '
                        })
                    }


                }

            });
        });

    });
</script>
@endsection