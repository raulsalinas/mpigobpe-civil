@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('title')Gestión de Usuarios @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Gestión de Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Configuración</li>
                    <li class="breadcrumb-item active">Gestión de Usuarios</li>
                </ol>
            </div>
        </div>
    </div>
</section>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="">
                        <h3 class="card-title m-2">Listado de usuarios</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaUsuario">
                                        <thead>
                                            <tr>
                                            <th style="width: 2%">#</th>
                                            <th style="width: 20%">Usuario</th>
                                            <th style="width: 30%">Correo</th>
                                            <th style="width: 40%">Nombre</th>
                                            <th style="width: 10%">Fecha creación</th>
                                            <th style="width: 10%">Fecha actualización</th>
                                            <th style="width: 10%">Fecha anulación</th>
                                            <th width="10">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('configuracion.modal-usuario')


@endsection

@section('scripts')
<script src=" {{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_usuarios-view.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_usuarios-model.js?v=2') }}"></script>

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();



        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida

        const gestionarUsuariosView = new GestionarUsuariosView(new GestionarUsuariosModel(csrf_token));
        gestionarUsuariosView.listar();
        gestionarUsuariosView.eventos();


    });
</script>
@endsection