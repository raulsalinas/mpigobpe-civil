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

@section('title')Adjunto de Matrimonio @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="mb-2">Adjunto de Matrimonio <span class="badge badge-pill badge-secondary" id="claveLibroAño"></span> <span class="badge badge-pill badge-secondary" id="claveLibroLibro"></span> <span class="badge badge-pill badge-secondary" id="claveLibroFolio"></span></h1>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-primary" onclick="impirmirHoja()"><i class="fas fa-print"></i> Imprimir</button>
                    <button type="button" class="btn btn-outline-primary" onclick="girarMenos90()"><i class="fas fa-undo"></i> -90º</button>
                    <button type="button" class="btn btn-outline-primary" onclick="girarMas90()"><i class="fas fa-redo"></i> +90º</button>
                </div>

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Inicio</li>
                    <li class="breadcrumb-item">Matrimonio</li>
                    <li class="breadcrumb-item active">Adjunto</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content ">

    <div class="row">
        <div class="col-md-12 text-center">
            <div class="actaMatrimonioAdversoTIF"></div>
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
<script src="{{ asset('js/tiff.min.js?v=1') }}"></script>

<script>
    var rotate=0;
    function impirmirHoja() {                      
        window.print();

    }
    function girarMenos90() {
        rotate+=90;
        document.querySelector("canvas").style.transform="rotate(-"+rotate+"deg)";
        
    }
    function girarMas90() {
        rotate+=90;
        document.querySelector("canvas").style.transform="rotate(+"+rotate+"deg)";


    }

    $(document).ready(function() {

        let nameFileByURL = (location.search.split('namefile=')[1]).split('?')[0];
        let yearByURL = parseInt(location.search.split('year=')[1]);
        let bookByURL = parseInt(location.search.split('book=')[1]);
        let folioByURL = parseInt(location.search.split('folio=')[1]);
        document.querySelector("span[id='claveLibroAño']").textContent = 'Año: ' + (toString(yearByURL).length > 0 ? yearByURL : 'S/N');
        document.querySelector("span[id='claveLibroLibro']").textContent = 'Libro: ' + (toString(bookByURL).length > 0 ? bookByURL : 'S/N');
        document.querySelector("span[id='claveLibroFolio']").textContent = 'Folio: ' + (toString(folioByURL).length > 0 ? folioByURL : 'S/N');
        if ((nameFileByURL) != null && nameFileByURL.length >0) {
            // Inicia -> vista extendida
            let body = document.getElementsByTagName("body")[0];
            body.classList.add("sidebar-collapse");
            // termina -> vista extendida

            var xhrA = new XMLHttpRequest();
            xhrA.responseType = 'arraybuffer';
            xhrA.open('GET', "/fichas/matri/" + nameFileByURL );
            xhrA.onload = function(e) {
                var tiff = new Tiff({
                    buffer: xhrA.response
                });
                var canvas = tiff.toCanvas();
                document.querySelector("div[class~='actaMatrimonioAdversoTIF']").append(canvas);
            };
            xhrA.send();
        }





    });
</script>
@endsection