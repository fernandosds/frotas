@extends('layouts.index')

@section('content')
<form method="POST" id="createuser">
    @csrf
    <div class="form-group row">
        <div class="col-sm-10">
            <label for="validationServer01">Nome</label>
            <input type="text" value="{{$user->name}} ? ''"  class="form-control is-valid" id="validationServer01" name="name" placeholder="Nome" required>
            <div class="valid-feedback">
                Tudo certo!
            </div>
        </div>

    </div>

    <div class="form-group">
        <label for="type">Tipo</label>
        <select name="type" class="custom-select" required>
            <option value="">Selecione um nível de usuário</option>
            <option value="sat">SAT</option>
            <option value="transportadora">TRANSPORTADORA</option>
            <option value="dono_carga">DONO DE CARGA</option>
            <option value="gerenciador_risco">GERENCIADOR DE RISCO</option>
            <option value="embaixador">EMBAIXADOR</option>
        </select>
        <div class="invalid-feedback">Exemplo de feedback invalido para o select</div>


    </div>


    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="custom-select" required>
            <option value="1">ATIVO</option>
            <option value="2">INATIVO</option>
        </select>
        <div class="invalid-feedback">Selecione um status</div>
    </div>

    <div class="form-group row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input value="@{{$user->email}}" type="email" class="form-control is-valid" id="validationServer01" placeholder="Email" name="email" required></div>
    </div>
    <div class="form-group row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
        <div class="col-sm-10">
            <input value="@{{$user->password}}" type="password" class="form-control" id="inputPassword" placeholder="Senha" name="password">
        </div>
    </div>


    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck3" required>
            <label class="form-check-label" for="invalidCheck3">
                Concordo com os termos e condições
            </label>
            <div class="invalid-feedback">
                Você deve concordar, antes de continuar.
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Cadastrar</button>

</form>
@endsection