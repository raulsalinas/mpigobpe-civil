@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('title')Maestros @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Maestros</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Configuración</li>
                    <li class="breadcrumb-item active">Maestros</li>
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
                        <h3 class="card-title m-2"></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="ubigeo-tab" data-toggle="tab" data-target="#ubigeo" type="button" role="tab" aria-controls="ubigeo" aria-selected="false">Ubigeo</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="centros_asistenciales-tab" data-toggle="tab" data-target="#centros_asistenciales" type="button" role="tab" aria-controls="centros_asistenciales" aria-selected="false">Centros Asistenciales</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tipo_recibos-tab" data-toggle="tab" data-target="#tipo_recibos" type="button" role="tab" aria-controls="tipo_recibos" aria-selected="false">Tipo de Recibos</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="motivo_defuncion-tab" data-toggle="tab" data-target="#motivo_defuncion" type="button" role="tab" aria-controls="motivo_defuncion" aria-selected="false">Motivos de Defunción</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="ubigeo" role="tabpanel" aria-labelledby="ubigeo-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed" id="tablaUbigeo">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10">Codigo</th>
                                                                        <th width="15">Nombre</th>
                                                                        <th width="5">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody></tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="centros_asistenciales" role="tabpanel" aria-labelledby="centros_asistenciales-tab">

                                    </div>
                                    <div class="tab-pane fade" id="tipo_recibos" role="tabpanel" aria-labelledby="tipo_recibos-tab">

                                    </div>
                                    <div class="tab-pane fade" id="motivo_defuncion" role="tabpanel" aria-labelledby="motivo_defuncion-tab">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('configuracion.modal-ubigeo')


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