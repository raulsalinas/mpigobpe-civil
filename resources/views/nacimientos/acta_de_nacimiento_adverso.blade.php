@extends('themes/layout')

@section('links')
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/lte_3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<style>
    canvas {
        
        width: 100vh;
        transform: rotate(90deg);


    }
</style>
@endsection

@section('title')Actas de Nacimientos Adverso@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Acta de Nacimiento Adverso</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Nacimientos</li>
                    <li class="breadcrumb-item active">Acta Adverso</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content text-center">
    <div class="actaNacimientoAdversoTIF"></div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/lte_3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lte_3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/tiff.min.js?v=1') }}"></script>

<!-- <script src="{{ asset('js/modelo-vista/nacimientos/nacimiento-view.js?v=1') }}"></script>
<script src="{{ asset('js/modelo-vista/nacimientos/nacimiento-model.js?v=1') }}"></script> -->

<script>
    $(document).ready(function() {
        
         // Inicia -> vista extendida
         let body = document.getElementsByTagName("body")[0];
        body.classList.add("sidebar-collapse");
        // termina -> vista extendida

        var xhrA = new XMLHttpRequest();
        xhrA.responseType = 'arraybuffer';
        xhrA.open('GET', "/fichas/nacim/1997061424.tif");
        xhrA.onload = function(e) {
            var tiff = new Tiff({
                buffer: xhrA.response
            });
            var canvas = tiff.toCanvas();
            document.querySelector("div[class~='actaNacimientoAdversoTIF']").append(canvas);
        };
        xhrA.send();
 


    });
</script>
@endsection