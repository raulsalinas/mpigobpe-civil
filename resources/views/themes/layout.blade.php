<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/ico" href="{{ asset('images/icono.ico') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/lobibox/dist/css/lobibox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/basic.css') }}">
        @yield("links")
    </head>
    <body class="sidebar-mini text-sm">
        <div class="wrapper">
            @include("themes/header")
            @include("themes/aside")

            <div class="content-wrapper">
                <section class="content-header">
                    @yield("breadcrumb")
                </section>
                <section class="content">
                    <div class="container-fluid">
                        @yield("content")
                    </div>
                </section>
            </div>
        </div>

        @include("themes/modal-password")

        <script src="{{ asset('assets/lte_3/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/sparklines/sparkline.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/fastclick/fastclick.js') }}"></script>
        <script src="{{ asset('assets/lte_3/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/lobibox/dist/js/lobibox.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/jquery-number/jquery.number.min.js') }}"></script>
        <script src="{{ asset('assets/lte_3/plugins/loadingoverlay/loadingoverlay.min.js') }}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/event.js') }}"></script>
        <script>
            let csrf_token = '{{ csrf_token() }}';
            const idioma = {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate":
                {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria":
                {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            };
            Util.seleccionarMenu(window.location);
        </script>
        @routes
        <script src="{{ asset('js/password.js') }}"></script>
        @yield("scripts")
    </body>
</html>