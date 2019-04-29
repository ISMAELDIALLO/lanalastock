@extends('layouts.app')
@section('arrierePlan')
    {{--<style>--}}
        {{--body{--}}
            {{--background-image: url("images/images.jpg");--}}
            {{--background-repeat: no-repeat;--}}
            {{--background-position: center;--}}
            {{--background-size: 60%;--}}
        {{--}--}}
    {{--</style>--}}
    @stop
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="">
                <div class="card-header glyphicon-ban-circle" style="text-align: center; ">{{ __('AUTHENTIFICATION') }}</div>
                <div class="card-body" style="">
                    <form method="POST" action="{{ route('login') }}">
                        <div class="text-center">
                            <img src="images/lanalaLogo.png">
                        </div>
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                @if (Session::has('nonAutorise'))
                                    <span class="help-block alert-danger"><i>Vous avez été bloqué</i>, veuillez contacter votre administrateur.</span>
                                @elseif(Session::has('nonTrouve'))
                                    <span class="help-block alert-danger"><i>Adresse email non trouvee</i></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de Passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('se connecter') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('mot de passe oublié?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
