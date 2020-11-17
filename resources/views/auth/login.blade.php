@extends('layouts.app')

@section('content')

<div class="kt-login__form">
    <div class="kt-login__title">
        <h3>Login</h3>
    </div>

    <form class="kt-form" action="" novalidate="novalidate">
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" placeholder="Senha" name="password">
        </div>
        <div class="kt-login__actions">
            @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Esqueceu a senha?') }}
            </a>
            @endif
            <button id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Entrar
            </button>
        </div>
    </form>

</div>
@endsection