@extends('layouts.auth')

@section('login')
<div class="login-box-body" style="display: flex; align-items: center; justify-content: center; cursor: none;">
    <!-- Image à gauche -->
    <div style="flex: 2;">
        <img src="{{ asset('img/Tablet login (1).gif') }}" alt="Tablet login (1).gif" style="width: 100%; max-height: 520px;">
    </div>
    
    <!-- Formulaire à droite -->
    <div class="login-box" style="flex: 1;">
        <div class="login-box-body">
            <div class="login-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ url($setting->path_logo) }}" alt="logo.png" width="100">
                </a>
            </div>
    
            <form action="{{ route('login') }}" method="post" class="form-login">
                @csrf
                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <label for="email" style="color: #005564;">Adresse email</label>
                    <input type="email" name="email" class="form-control input-sm" placeholder="Email" required value="{{ old('email') }}" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="help-block">{{ $message }}</span>
                    @else
                    <span class="help-block with-errors"></span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <label for="password" style="color: #005564;">Mot de passe</label>
                    <input type="password" name="password" class="form-control input-sm" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                        <span class="help-block">{{ $message }}</span>
                    @else
                        <span class="help-block with-errors"></span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Souvenez-vous de moi
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-success btn-block btn-flat" style="background-color: #005564;">S'identifier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
