@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('title')Listado de Fichas @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Fichas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Utilidades</li>
                    <li class="breadcrumb-item">Fichas</li>
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
                        <h3 class="card-title m-2">Listado de Fichas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">


                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="fichas-nacimientos-tab" data-toggle="tab" href="#fichas-nacimientos" role="tab" aria-controls="fichas-nacimientos" aria-selected="true">Fichas nacimientos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="fichas-matrimonios-tab" data-toggle="tab" href="#fichas-matrimonios" role="tab" aria-controls="fichas-matrimonios" aria-selected="false">Fichas matrimonios</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="fichas-defunciones-tab" data-toggle="tab" href="#fichas-defunciones" role="tab" aria-controls="fichas-defunciones" aria-selected="false">Fichas defunciones</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="fichas-nacimientos" role="tabpanel" aria-labelledby="fichas-nacimientos-tab">

                                    <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaFichasNacimientos">
                                        <thead>
                                            <tr>
                                                <th width="5">N°</th>
                                                <th width="10">Condición</th>
                                                <th width="15">Nombre completo</th>
                                                <th width="15">Nombre sin extensión</th>
                                                <th width="80">Ruta</th>
                                                <th width="10">Extensión</th>
                                                <th width="10">Id registro nac.</th>
                                                <th width="10">Fecha registro</th>
                                                <th width="10">Fecha anulación</th>
                                                <th width="10">Descargar</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                    </div>
                                    <div class="tab-pane fade" id="fichas-matrimonios" role="tabpanel" aria-labelledby="fichas-matrimonios-tab">

                                    <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaFichasMatrimonios">
                                        <thead>
                                            <tr>
                                                <th width="5">N°</th>
                                                <th width="10">Condición</th>
                                                <th width="15">Nombre completo</th>
                                                <th width="15">Nombre sin extensión</th>
                                                <th width="80">Ruta</th>
                                                <th width="10">Extensión</th>
                                                <th width="10">Id registro matri.</th>
                                                <th width="10">Fecha registro</th>
                                                <th width="10">Fecha anulación</th>
                                                <th width="10">Descargar</th>

                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                    </div>
                                    <div class="tab-pane fade" id="fichas-defunciones" role="tabpanel" aria-labelledby="fichas-defunciones-tab">

                                    <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaFichasDefunciones">
                                        <thead>
                                            <tr>
                                                <th width="5">N°</th>
                                                <th width="10">Condición</th>
                                                <th width="15">Nombre completo</th>
                                                <th width="15">Nombre sin extensión</th>
                                                <th width="80">Ruta</th>
                                                <th width="10">Extensión</th>
                                                <th width="10">Id registro defun.</th>
                                                <th width="10">Fecha registro</th>
                                                <th width="10">Fecha anulación</th>
                                                <th width="10">Descargar</th>

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


@endsection

@section('scripts')
<script src="{{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/jszip/jszip.min.js') }}"></script>


<script src="{{ asset('js/modelo-vista/utilidades/listado_fichas-view.js')}}?v={{filemtime(public_path('js/modelo-vista/utilidades/listado_fichas-view.js'))}}"></script>
<script src="{{ asset('js/modelo-vista/utilidades/listado_fichas-model.js')}}?v={{filemtime(public_path('js/modelo-vista/utilidades/listado_fichas-model.js'))}}"></script>

<script>
    $(document).ready(function() {

        const listadoFichasView = new ListadoFichasView(new ListadoFichasModel(csrf_token));
        listadoFichasView.listarFichaNacimientos();
        listadoFichasView.listarFichaMatrimonios();
        listadoFichasView.listarFichaDefunciones();

    });
</script>
@endsection