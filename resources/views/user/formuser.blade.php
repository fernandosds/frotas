@extends('layouts.index')

@section('content')

@section('title')
@if(isset($user)) Editar @else Cadastrar @endif
@endsection

<!--begin::Portlet-->
<!--begin::Form-->
<form class="kt-form kt-form--label-right" id="form-create-user" >
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
                <input type="text" class="form-control" name="name" placeholder="Entre com o nome" value="{{ $user->name ?? '' }}" required="True">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">Email *</label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <input type="text" class="form-control" name="email" placeholder="Entre com o email" value="{{ $user->email ?? '' }}" required="True">
                <span class="form-text text-muted">Nunca compartilharemos seu e-mail com mais ninguém.</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">Tipo</label>
            <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
                <select class="form-control" name="type">
                    <option value="">Selecione um nível de usuário</option>
                    <option value="sat" {{ ($user->type ?? null) == 'sat' ? 'selected' : ''}}>SAT</option>
                    <option value="transportadora" {{ ($user->type ?? null) == 'transportadora' ? 'selected' : ''}}>TRANSPORTADORA</option>
                    <option value="dono_carga" {{ ($user->type ?? null) == 'dono_carga' ? 'selected' : ''}}>DONO DE CARGA</option>
                    <option value="gerenciador_risco" {{ ($user->type ?? null) == 'gerenciador_risco' ? 'selected' : ''}}>GERENCIADOR DE RISCO</option>
                    <option value="embaixador" {{ ($user->type ?? null) == 'embaixador' ? 'selected' : ''}}>EMBAIXADOR</option>
                </select>
                <span class="form-text text-muted">Selecione o nível de acesso do usuário.</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">Tipo</label>
            <div class="col-lg-9 col-md-9 col-sm-12 form-group-sub">
                <select class="form-control" name="status">
                    <option value="1" {{ ($user->status ?? null) == '1' ? 'selected' : ''}}>ATIVO</option>
                    <option value="2" {{ ($user->status ?? null) == '2' ? 'selected' : ''}}>INATIVO</option>
                </select>
                <span class="form-text text-muted">Status</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-lg-3 col-sm-12">Senha</label>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <input type="password" class="form-control" name="password" placeholder="Digite sua senha" value="{{ $user->password ?? '' }}">
            </div>
        </div>

    </div>
    <div class="kt-portlet__foot">
        <div class="kt-form__actions">
            <div class="row">
                <div class="col-lg-9 ml-lg-auto">
                    <button type="button" class="btn btn-brand" id="btn-cadastro-user">Confirmar</button>
                    <a href="{{route('users')}}" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>

</form>

<!--end::Form-->


<!--end::Portlet-->

@endsection

@section('scripts')


<script>
    $(function() {

        $('#btn-cadastro-user').click(function(event) {


            
            $.ajax({
                url: "{{route('register_user')}}",
                type: 'POST',
                data: $('#form-create-user').serialize(),
                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        title: 'Sucesso!',
                        text: response,
                        footer: ' '
                    })
                },
                error: function(error) {
                    Swal.fire({
                        type: 'error',
                        title: 'Erro!',
                        text: 'Não executuado!',
                        footer: ' '
                    })
                }
            });
        });

});
</script>
@endsection