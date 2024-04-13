@extends('layouts.auth')

@section('login')


<div class="login-box-body" style="background-image: url('{{ asset('img/img.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; display: flex; align-items: center; justify-content: center;">
<div class="login-box" >

    <!-- /.login-logo -->
    <div class="login-box-body" >
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ url($setting->path_logo) }}" alt="logo.png" width="100">
            </a>
        </div>

        <form action="{{ route('login') }}" method="post" class="form-login">
            @csrf
            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @error('email')
                    <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
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
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat">S'identifier</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div><!-- visit "codeastro" for more projects! -->
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
@endsection