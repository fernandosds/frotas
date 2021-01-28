@extends('layouts.app')

@section('content')

<div class="kt-portlet">
    <div class="kt-section kt-section--first">

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

        <form class="kt-form kt-form--label-right" id="form-create-user">

            <div class="row">

                <div class="col-xl-1"></div>
                <div class="col-xl-6">

                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ $user->id ?? '' }}" />

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
                                <input type="text" class="form-control" name="name" placeholder="Entre com o nome" value="{{ $user->name ?? '' }}" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Email *</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" class="form-control" name="email" placeholder="Entre com o email" value="{{ $user->email ?? '' }}" required="True">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Tipo</label>
                            <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
                                <select class="form-control" name="type">
                                    <option value="sat" {{ ($user->type ?? null) == 'sat' ? 'selected' : ''}}>Usuário Interno</option>
                                    <option value="ext" {{ ($user->type ?? null) == 'ext' ? 'selected' : ''}}>Usuário Externo</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Status</label>
                            <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
                                <select class="form-control" name="status" @if(isset($user)) @if($user->id == Auth::user()->id) disabled="" @endif @endif>
                                    <option value="1" {{ ($user->status ?? null) == '1' ? 'selected' : ''}}>ATIVO</option>
                                    <option value="2" {{ ($user->status ?? null) == '2' ? 'selected' : ''}}>INATIVO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Senha</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <input type="password" class="form-control" name="password" placeholder="Digite sua senha" value="">
                                <span class="form-text text-muted">Min 6, Máx 8 dígitos</span>
                            </div>
                            <label class="col-form-label col-lg-3 col-sm-12">Confirma Senha</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirme sua senha" value="">
                            </div>
                        </div>

                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    <button type="button" class="btn btn-brand" id="btn-user-save">Confirmar</button>
                                    <a href="{{url('management/users')}}" class="btn btn-secondary">Voltar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-3">

                    @if(isset($user))
                        <div class="kt-portlet__body">

                            @if($user->type == "sat")
                                <div class="form-group row">
                                    <label class="col-form-label ">Nível de acesso (Usuário SAT Company)</label>
                                    <select class="form-control" name="access_level">
                                        <option value="">... Nível de acesso</option>
                                        <option value="commercial" {{ ($user->access_level ?? null) == 'commercial' ? 'selected' : ''}}>Comercial</option>
                                        <option value="logistic" {{ ($user->access_level ?? null) == 'logistic' ? 'selected' : ''}}>Logística</option>
                                        <option value="production" {{ ($user->access_level ?? null) == 'production' ? 'selected' : ''}}>Produção</option>
                                        <option value="management" {{ ($user->access_level ?? null) == 'management' ? 'selected' : ''}}>Gerência (Acesso total)</option>
                                    </select>
                                </div><br />

                            @else

                                <div class="form-group row">
                                    <label class="col-form-label ">Cliente (Usuario externo)</label>
                                    <select class="form-control" name="customer_id">
                                        <option value="">...Vincular ao cliente</option>
                                        @foreach( $customers as $customer )
                                            <option value="{{$customer->id}}" @if( isset( $user ) ) {{ ($user->customer_id == $customer->id) ? 'selected' : '' }} @endif>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            @endif

                        </div>
                    @endif

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

            ajax_store(user_id, "management/users", $('#form-create-user').serialize(), true);

        });

    });
</script>
@endsection