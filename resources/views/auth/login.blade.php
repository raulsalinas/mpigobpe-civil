@extends('themes/layout_login')

@section('content')
    <div class="card">
        <div class="card-body login-card-body" style="background-color: #e3dedb;">
            <div class="login-branding">
                <img class="" src="{{ asset('images/logo.png') }}" alt="Logo_OKC">
                <h5>Registro Civil</h5>
                <small>Por favor, ingresa tu usuario y contraseña.</small>
            </div>
            <form action="{{ route('login') }}" method="post" novalidate="novalidate" autocomplete="off">
                {{ csrf_field() }}
                <div class="input-group input-group-sm mb-3 has-feedback">
                    <input class="form-control @error('usuario') is-invalid @enderror"
                        type="text" name="usuario" value="{{ old('usuario') }}"
                        placeholder="Ingrese su usuario" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                    @error('usuario')
                        <span class="error invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group input-group-sm mb-3 has-feedback">
                    <input class="form-control @error('password') is-invalid @enderror"
                        type="password" name="password"
                        placeholder="Ingrese su contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                        <span class="error invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-warning btn-block btn-flat"><span class="fa fa-sign-in-alt"></span> INICIAR SESION</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection