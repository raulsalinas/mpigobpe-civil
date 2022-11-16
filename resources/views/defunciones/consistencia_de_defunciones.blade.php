@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

@endsection

@section('title')Consistencia de Defunciones @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Consistencia de Defunciones</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Defunciones</li>
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
            <div class="row" id="vert-tabs-contenedor">
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-todoLosRegistros-tab" data-toggle="pill" href="#vert-tabs-todoLosRegistros" role="tab" aria-controls="vert-tabs-todoLosRegistros" aria-selected="true">Todo los registros</a>
                        <a class="nav-link" id="vert-tabs-porAño-tab" data-toggle="pill" href="#vert-tabs-porAño" role="tab" aria-controls="vert-tabs-porAño" aria-selected="false">Por año</a>
                        <a class="nav-link" id="vert-tabs-porNumeroDeLibro-tab" data-toggle="pill" href="#vert-tabs-porNumeroDeLibro" role="tab" aria-controls="vert-tabs-porNumeroDeLibro" aria-selected="false">Por nro de libro</a>
                        <a class="nav-link" id="vert-tabs-porFechaDeDefuncion-tab" data-toggle="pill" href="#vert-tabs-porFechaDeDefuncion" role="tab" aria-controls="vert-tabs-porFechaDeDefuncion" aria-selected="false">Por fecha de defunción</a>
                        <a class="nav-link" id="vert-tabs-porRegistrador-tab" data-toggle="pill" href="#vert-tabs-porRegistrador" role="tab" aria-controls="vert-tabs-porRegistrador" aria-selected="false">Por registrador</a>
                    </div>
                </div>
                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane text-left fade active show" id="vert-tabs-todoLosRegistros" role="tabpanel" aria-labelledby="vert-tabs-todoLosRegistros-tab">
                            <form id="todoLosRegistrosForm">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Año *</label>
                                            <input type="text" class="form-control form-control-sm" name="ano_des" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Nro de libro *</label>
                                            <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Registrador </label>
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
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger btn-xs "  data-extension-reporte="pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-success btn-xs "  data-extension-reporte="xls"><i class="fas fa-file-excel"></i> XLS</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porAño" role="tabpanel" aria-labelledby="vert-tabs-porAño-tab">
                            <form id="porAñoForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Año *</label>
                                            <select class="form-control form-control-sm" name="ano_des">
                                                <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1940">1940</option>
                                                <option value="1941">1941</option>
                                                <option value="1942">1942</option>
                                                <option value="1943">1943</option>
                                                <option value="1944">1944</option>
                                                <option value="1945">1945</option>
                                                <option value="1946">1946</option>
                                                <option value="1947">1947</option>
                                                <option value="1948">1948</option>
                                                <option value="1949">1949</option>
                                                <option value="1950">1950</option>
                                                <option value="1951">1951</option>
                                                <option value="1952">1952</option>
                                                <option value="1953">1953</option>
                                                <option value="1954">1954</option>
                                                <option value="1955">1955</option>
                                                <option value="1956">1956</option>
                                                <option value="1957">1957</option>
                                                <option value="1958">1958</option>
                                                <option value="1959">1959</option>
                                                <option value="1960">1960</option>
                                                <option value="1961">1961</option>
                                                <option value="1962">1962</option>
                                                <option value="1963">1963</option>
                                                <option value="1964">1964</option>
                                                <option value="1965">1965</option>
                                                <option value="1966">1966</option>
                                                <option value="1967">1967</option>
                                                <option value="1968">1968</option>
                                                <option value="1969">1969</option>
                                                <option value="1970">1970</option>
                                                <option value="1971">1971</option>
                                                <option value="1972">1972</option>
                                                <option value="1973">1973</option>
                                                <option value="1974">1974</option>
                                                <option value="1975">1975</option>
                                                <option value="1976">1976</option>
                                                <option value="1977">1977</option>
                                                <option value="1978">1978</option>
                                                <option value="1979">1979</option>
                                                <option value="1980">1980</option>
                                                <option value="1981">1981</option>
                                                <option value="1982">1982</option>
                                                <option value="1983">1983</option>
                                                <option value="1984">1984</option>
                                                <option value="1985">1985</option>
                                                <option value="1986">1986</option>
                                                <option value="1987">1987</option>
                                                <option value="1988">1988</option>
                                                <option value="1989">1989</option>
                                                <option value="1990">1990</option>
                                                <option value="1991">1991</option>
                                                <option value="1992">1992</option>
                                                <option value="1993">1993</option>
                                                <option value="1994">1994</option>
                                                <option value="1995">1995</option>
                                                <option value="1996">1996</option>
                                                <option value="1998">1998</option>
                                                <option value="1999">1999</option>
                                                <option value="2000">2000</option>
                                                <option value="2001">2001</option>
                                                <option value="2002">2002</option>
                                                <option value="2003">2003</option>
                                                <option value="2004">2004</option>
                                                <option value="2005">2005</option>
                                                <option value="2006">2006</option>
                                                <option value="2007">2007</option>
                                                <option value="2008">2008</option>
                                                <option value="2009">2009</option>
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger btn-xs "  data-extension-reporte="pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-success btn-xs "  data-extension-reporte="xls"><i class="fas fa-file-excel"></i> XLS</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porNumeroDeLibro" role="tabpanel" aria-labelledby="vert-tabs-porNumeroDeLibro-tab">
                            <form id="porNumeroDeLibroForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nro Libro *</label>
                                            <input type="text" class="form-control form-control-sm" name="nro_lib" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger btn-xs "  data-extension-reporte="pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-success btn-xs "  data-extension-reporte="xls"><i class="fas fa-file-excel"></i> XLS</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porFechaDeDefuncion" role="tabpanel" aria-labelledby="vert-tabs-porFechaDeDefuncion-tab">
                            <form id="porFechaDeDefuncionForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de defunción desde *</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_des_desde" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de defunción hasta *</label>
                                            <input type="date" class="form-control form-control-sm" name="fch_des_hasta" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger btn-xs "  data-extension-reporte="pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-success btn-xs "  data-extension-reporte="xls"><i class="fas fa-file-excel"></i> XLS</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="vert-tabs-porRegistrador" role="tabpanel" aria-labelledby="vert-tabs-porRegistrador-tab">
                            <form id="porRegistradorForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Registrador *</label>
                                            <select class="form-control form-control-sm" name="sex_nac">
                                                <option value="SIN_DATA">Seleccione una opción</option>
                                                <option value="1">MPI</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-danger btn-xs "  data-extension-reporte="pdf"><i class="fas fa-file-pdf"></i> PDF</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-block btn-success btn-xs "  data-extension-reporte="xls"><i class="fas fa-file-excel"></i> XLS</button>
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

<script src="{{ asset('js/modelo-vista/defunciones/consistencia_defuncion-view.js?v=1') }}"></script>
<script src="{{ asset('js/modelo-vista/defunciones/consistencia_defuncion-model.js?v=1') }}"></script>

<script>
    $(document).ready(function() {

        // Inicia -> vista extendida
        let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida

        const consistenciaDefuncionView = new ConsistenciaDefuncionView(new ConsistenciaDefuncionModel(csrf_token));
        consistenciaDefuncionView.eventos();



    });
</script>
@endsection