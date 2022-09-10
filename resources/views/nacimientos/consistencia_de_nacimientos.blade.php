@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('title')Consistencia de Nacimientos @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Consistencia de Nacimiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Nacimientos</li>
                    <li class="breadcrumb-item active">Consistencia</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content text-center">
    <div class="card card-default card-outline">
        <div class="">
            <h3 class="card-title m2"></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-todoLosRegistros-tab" data-toggle="pill" href="#vert-tabs-todoLosRegistros" role="tab" aria-controls="vert-tabs-todoLosRegistros" aria-selected="true">Todo los registros</a>
                        <a class="nav-link" id="vert-tabs-porAño-tab" data-toggle="pill" href="#vert-tabs-porAño" role="tab" aria-controls="vert-tabs-porAño" aria-selected="false">Por año</a>
                        <a class="nav-link" id="vert-tabs-porNumeroDeLibro-tab" data-toggle="pill" href="#vert-tabs-porNumeroDeLibro" role="tab" aria-controls="vert-tabs-porNumeroDeLibro" aria-selected="false">Por nro de libro</a>
                        <a class="nav-link" id="vert-tabs-porSexo-tab" data-toggle="pill" href="#vert-tabs-porSexo" role="tab" aria-controls="vert-tabs-porSexo" aria-selected="false">Por sexo</a>
                        <a class="nav-link" id="vert-tabs-porFechaDeNacimiento-tab" data-toggle="pill" href="#vert-tabs-porFechaDeNacimiento" role="tab" aria-controls="vert-tabs-porFechaDeNacimiento" aria-selected="false">Por fecha de nacimiento</a>
                        <a class="nav-link" id="vert-tabs-porLugaroUbicacion-tab" data-toggle="pill" href="#vert-tabs-porLugaroUbicacion" role="tab" aria-controls="vert-tabs-porLugaroUbicacion" aria-selected="false">Por lugar ó ubicación</a>
                        <a class="nav-link" id="vert-tabs-porRegistrador-tab" data-toggle="pill" href="#vert-tabs-porRegistrador" role="tab" aria-controls="vert-tabs-porRegistrador" aria-selected="false">Por registrador</a>
                        <!-- <a class="nav-link" id="vert-tabs-librosEstructurados-tab" data-toggle="pill" href="#vert-tabs-librosEstructurados" role="tab" aria-controls="vert-tabs-librosEstructurados" aria-selected="false">libros estructurados</a> -->
                        <a class="nav-link" id="vert-tabs-porCentroAsistencial-tab" data-toggle="pill" href="#vert-tabs-porCentroAsistencial" role="tab" aria-controls="vert-tabs-porCentroAsistencial" aria-selected="false">Por centros asistenciales</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade active show" id="vert-tabs-todoLosRegistros" role="tabpanel" aria-labelledby="vert-tabs-todoLosRegistros-tab">
                            <form id="todoLosRegistrosForm">
                           
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Año</label>
                                            <input type="text" class="form-control form-control-sm" name="ano_nac" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Nro de libro</label>
                                            <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Sexo</label>
                                            <select class="form-control form-control-sm" name="sex_nac">
                                            <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1">MASCULINO</option>
                                                <option value="2">FEMENINO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Ubigeo</label>
                                                <select class="form-control form-control-sm" name="ubigeo">
                                                    <option value="SIN_DATA">Seleccione una opción</option>
                                                    @foreach ($ubigeoList as $ubigeo)
                                                    <option value="{{$ubigeo->codigo}}">{{$ubigeo->nombre}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Registrador</label>
                                            <select class="form-control form-control-sm" name="usuario">
                                                <option value="SIN_DATA">Seleccione una opción</option>
                                                    @foreach ($usuarioList as $usuario)
                                                    <option value="{{$usuario->id}}">{{$usuario->usuario}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Centro</label>
                                            <select class="form-control form-control-sm" name="cen_asi">
                                                <option value="SIN_DATA">Seleccione una opción</option>
                                                @foreach ($controlAsistencialList as $centro)
                                                <option value="{{$centro->codigo}}" ">{{$centro->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Desde</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_nac_desde" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hasta</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_nac_hasta" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaTodoLosRegistros">Ejecutar</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porAño" role="tabpanel" aria-labelledby="vert-tabs-porAño-tab">
                            <form id="porAñoForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Año</label>
                                            <select class="form-control form-control-sm" name="sex_nac">
                                            <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1997">1997</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="1999">2000</option>
                                                <option value="1999">2001</option>
                                                <option value="1999">2002</option>
                                                <option value="1999">2003</option>
                                                <option value="1999">2004</option>
                                                <option value="1999">2005</option>
                                                <option value="1999">2006</option>
                                                <option value="1999">2007</option>
                                                <option value="1999">2008</option>
                                                <option value="1999">2009</option>
                                                <option value="1999">2010</option>
                                                <option value="1999">2011</option>
                                                <option value="1999">2012</option>
                                                <option value="1999">2013</option>
                                                <option value="1999">2014</option>
                                                <option value="1999">2015</option>
                                                <option value="1999">2016</option>
                                                <option value="1999">2017</option>
                                                <option value="1999">2018</option>
                                                <option value="1999">2019</option>
                                                <option value="1999">2020</option>
                                                <option value="1999">2021</option>
                                                <option value="1999">2022</option>
                                            </select>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorAño">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porNumeroDeLibro" role="tabpanel" aria-labelledby="vert-tabs-porNumeroDeLibro-tab">
                            <form id="porNumeroDeLibroForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nro Libro</label>
                                            <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorNumeroDeLibro">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porSexo" role="tabpanel" aria-labelledby="vert-tabs-porSexo-tab">
                            <form id="porSexoForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sexo</label>
                                            <select class="form-control form-control-sm" name="sex_nac">
                                            <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1">MASCULINO</option>
                                                <option value="2">FEMENINO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorSexo">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porFechaDeNacimiento" role="tabpanel" aria-labelledby="vert-tabs-porFechaDeNacimiento-tab">
                            <form id="porFechaDeNacimientoForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de nacimiento</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_nac" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorFechaDeNacimiento">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porLugaroUbicacion" role="tabpanel" aria-labelledby="vert-tabs-porLugaroUbicacion-tab">
                            <form id="porLugaroUbicacionForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Ubigeo</label>
                                            <select class="form-control form-control-sm" name="ubigeo">
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($ubigeoList as $ubigeo)
                                                <option value="{{$ubigeo->codigo}}">{{$ubigeo->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorLugaroUbicacion">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porRegistrador" role="tabpanel" aria-labelledby="vert-tabs-porRegistrador-tab">
                            <form id="porRegistradorForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Registrador</label>
                                            <select class="form-control form-control-sm" name="sex_nac">
                                            <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1">MPI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorRegistrador">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="tab-pane fade" id="vert-tabs-librosEstructurados" role="tabpanel" aria-labelledby="vert-tabs-librosEstructurados-tab">
                            <form id="librosEstructuradosForm">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Desde</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_nac" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Hasta</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_ing" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaLibrosEstructurados">Ejecutar</button>
                                    </div>
                                </div>
                            </form>
                        </div> -->
                        <div class="tab-pane fade" id="vert-tabs-porCentroAsistencial" role="tabpanel" aria-labelledby="vert-tabs-porCentroAsistencial-tab">
                            <form id="porCentroAsistencialForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Centro asistencial</label>
                                            <select class="form-control form-control-sm" name="sex_nac">
                                            <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1">C.S Miramar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-success btn-xs ejecutarConsistenciaPorCentroAsistencial">Ejecutar</button>
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

@endsection

@section('scripts')
<script src="{{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>

<script src="{{ asset('js/modelo-vista/nacimientos/consistencia_nacimiento-view.js?v=1') }}"></script>
<script src="{{ asset('js/modelo-vista/nacimientos/consistencia_nacimiento-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {

        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida

        const consistenciaNacimientoView = new ConsistenciaNacimientoView(new ConsistenciaNacimientoModel(csrf_token));
        consistenciaNacimientoView.eventos();



    });
</script>
@endsection