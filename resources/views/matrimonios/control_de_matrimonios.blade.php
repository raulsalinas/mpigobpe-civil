@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/select2/css/select2.min.css') }}">

@endsection

@section('title')Control de Matrimonios @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Control de Matrimonios <span name="nombreCondicionActa">{{$tipo}}</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Matrimonios <span name="nombreCondicionActa">{{$tipo}}</span></li>
                    <li class="breadcrumb-item active">Control</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <form id="controlMatrimoniosForm" enctype="multipart/form-data" name="matrimonios" idtipo="2">
            @csrf
                <input type="text" style="display:none;" name="id">
                <input type="text" style="display:none;" name="condicionActa">
                <div class="row">
                <div class="col-md-7 text-left">
                    <div class="" id="botoneraPrincipal">
                        <div class="card-body">
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
                                                        <label>Año ejecución</label>
                                                        <input type="text" class="form-control form-control-sm" name="ano_eje" placeholder="" readonly>
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
                                        <h3 class="card-title m-2">Del marido</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellidos</label>
                                                    <input type="text" class="form-control form-control-sm" name="ape_mar" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nombres</label>
                                                    <input type="text" class="form-control form-control-sm" name="nom_mar" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Ubigeo</label>
                                                    <select class="form-control form-control-sm select2" name="ubigeo1" readonly>
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
                            <div class="col-md-12">
                                <div class="card card-secondary">
                                    <div class="">
                                        <h3 class="card-title m-2">De la esposa</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Apellidos</label>
                                                    <input type="text" class="form-control form-control-sm" name="ape_esp" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nombres</label>
                                                    <input type="text" class="form-control form-control-sm" name="nom_esp" placeholder="" readonly>
                                                </div>
                                            </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Ubigeo</label>
                                                        <select class="form-control form-control-sm select2" name="ubigeo2" readonly>
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
                                                            <label>Celebración</label>
                                                            <input type="date" class="form-control form-control-sm" name="fch_cel" placeholder="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Inscripción</label>
                                                            <input type="date" class="form-control form-control-sm" name="fch_reg" placeholder="" readonly>
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
                                                                <option value="SIN_DATA">Seleccione una opción</option>
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
                                                <input type="file" multiple class="custom-file-input handleChangeAgregarAdjunto" id="adjuntosMatrimonio" name="adjuntosMatrimonio" lang="es" disabled>
                                                <label class="custom-file-label" for="adjuntosMatrimonio" data-label="Elegir">
                                                    <span class="d-inline-block text-truncate w-75">
                                                        Elige varios archivos
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <table class="table table-bordered" id="tablaListaAdjuntos">
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
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="">
                                            <h3 class="card-title m-2">Observacion</h3>
                                        </div>
                                        <div class="" id="headingOne">
                                            <div class="card-body">
                                                <input type="text" style="display:none;" name="observa">
                                                <div class="text-wrap text-uppercase" name="observa"></div>
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

@include('matrimonios.modal-listado_de_matrimonios')
@include('matrimonios.modal-recibo')



@endsection

@section('scripts')
<script src=" {{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/modelo-vista/matrimonios/control_matrimonio-view.js')}}?v={{filemtime(public_path('js/modelo-vista/matrimonios/control_matrimonio-view.js'))}}"></script>
<script src="{{ asset('js/modelo-vista/matrimonios/control_matrimonio-model.js?v=3') }}"></script>
<script src="{{ asset('js/modelo-vista/adjuntos/adjunto-view.js')}}?v={{filemtime(public_path('js/modelo-vista/adjuntos/adjunto-view.js'))}}"></script>
<script src="{{ asset('js/modelo-vista/adjuntos/adjunto-model.js')}}?v={{filemtime(public_path('js/modelo-vista/adjuntos/adjunto-model.js'))}}"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();

        $('.select2').select2();

        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida

        const controlMatrimonioView = new ControlMatrimonioView(new ControlMatrimonioModel(csrf_token));
        controlMatrimonioView.obtenerMatrimonio();
        controlMatrimonioView.eventos();

        const adjuntoView = new AdjuntoView(new AdjuntoModel(csrf_token));
        adjuntoView.eventos();


    });
</script>
@endsection