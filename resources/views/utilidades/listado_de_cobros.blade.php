@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('title')Listado de Cobros @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cobros</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Utilidades</li>
                    <li class="breadcrumb-item">Cobros</li>
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
                        <h3 class="card-title m-2">Listado de Cobros</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaCobros">
                                        <thead>
                                            <tr>
                                                <th width="5">N°</th>
                                                <th width="10">Fecha</th>
                                                <th width="15">Recibo</th>
                                                <th width="15">Tipo</th>
                                                <th width="10">Año</th>
                                                <th width="10">Nro. Libro</th>
                                                <th width="10">Nro. Folio</th>
                                                <th width="20">Tipo Recibo</th>
                                                <th width="20">Monto</th>
                                                <th width="30">Solicitante</th>
                                                <th width="10">Estado</th>
                                                <!-- <th width="5">Acción</th> -->
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


@endsection

@section('scripts')
<script src="{{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/jszip/jszip.min.js') }}"></script>

<script src="{{ asset('js/modelo-vista/utilidades/listado_cobros-view.js?v=1') }}"></script>
<script src="{{ asset('js/modelo-vista/utilidades/listado_cobros-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {
        
        const listadoCobrosView = new ListadoCobrosView(new ListadoCobrosModel(csrf_token));
        listadoCobrosView.listar(null);
        listadoCobrosView.eventos();

    });
</script>
@endsection