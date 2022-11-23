@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('title')Listado de Defunciones @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Defunciones</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Defunciones</li>
                    <li class="breadcrumb-item active">Listado</li>
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
                        <h3 class="card-title m-2">Listado de defunciones</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaDefuncion">
                                        <thead>
                                            <tr>
                                                <th width="10">N°</th>
                                                <th width="10">Año</th>
                                                <th width="10">Nro. Libro</th>
                                                <th width="10">Nro. Folio</th>
                                                <th width="50">Apellido Paterno</th>
                                                <th width="50">Apellido Matero</th>
                                                <th width="50">Nombres</th>
                                                <th width="50">Motivo de deceso</th>
                                                <th width="20">Fecha de deceso</th>
                                                <th width="20">Registrado por</th>
                                                <th width="20">Acción</th>
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

@include('defunciones.modal-filtro_defunciones')

@endsection

@section('scripts')
<script src="{{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/modelo-vista/defunciones/listado_defuncion-view.js?v=1') }}"></script>
<script src="{{ asset('js/modelo-vista/defunciones/listado_defuncion-model.js?v=1') }}"></script>
å
<script>
    $(document).ready(function() {
        const listadoDefuncionView = new ListadoDefuncionView(new ListadoDefuncionModel(csrf_token));
        listadoDefuncionView.listar(null);
        listadoDefuncionView.eventos();
        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida
    });
</script>
@endsection