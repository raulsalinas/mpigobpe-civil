<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Iniciar Sesión - {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/ico" href="{{asset('images/icono.ico')}}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/basic.css') }}">
    </head>
    <body class="login-page">
        <div class="login-box">
            @yield("content")
        </div>
        <script src="{{ asset('assets/lte_3/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/dist/js/adminlte.min.js') }}"></script>
        @yield("scripts")
    </body>
</html>