@extends('layouts.app_login')

@section('content')

<div class="kt-login__form">

    <div class="kt-login__title">
        <h3><i class="fa fa-lock"></i> Login</h3>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input id="email" type="email" id="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <div class="form-group">
            <input id="password" type="password" id="password" placeholder="Senha" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>

        <div class="col-md-6 offset-md-4">
            <div class="form-check">

                <!--
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
                -->
            </div>


        </div>


        <div class="kt-login__actions">
            <!--
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Esqueceu a senha?') }}
                </a>
                @endif
            -->
            <button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary" id="btn-login">
                <i class="fa fa-lock"></i> Logar
            </button>

            <button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary" id="btn-forgot_password">
                <i class="fa fa-key"></i> Esqueceu a senha?
            </button>

        </div>


    </form>

</div>
@endsection

@section('scripts')
<script>
    $('#btn-login').click(function() {
        if ($('#password').val() !== '' && $('#email').val() !== '') {
            $(this).html('<i class="fa fa-pulse fa-spinner"></i> Aguarde...')
        }
    })

    $('#btn-forgot_password').click(function() {

        var email = $('#email').val();
        var route = 'forget/password'
        //alert();

        if ($('#email').val()) {
            $(this).html('<i class="fa fa-pulse fa-spinner"></i> Enviando...')

            $.ajax({
                url: "{{url('')}}/" + route,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email
                },                
                success: function(response) {

                    if (response.status == "success") {
                        Swal.fire({
                            type: 'success',
                            title: 'Email enviado com sucesso',
                            showConfirmButton: true,
                            timer: 3000
                        })

                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Erro ao tentar salvar! ',
                            showConfirmButton: true,
                            timer: 2500
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
        }
    })
</script>
@endsection