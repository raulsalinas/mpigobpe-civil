@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
 
@endsection

@section('title')Control de Nacimientos @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control de Nacimientos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Nacimientos</li>
                    <li class="breadcrumb-item active">Control</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <form id="controlNacimientoForm" enctype="multipart/form-data">
            @csrf
                <input type="text" style="display:none;" name="id">
                <div class="row">
                <div class="col-md-7 text-left">
                    <div class="" id="botoneraPrincipal">
                        <div class="card-body">
                            <a class="btn btn-app btn-sm bg-secondary buscar">
                                <i class="fas fa-search"></i> Buscar
                            </a>
                            <a class="btn btn-app btn-sm bg-secondary imprimir">
                                <i class="fas fa-print"></i> Imprimir
                            </a>
                            <a class="btn btn-app btn-sm bg-secondary nuevo">
                                <i class="fas fa-file"></i> Nuevo
                            </a>
                            <a class="btn btn-app btn-sm bg-secondary guardar">
                                <i class="fas fa-save"></i> Guardar
                            </a>
                            <a class="btn btn-app btn-sm bg-secondary modificar">
                                <i class="fas fa-edit"></i> Modificar
                            </a>
                            <a class="btn btn-app btn-sm bg-secondary observar">
                                <i class="fas fa-exclamation-triangle"></i> Observar
                            </a>
                            <a class="btn btn-app btn-sm bg-secondary cancelar">
                                <i class="fas fa-cancel"></i> Cancelar
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-right">
                    <div class="card-body">
                        <h3> <span class="badge badge-light" style="text-decoration: underline;" id="descripcion-de-accion-formulario"></span></h3>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mt-2 pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-12">
                                <div class="card card-secondary">
                                    <div class="">
                                        <h3 class="card-title m-2">Claves de libro</h3>
                                    </div>
                                    <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Año</label>
                                                        <input type="text" class="form-control form-control-sm" name="ano_nac" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Libro</label>
                                                        <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Folio</label>
                                                        <input type="text" class="form-control form-control-sm" name="nro_fol" placeholder="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-12">
                                <div class="card card-secondary">
                                    <div class="">
                                        <h3 class="card-title m-2">Del nacido</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellido paterno</label>
                                                    <input type="text" class="form-control form-control-sm" name="ape_pat_na" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellido materno</label>
                                                    <input type="text" class="form-control form-control-sm" name="ape_mat_na" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Nombres</label>
                                                    <input type="text" class="form-control form-control-sm" name="nom_nac" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Centro Asistencial</label>
                                                    <select class="form-control form-control-sm" name="cen_asi" readonly>
                                                        <option value="">Seleccione una opción</option>
                                                        @foreach ($controlAsistencialList as $centro)
                                                        <option value="{{$centro->codigo}}" ">{{$centro->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class=" col-sm-6">
                                                <div class="form-group">
                                                    <label>Sexo</label>
                                                    <select class="form-control form-control-sm" name="sex_nac" readonly>
                                                        <option value="">Seleccione una opción</option>
                                                        <option value="1">MASCULINO</option>
                                                        <option value="2">FEMENINO</option>
                                                    </select>
                                                </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Ubigeo</label>
                                                        <select class="form-control form-control-sm" name="ubigeo" readonly>
                                                            <option value="">Seleccione una opción</option>
                                                            @foreach ($ubigeoList as $ubigeo)
                                                            <option value="{{$ubigeo->codigo}}">{{$ubigeo->nombre}}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" row pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="">
                                                <h3 class="card-title m-2">Fechas</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nacimiento</label>
                                                            <input type="date" class="form-control form-control-sm" name="fch_nac" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Inscripción</label>
                                                            <input type="date" class="form-control form-control-sm" name="fch_ing" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                                            <select class="form-control form-control-sm" name="tipo" readonly>
                                                                <option value="">Seleccione una opción</option>
                                                                @foreach ($tipoRegistroList as $tipo)
                                                                <option value="{{$tipo->codigo}}">{{$tipo->nombre}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class=" col-sm-6">
                                                        <div class="form-group">
                                                            <label>Registrador</label>
                                                            <input type="text" class="form-control form-control-sm" name="usuario" placeholder="{{$usuario}}" value="{{$usuario}}" disabled >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-6">
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
                                                            <input type="text" class="form-control form-control-sm" name="ape_pat_ma" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Apellido materno</label>
                                                            <input type="text" class="form-control form-control-sm" name="ape_mat_ma" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Nombre</label>
                                                            <input type="text" class="form-control form-control-sm" name="nom_mad" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Dirección</label>
                                                            <input type="text" class="form-control form-control-sm" name="dir_mad" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-secondary">
                                            <div class="">
                                                <h3 class="card-title m-2">Datos del padre</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Apellido paterno</label>
                                                            <input type="text" class="form-control form-control-sm" name="ape_pat_pa" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Apellido materno</label>
                                                            <input type="text" class="form-control form-control-sm" name="ape_mat_pa" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Nombre</label>
                                                            <input type="text" class="form-control form-control-sm" name="nom_pad" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Dirección</label>
                                                            <input type="text" class="form-control form-control-sm" name="dir_pad" placeholder="" readonly>
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
                    <div class="col-md-6">
                        <div class="row mt-2 pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-12">
                                <div class="card card-secondary" id="card-recibo">
                                    <div class="">
                                        <h3 class="card-title m-2">Adjuntos</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="custom-file mt-2">
                                                <input type="file" multiple class="custom-file-input handleChangeAgregarAdjunto" id="adjuntosNacimiento" name="adjuntosNacimiento" lang="es" disabled>
                                                <label class="custom-file-label" for="adjuntosNacimiento" data-label="Elegir">
                                                    <span class="d-inline-block text-truncate w-75">
                                                        Elige varios archivos
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <table class="table table-bordered" id="tablaListaAdjuntosDeNacimiento">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col" style="width: 70%">Archivo</th>
                                                        <th scope="col">Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
    
                        <div class="row mt-2 pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-12">
                                <div class="card card-secondary" id="card-recibo">
                                    <div class="">
                                        <h3 class="card-title m-2"></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="condicionActa" id="condicionOrdinaria" value="1" checked>
                                                <label class="form-check-label" for="condicionOrdinaria">Ordinario</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="condicionActa" id="condicionExtraordinaria" value="2">
                                                <label class="form-check-label" for="condicionExtraordinaria">Extraordinario</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="condicionActa" id="condicionEspecial" value="3">
                                                <label class="form-check-label" for="condicionEspecial">Especial</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-2 pt2 pl-2 pr-2 pt-1">
                            <div class="col-md-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="">
                                            <h3 class="card-title m-2">Observacion</h3>
                                        </div>
                                        <div class="" id="headingOne">
                                            <div class="card-body">
                                                <div class="text-wrap text-uppercase" name="observa">
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('nacimientos.modal-listado_de_nacimientos')
@include('nacimientos.modal-recibo')



@endsection

@section('scripts')
<script src=" {{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="{{ asset('js/modelo-vista/nacimientos/control_nacimiento-view.js?v=2') }}"></script>
<script src="{{ asset('js/modelo-vista/nacimientos/control_nacimiento-model.js?v=2') }}"></script>
<!-- <script src="{{ asset('js/tiff.min.js?v=1') }}"></script> -->

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

  

        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida

        const controlNacimientoView = new ControlNacimientoView(new ControlNacimientoModel(csrf_token));
        controlNacimientoView.obtenerNacimiento();
        controlNacimientoView.eventos();


    });
</script>
@endsection