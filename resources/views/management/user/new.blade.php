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

        <div class="row">
            <div class="col-sm-8">
                <form class="kt-form kt-form--label-right" id="form-create-user">
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
                            <div class="col-lg-5 col-md-9 col-sm-12">
                                <input type="text" class="form-control" name="email" placeholder="Entre com o email" value="{{ $user->email ?? '' }}" required="True">
                            </div>
                            <label class="col-form-label col-lg-1 col-sm-12">Tel. *</label>
                            <div class="col-lg-3 col-md-9 col-sm-12">
                                <input type="text" class="form-control mask_input_contact" name="telephone" placeholder="Telefone" value="{{ $user->telephone ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-form-label col-lg-3 col-sm-12">Nível de acess </label>
                            <div class="col-lg-3 col-md-3 col-sm-12 form-group-sub">
                                <select class="form-control" name="access_level">
                                    <option value="">... Nível de acesso</option>
                                    <option value="management" {{ ($user->access_level ?? null) == 'management' ? 'selected' : ''}}>Gerência (Acesso total)</option>
                                    @if(Auth::user()->type == "ext" || Auth::user()->type == "sat")
                                    <option value="shipper" {{ ($user->access_level ?? null) == 'shipper' ? 'selected' : ''}}>Embarcador</option>
                                    @endif
                                    @if(Auth::user()->type == "sat")
                                    <option value="commercial" {{ ($user->access_level ?? null) == 'commercial' ? 'selected' : ''}}>Comercial</option>
                                    <option value="logistic" {{ ($user->access_level ?? null) == 'logistic' ? 'selected' : ''}}>Logística</option>
                                    <option value="production" {{ ($user->access_level ?? null) == 'production' ? 'selected' : ''}}>Produção</option>
                                    @endif
                                    @if(Auth::user()->type == "fle" || Auth::user()->type == "sat")
                                    <option value="fleets" {{ ($user->access_level ?? null) == 'fleets' ? 'selected' : ''}}>Gestão de Frotas</option>
                                    @endif
                                    @if(Auth::user()->type == "gfl" || Auth::user()->type == "sat")
                                    <option value="fleetslarge" {{ ($user->access_level ?? null) == 'fleetslarge' ? 'selected' : ''}}>Gestão de Grandes Frotas</option>
                                    @endif
                                </select>
                            </div>

                            @if(Auth::user()->type == "sat")

                            <label class="col-form-label col-lg-1 col-sm-12">Empresa </label>
                            <div class="col-lg-2 col-md-4 col-sm-5 form-group-sub">
                                <select class="form-control" name="customer_id">
                                    <option value="1">SAT Company</option>
                                    @foreach( $customers as $customer )
                                    <option value="{{$customer->id}}" @if( isset( $user ) ) {{ ($user->customer_id == $customer->id) ? 'selected' : '' }} @endif>{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-form-label col-lg-1 col-sm-12">Tipo Usuário </label>
                            <div class="col-lg-2 col-md-4 col-sm-5 form-group-sub">
                                <select class="form-control" name="type">
                                    <option value="sat" {{ ($user->type ?? null) == 'sat' ? 'selected' : ''}}>SAT</option>
                                    <option value="ext" {{ ($user->type ?? null) == 'ext' ? 'selected' : ''}}>Externo</option>
                                    <option value="fle" {{ ($user->type ?? null) == 'fle' ? 'selected' : ''}}>Ges. Frotas</option>
                                    <option value="gfl" {{ ($user->type ?? null) == 'gfl' ? 'selected' : ''}}>Ges. Grandes Frotas</option>
                                </select>
                            </div>

                            @endif

                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Status</label>
                            <div class="col-lg-3 col-md-3 col-sm-3 form-group-sub">
                                <select class="form-control" name="status" @if(isset($user)) @if($user->id == Auth::user()->id) disabled="" @endif @endif>
                                    <option value="1" {{ ($user->status ?? null) == '1' ? 'selected' : ''}}>ATIVO</option>
                                    <option value="0" {{ ($user->status ?? null) == '0' ? 'selected' : ''}}>INATIVO</option>
                                </select>
                            </div>
                            @if(Auth::user()->type == "sat"|| Auth::user()->type == "ext")
                            <label class="col-form-label col-lg-3 col-sm-12">Requer Validação de embarque</label>
                            <div class="col-lg-2 col-md-2 col-sm-2 form-group-sub">
                                <select class="form-control" name="required_validation" @if(isset($user)) @if($user->id == Auth::user()->id) disabled="" @endif @endif>
                                    <option value="1" {{ ($user->required_validation ?? null) == '1' ? 'selected' : ''}}>SIM</option>
                                    <option value="0" {{ ($user->required_validation ?? null) == '0' ? 'selected' : ''}}>NÃO</option>
                                </select>
                            </div>
                            @endif
                        </div>

                        <div class="form-group row">

                            <label class="col-form-label col-lg-3 col-sm-12">Senha</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <input type="password" class="form-control" name="password" placeholder="Digite sua senha" value="" maxlength="8">
                                <span class="form-text text-muted">Min 6, Máx 8 dígitos</span>
                            </div>
                            <label class="col-form-label col-lg-2 col-sm-12">Confirma Senha</label>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirme sua senha" value="" maxlength="8">
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
                </form>
            </div>
            @if( Auth::user()->type == 'sat' || Auth::user()->type == 'fle')
            <div class="col-sm-4">
                @if(Route::is('user.edit'))
                <form id="form-create-permission">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ $user->id ?? '' }}" />
                    <div class="col-sm-12">
                        <br />
                        <h4>Pemissões </h4>
                        <div class="form-group">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Departamento</th>
                                        <th scope="col">Com Acesso</th>
                                        <th scope="col">Sem Acesso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div class="kt-radio-inline">
                                        <tr>
                                            <td>Monitoramento</td>
                                            <td>
                                                <label class="kt-radio kt-radio--success">
                                                    <input type="radio" name="monitoring_id" value="1" checked="checked" {{@$user->usersmenu[0]->list_menu_id == '1' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="kt-radio kt-radio--danger">
                                                    <input type="radio" name="monitoring_id" value="0" {{@$user->usersmenu[0]->list_menu_id == '0' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dashboard</td>
                                            <td>
                                                <label class="kt-radio kt-radio--success">
                                                    <input type="radio" name="dashboard_id" value="2" checked="checked" {{@$user->usersmenu[1]->list_menu_id == '2' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="kt-radio kt-radio--danger">
                                                    <input type="radio" name="dashboard_id" value="0" {{@$user->usersmenu[1]->list_menu_id == '0' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Motoristas</td>
                                            <td>
                                                <label class="kt-radio kt-radio--success">
                                                    <input type="radio" name="driver_id" value="3" checked="checked" {{@$user->usersmenu[2]->list_menu_id == '3' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="kt-radio kt-radio--danger">
                                                    <input type="radio" name="driver_id" value="0" {{@$user->usersmenu[2]->list_menu_id == '0' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Frota de Carros</td>
                                            <td>
                                                <label class="kt-radio kt-radio--success">
                                                    <input type="radio" name="fleet_car_id" value="4" checked="checked" {{@$user->usersmenu[3]->list_menu_id == '4' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="kt-radio kt-radio--danger">
                                                    <input type="radio" name="fleet_car_id" value="0" {{@$user->usersmenu[3]->list_menu_id == '0' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Cartões</td>
                                            <td>
                                                <label class="kt-radio kt-radio--success">
                                                    <input type="radio" name="card_id" value="5" checked="checked" {{@$user->usersmenu[4]->list_menu_id == '5' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="kt-radio kt-radio--danger">
                                                    <input type="radio" name="card_id" value="0" {{@$user->usersmenu[4]->list_menu_id == '0' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Custos</td>
                                            <td>
                                                <label class="kt-radio kt-radio--success">
                                                    <input type="radio" name="cost_id" value="6" checked="checked" {{@$user->usersmenu[5]->list_menu_id == '6' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="kt-radio kt-radio--danger">
                                                    <input type="radio" name="cost_id" value="0" {{@$user->usersmenu[5]->list_menu_id == '0' ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                        <hr />
                        <button type="button" class="btn btn-outline-success btn-sm pull-right" id="btn-permission">
                            <i class="fa fa-cogs"></i> Aplicar Permissões
                        </button>
                    </div>
                </form>
            </div>
            @endif
            @endif
        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
    $(function() {

        $('#btn-user-save').click(function() {

            var user_id = $('#id').val();
            $('#btn-user-save').prop('disabled', true);
            ajax_store(user_id, "management/users", $('#form-create-user').serialize());

        });

    });

    $(function() {
        $('#btn-permission').click(function() {
            var user_id = $('#id').val();
            ajax_permission(user_id, "management/users/permission", $('#form-create-permission').serialize());

        });
    });
</script>
@endsection
