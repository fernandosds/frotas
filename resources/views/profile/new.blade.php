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

        <form class="kt-form kt-form--label-right" id="form-create-user">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $profile->id ?? '' }}" />

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
                    <label class="col-form-label col-lg-3 col-sm-12">Tipo</label>
                    <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
                        <select class="form-control" name="type">
                            <option value="">Selecione um nível de usuário</option>
                            <option value="sat" {{ ($profile->type ?? null) == 'sat' ? 'selected' : ''}}>SAT</option>
                            <option value="transportadora" {{ ($profile->type ?? null) == 'transportadora' ? 'selected' : ''}}>TRANSPORTADORA</option>
                            <option value="dono_carga" {{ ($profile->type ?? null) == 'dono_carga' ? 'selected' : ''}}>DONO DE CARGA</option>
                            <option value="gerenciador_risco" {{ ($profile->type ?? null) == 'gerenciador_risco' ? 'selected' : ''}}>GERENCIADOR DE RISCO</option>
                            <option value="embaixador" {{ ($profile->type ?? null) == 'embaixador' ? 'selected' : ''}}>EMBAIXADOR</option>
                        </select>
                        <span class="form-text text-muted">Selecione o nível de acesso do usuário.</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Status</label>
                    <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
                        <select class="form-control" name="status" @if(isset($profile)) @if($profile->id == Auth::user()->id) disabled="" @endif @endif>
                            <option value="1" {{ ($profile->status ?? null) == '1' ? 'selected' : ''}}>ATIVO</option>
                            <option value="2" {{ ($profile->status ?? null) == '2' ? 'selected' : ''}}>INATIVO</option>
                        </select>

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
                            <button type="button" class="btn btn-brand" id="btn-user-save">Confirmar</button>
                            <a href="{{url('profiles')}}" class="btn btn-secondary">Voltar</a>
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

        $('#btn-user-save').click(function() {

            var user_id = $('#id').val();

            ajax_store(user_id, "users", $('#form-create-user').serialize());

        });

    });
</script>
@endsection