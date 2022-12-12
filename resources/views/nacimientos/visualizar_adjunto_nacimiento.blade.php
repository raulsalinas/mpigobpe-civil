@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<style>
    canvas {

        width: 100vh;
        transform: rotate(-90deg);


    }
</style>
@endsection

@section('title')Adjunto de Nacimientos @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mb-2" style="display: flex;">Adjunto de Nacimiento <div style="font-size: 0.9rem;padding: 4px;"><span class="badge badge-pill badge-secondary" id="claveLibroAño"></span> <span class="badge badge-pill badge-secondary" id="claveLibroLibro"></span> <span class="badge badge-pill badge-secondary" id="claveLibroFolio"></span> <span class="badge badge-pill badge-secondary" id="claveLibroCondic"></span></div></h1>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-primary" onclick="impirmirHoja()"><i class="fas fa-print"></i> Imprimir</button>
                    <button type="button" class="btn btn-outline-primary" onclick="girarMenos90()"><i class="fas fa-undo"></i> -90º</button>
                    <button type="button" class="btn btn-outline-primary" onclick="girarMas90()"><i class="fas fa-redo"></i> +90º</button>
                </div>

            </div>
            <div class="col-sm-6">
                <div style="display: flex;flex-wrap: wrap;justify-content: end;">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Inicio</li>
                        <li class="breadcrumb-item">Nacimientos</li>
                        <li class="breadcrumb-item active">Adjunto</li>
                    </ol>

                    <div id="contenedorAdjuntoList">
                        <ul class="nav justify-content-end">
                            @foreach ($adjuntos as $adjunto)
                            <li class="nav-item" style="padding-left: 1rem;">
                                <a class="nav-link btn btn-outline-primary" href="/nacimientos/control/visualizar-adjunto/?idregistro={{$adjunto['idRegistro']}}&namefile={{$adjunto['nameFile']}}&year={{$adjunto['year']}}&book={{$adjunto['book']}}&folio={{$adjunto['folio']}}&condic={{$adjunto['condic']}}">{{$adjunto['nameFile']}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<div class="content ">
    <div class="row">
        <div class="col-md-9 text-center">
            <div class="actaNacimientoAdversoTIF"></div>
            <div class="actaNacimientoAdversoPDF"></div>
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
<script src="{{ asset('js/tiff.min.js')}}?v={{filemtime(public_path('js/tiff.min.js'))}}"></script>
<script src="{{ asset('js/modelo-vista/nacimientos/visualizar_nacimiento.js')}}?v={{filemtime(public_path('js/modelo-vista/nacimientos/visualizar_nacimiento.js'))}}"></script>



@endsection