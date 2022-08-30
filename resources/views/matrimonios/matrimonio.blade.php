@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('title')Listado de Matrimonios @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Matrimonio</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Matrimonios</li>
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
                        <h3 class="card-title m-2">Listado de matrimonios</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tablaMatrimonio">
                                        <thead>
                                            <tr>
                                                <th width="10">N°</th>
                                                <th width="10">Año</th>
                                                <th width="10">Nro. Libro</th>
                                                <th width="10">Nro. Folio</th>
                                                <th width="50">Apellido Paterno del Esposo</th>
                                                <th width="50">Apellido Matero del Esposo</th>
                                                <th width="50">Nombres del Esposo</th>
                                                <th width="50">Apellido Paterno del Esposa</th>
                                                <th width="50">Apellido Matero del Esposa</th>
                                                <th width="50">Nombres del Esposa</th>
                                                <th width="20">Fecha</th>
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

<div class="modal fade" id="modalNacimiento" tabindex="-1" role="dialog" aria-labelledby="modal-nacimiento">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formulario" method="POST" autocomplete="off">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="id" value="0">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">

                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-registro-tab" data-toggle="pill" href="#custom-tabs-three-registro" role="tab" aria-controls="custom-tabs-three-registro" aria-selected="true">Registro</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-visor-tab" data-toggle="pill" href="#custom-tabs-three-visor" role="tab" aria-controls="custom-tabs-three-visor" aria-selected="false">Visor</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="custom-tabs-three-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-three-registro" role="tabpanel" aria-labelledby="custom-tabs-three-registro-tab">
                                <BR>
                                <!--  -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="">
                                                <h3 class="card-title m-2">Claves de libro</h3>
                                            </div>
                                            <div class="card-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Año</label>
                                                                <input type="text" class="form-control form-control-sm" name="ano_eje" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Libro</label>
                                                                <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="" disabled="">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Folio</label>
                                                                <input type="text" class="form-control form-control-sm" name="nro_fol" placeholder="" disabled="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <!--  -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="">
                                                <h3 class="card-title m-2">Del nacido</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Apellido paterno</label>
                                                            <input type="text" class="form-control form-control-sm" name="ape_pat_na" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Apellido materno</label>
                                                            <input type="text" class="form-control form-control-sm" name="ape_mat_na" placeholder="" disabled="">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Nombres</label>
                                                            <input type="text" class="form-control form-control-sm" name="nom_nac" placeholder="" disabled="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Centro Asistencial</label>
                                                            <select name="sexo" class="form-control form-control-sm-sm" name="cen_asi" >
                                                                <option value="centro">centro</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Sexo</label>
                                                            <select name="sexo" class="form-control form-control-sm-sm" name="sexo">
                                                                <option value="1">MASCULINO</option>
                                                                <option value="2">FEMENINO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>Ubigeo</label>
                                                            <select name="sexo" class="form-control form-control-sm-sm" d="ubigeo">
                                                                <option value="" selected disabled>Elija un opción</option>
                                                                <option value="1">ILO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--  -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-secondary">
                                                    <div class="">
                                                        <h3 class="card-title m-2">Fechas</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Nacimiento</label>
                                                                    <input type="date" class="form-control form-control-sm" name="fch_nac" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Inscripción</label>
                                                                    <input type="date" class="form-control form-control-sm" name="fch_ing" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="col-md-6">
                                        <!--  -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-secondary">
                                                    <div class="">
                                                        <h3 class="card-title m-2">Datos de registrador</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Tipo de registro</label>
                                                                    <input type="date" class="form-control form-control-sm" name="tipo_reg" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Registrador</label>
                                                                    <input type="date" class="form-control form-control-sm" name="registrador" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--  -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-secondary">
                                                    <div class="">
                                                        <h3 class="card-title m-2">De la madre</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Apellido paterno</label>
                                                                    <input type="text" class="form-control form-control-sm" name="ape_pat_ma" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Apellido materno</label>
                                                                    <input type="text" class="form-control form-control-sm" name="ape_mat_ma" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Nombre</label>
                                                                    <input type="text" class="form-control form-control-sm" name="nom_mad" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Dirección</label>
                                                                    <input type="text" class="form-control form-control-sm" name="dir_mad" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="col-md-6">
                                        <!--  -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-secondary">
                                                    <div class="">
                                                        <h3 class="card-title m-2">Datos de registrador</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Apellido paterno</label>
                                                                    <input type="text" class="form-control form-control-sm" name="ape_pat_pa" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Apellido materno</label>
                                                                    <input type="text" class="form-control form-control-sm" name="ape_mat_pa" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Nombre</label>
                                                                    <input type="text" class="form-control form-control-sm" name="nombres_pa" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Dirección</label>
                                                                    <input type="text" class="form-control form-control-sm" name="dire_pa" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-three-visor" role="tabpanel" aria-labelledby="custom-tabs-three-visor-tab">
                                <div class="actaNacimientoTIF" src="{{ asset('fichas//nacim/1997061395.tif')}}" style="width:100px">
                             </div>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-pill btn-success shadow-none" id="btnGuardar">Guardar</button>
                    </div>
                </div>
            </form>
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
<script src="{{('/js/logistica/orden/RequerimientoPendienteModel.js')}}?v={{filemtime(public_path('/js/logistica/orden/RequerimientoPendienteModel.js'))}}"></script>

<script src="{{ asset('js/modelo-vista/nacimientos/nacimiento-view.js?v=1') }}?v={{filemtime(public_path(asset('js/modelo-vista/nacimientos/nacimiento-view.js')))}}"></script>
<script src="{{ asset('js/modelo-vista/nacimientos/nacimiento-model.js?v=1') }}?v={{filemtime(public_path(asset('js/modelo-vista/nacimientos/nacimiento-view.js')))}}"></script>
<script src="{{ asset('js/tiff.min.js?v=1') }}"></script>

<script>
    $(document).ready(function() {
        const nacimientoView = new NacimientoView(new NacimientoModel(csrf_token));
        nacimientoView.listar();
        nacimientoView.eventos();
        // nacimientoView.cambiarLongitud();


        var xhr = new XMLHttpRequest();
xhr.responseType = 'arraybuffer';
xhr.open('GET', "/fichas/nacim/1997061395.tif");
xhr.onload = function (e) {
  var tiff = new Tiff({buffer: xhr.response});
  var canvas = tiff.toCanvas();
  document.querySelector("div[class~='actaNacimientoTIF']").append(canvas);
};
xhr.send();


    });
</script>
@endsection