@extends('layouts.app')

@section('content')

<div class="kt-login__form">

    <div class="kt-login__title">
        <h3>{{ __('Login') }}</h3>
    </div>
    <form  method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <div class="form-group">
            <input id="password" type="password" placeholder="Senha" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="col-md-6 offset-md-4">
            <div class="form-check">

                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Lembrar-me') }}
                </label>
                <ul class="navbar-nav ml-auto">

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Registre-se') }}</a>
                    </li>
                </ul>
                @endif
            </div>


        </div>

        <div class="kt-login__actions">
            @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Esqueceu a senha?') }}
            </a>
            @endif
            <button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">
                {{ __('Login') }}
            </button>
        </div>
    </form>

</div>
@endsection