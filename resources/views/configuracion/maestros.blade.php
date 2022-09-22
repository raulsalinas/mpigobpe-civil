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
                                        <button class="nav-link" id="tipo_registro-tab" data-toggle="tab" data-target="#tipo_registro" type="button" role="tab" aria-controls="tipo_registro" aria-selected="false">Tipo de Registros</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="motivo_defuncion-tab" data-toggle="tab" data-target="#motivo_defuncion" type="button" role="tab" aria-controls="motivo_defuncion" aria-selected="false">Motivos de Defunción</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="ubigeo" role="tabpanel" aria-labelledby="ubigeo-tab">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed" id="tablaUbigeo">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">Codigo</th>
                                                                        <th width="60%">Nombre</th>
                                                                        <th width="10%">Fecha creación</th>
                                                                        <th width="10%">Fecha actualización</th>
                                                                        <th width="10%">Fecha anulación</th>
                                                                        <th width="5%">Acción</th>
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
                                    <div class="tab-pane fade" id="centros_asistenciales" role="tabpanel" aria-labelledby="centros_asistenciales-tab">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed" id="tablaCentroAsistencial">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">Codigo</th>
                                                                        <th width="30%">Nombre</th>
                                                                        <th width="30%">Dirección</th>
                                                                        <th width="5%">Fecha creación</th>
                                                                        <th width="5%">Fecha actualización</th>
                                                                        <th width="5%">Fecha anulación</th>
                                                                        <th width="5%">Acción</th>
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
                                    <div class="tab-pane fade" id="tipo_registro" role="tabpanel" aria-labelledby="tipo_registro-tab">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed" id="tablaTipoRegistro">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">Codigo</th>
                                                                        <th width="75%">Nombre</th>
                                                                        <th width="5%">Fecha creación</th>
                                                                        <th width="5%">Fecha actualización</th>
                                                                        <th width="5%">Fecha anulación</th>
                                                                        <th width="5%">Acción</th>
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
                                    <div class="tab-pane fade" id="motivo_defuncion" role="tabpanel" aria-labelledby="motivo_defuncion-tab">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-condensed" id="tablaMotivoDefuncion">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%">Codigo</th>
                                                                        <th width="40%">Nombre</th>
                                                                        <th width="10%">Fecha creación</th>
                                                                        <th width="10%">Fecha actualización</th>
                                                                        <th width="10%">Fecha anulación</th>
                                                                        <th width="5%">Acción</th>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('configuracion.modal-ubigeo')
@include('configuracion.modal-centro_asistencial')
@include('configuracion.modal-tipo_registro')
@include('configuracion.modal-motivo_defuncion')


@endsection

@section('scripts')
<script src=" {{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_ubigeo-view.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_ubigeo-model.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_centro_asistencial-view.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_centro_asistencial-model.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_tipo_registro-view.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_tipo_registro-model.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_motivo_defuncion-view.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/configuraciones/gestionar_maestro_motivo_defuncion-model.js?v=2') }}"></script>

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();



        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida


        
        const gestionarMaestroUbigeoView = new GestionarMaestroUbigeoView(new GestionarMaestroUbigeoModel(csrf_token));
        gestionarMaestroUbigeoView.listarUbigeo();
        gestionarMaestroUbigeoView.eventos();

        const gestionarMaestroCentroAsistencialView = new GestionarMaestroCentroAsistencialView(new GestionarMaestroCentroAsistencialModel(csrf_token));
        gestionarMaestroCentroAsistencialView.listarCentroAsistencial();
        gestionarMaestroCentroAsistencialView.eventos();

        const gestionarMaestroTipoRegistroView = new GestionarMaestroTipoRegistroView(new GestionarMaestroTipoRegistroModel(csrf_token));
        gestionarMaestroTipoRegistroView.listarTipoRegistro();
        gestionarMaestroTipoRegistroView.eventos();

        const gestionarMaestroMotivoDefuncionView = new GestionarMaestroMotivoDefuncionView(new GestionarMaestroMotivoDefuncionModel(csrf_token));
        gestionarMaestroMotivoDefuncionView.listarMotivoDefuncion();
        gestionarMaestroMotivoDefuncionView.eventos();

   
    });

    $(document).on("click","li.nav-item", function (e) {
        setTimeout(
            function() {
                $( $.fn.dataTable.tables( true ) ).DataTable().columns.adjust();
            },
            500);
 
        })
</script>
@endsection