@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

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
            <div class="col-md-12 text-left">
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
                        <a class="btn btn-app btn-sm bg-secondary eliminar">
                            <i class="fas fa-ban"></i> Anular
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row mt-2 pt2 pl-2 pr-2 pt-1">
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
                                                <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Folio</label>
                                                <input type="text" class="form-control form-control-sm" name="nro_fol" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                            <input type="text" class="form-control form-control-sm" name="ape_pat_na" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Apellido materno</label>
                                            <input type="text" class="form-control form-control-sm" name="ape_mat_na" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input type="text" class="form-control form-control-sm" name="nom_nac" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Centro Asistencial</label>
                                            <select class="form-control form-control-sm" name="cen_asi">
                                                @foreach ($controlAsistencialList as $centro)
                                                <option value="{{$centro->codigo}}" ">{{$centro->nombre}}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                    </div>
                                    <div class=" col-sm-6">
                                                    <div class="form-group">
                                                        <label>Sexo</label>
                                                        <select class="form-control form-control-sm" name="sex_nac">
                                                            <option value="1">MASCULINO</option>
                                                            <option value="2">FEMENINO</option>
                                                        </select>
                                                    </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Ubigeo</label>
                                                <select class="form-control form-control-sm" name="ubigeo">
                                                    @foreach ($ubigeoList as $ubigeo)
                                                    <option value="{{$ubigeo->codigo}}" ">{{$ubigeo->nombre}}</option>
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
                                                                                        <input type="date" class="form-control form-control-sm" name="fch_nac" placeholder="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
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
                                                                                        <select class="form-control form-control-sm" name="tipo">
                                                                                            @foreach ($tipoRegistroList as $tipo)
                                                                                            <option value="{{$tipo->codigo}}">{{$tipo->nombre}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=" col-sm-6">
                                                                                    <div class="form-group">
                                                                                        <label>Registrador</label>
                                                                                        <input type="text" class="form-control form-control-sm" name="usuario" placeholder="">
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

                                        <div class="col-md-6">

                                            <div class="row mt-2 pt2 pl-2 pr-2 pt-1">
                                                <div class="col-md-12">
                                                    <div class="card card-secondary" id="card-recibo">
                                                        <div class="">
                                                            <h3 class="card-title m-2">Adjuntos</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                                                                    <label class="custom-file-label" for="customFileLang" data-browse="Elegir">Seleccionar Archivo</label>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <table class="table table-bordered">
                                                                    <thead class="thead-dark">
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col" style="width: 70%">Archivo</th>
                                                                            <th scope="col">Acción</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">1</th>
                                                                            <td>Acta Adverso</td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-block btn-outline-primary btn-xs verActaAdverso" id="btnVerActaAdverso" disabled>Descargar</button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">2</th>
                                                                            <td>Acta Reverso</td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-block btn-outline-primary btn-xs verActaReverso" id="btnVerActaReverso" disabled>Descargar</button>
                                                                            </td>
                                                                        </tr>
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
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                                    <label class="form-check-label" for="inlineRadio1">Ordinario</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                                    <label class="form-check-label" for="inlineRadio2">Extraordinario</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                                    <label class="form-check-label" for="inlineRadio3">Especial</label>
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
                                                                <h3 class="card-title m-2">Recibo</h3>
                                                            </div>
                                                            <div class="" id="headingOne">
                                                                <div class="card-body">

                                                                    <div class="col-md-12 text-center">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                            <label class="form-check-label" for="inlineRadio1">Aplica</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                                            <label class="form-check-label" for="inlineRadio2">No aplica</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample" style="">
                                                                <div class="card-body">
                                                                    <form>
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label>Recibo Nro</label>
                                                                                    <input type="text" class="form-control form-control-sm handleNroRecibo" name="nro_recibo" placeholder="" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="form-group">
                                                                                    <label>Solicitante</label>
                                                                                    <input type="text" class="form-control form-control-sm" name="nombre_solicitante_recibo" placeholder="" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label>Fecha</label>
                                                                                    <input type="date" class="form-control form-control-sm" name="fecha_recibo" placeholder="" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="form-group">
                                                                                    <label>Tipo recibo</label>
                                                                                    <select class="form-control form-control-sm" name="tipo_recibo" readOnly>
                                                                                        <option value="1"></option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <div class="form-group">
                                                                                    <label>Importe S/</label>
                                                                                    <input type="text" class="form-control form-control-sm" name="importe_recibo" placeholder="" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="form-group">
                                                                                    <label>&nbsp;</label>
                                                                                    <input type="text" class="form-control form-control-sm" name="detalle_recibo" placeholder="" readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12 text-center">
                                                                                <button type="button" class="btn btn-success btn-block btn-flat guardarRecibo" id="btnGuardarRecibo" disabled><i class="fas fa-save"></i> Guardar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        @include('nacimientos.modal-listado_de_nacimientos')



                                        @endsection

                                        @section('scripts')
                                        <script src=" {{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}">
                                        </script>
                                        <script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
                                        <script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
                                        <script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
                                        <script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>

                                        <script src="{{ asset('js/modelo-vista/nacimientos/control_nacimiento-view.js?v=1') }}"></script>
                                        <script src="{{ asset('js/modelo-vista/nacimientos/control_nacimiento-model.js?v=1') }}"></script>
                                        <!-- <script src="{{ asset('js/tiff.min.js?v=1') }}"></script> -->
                                        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

                                        <script>
                                            $(document).ready(function() {

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