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

@section('title')Adjunto de Defunción @endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="mb-2" style="display: flex;">Adjunto de Defunción <div style="font-size: 0.9rem;padding: 4px;"><span class="badge badge-pill badge-secondary" id="claveLibroAño"></span> <span class="badge badge-pill badge-secondary" id="claveLibroLibro"></span> <span class="badge badge-pill badge-secondary" id="claveLibroFolio"></span> <span class="badge badge-pill badge-secondary" id="claveLibroCondic"></span></div></h1>
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
                        <li class="breadcrumb-item">Defunción</li>
                        <li class="breadcrumb-item active">Adjunto</li>
                    </ol>
                    <div id="contenedorAdjuntoList">
                        <ul class="nav justify-content-end">
                            @foreach ($adjuntos as $adjunto)
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="/defunciones/control/visualizar-adjunto/?idregistro={{$adjunto['idRegistro']}}&namefile={{$adjunto['nameFile']}}&year={{$adjunto['year']}}&book={{$adjunto['book']}}&folio={{$adjunto['folio']}}&condic={{$adjunto['condic']}}">{{$adjunto['nameFile']}}</a>
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
            <div class="actaDefuncionAdversoTIF"></div>
            <div class="actaDefuncionAdversoPDF"></div>
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

<script>
    var rotate = 0;

    function impirmirHoja() {
        window.print();

    }

    function girarMenos90() {
        rotate += 90;
        document.querySelector("canvas").style.transform = "rotate(-" + rotate + "deg)";

    }

    function girarMas90() {
        rotate += 90;
        document.querySelector("canvas").style.transform = "rotate(+" + rotate + "deg)";
    }

    function getCarpetaPadreCondicion(idCondic) {
        switch (parseInt(idCondic)) {
            case 1:
                return 'ordinarias';
                break;

            case 2:
                return 'extraordinarias';
                break;

            case 3:
                return 'especiales';
                break;

            default:
                return 'ordinarias';
                break;
        }
    }

    function prepareCanvas() {

        let nameFileByURL = (location.search.split('namefile=')[1]).split('&')[0];
        let yearByURL = parseInt(location.search.split('year=')[1]);
        let bookByURL = parseInt(location.search.split('book=')[1]);
        let folioByURL = parseInt(location.search.split('folio=')[1]);
        let condicByURL = parseInt(location.search.split('condic=')[1]);
        document.querySelector("span[id='claveLibroAño']").textContent = 'Año: ' + (toString(yearByURL).length > 0 ? yearByURL : 'S/N');
        document.querySelector("span[id='claveLibroLibro']").textContent = 'Libro: ' + (toString(bookByURL).length > 0 ? bookByURL : 'S/N');
        document.querySelector("span[id='claveLibroFolio']").textContent = 'Folio: ' + (toString(folioByURL).length > 0 ? folioByURL : 'S/N');
        document.querySelector("span[id='claveLibroCondic']").textContent = 'Condición: ' + (toString(condicByURL).length > 0 ? getCarpetaPadreCondicion(condicByURL) : 'S/C');
        if ((nameFileByURL) != null && nameFileByURL.length > 0) {
            // Inicia -> vista extendida
            let body = document.getElementsByTagName("body")[0];
            body.classList.add("sidebar-collapse");
            // termina -> vista extendida

            var xhrA = new XMLHttpRequest();
            xhrA.responseType = 'arraybuffer';
            xhrA.open('GET', "/fichas/"+getCarpetaPadreCondicion()+"/defun/" + nameFileByURL);
            xhrA.onload = function(e) {
                var tiff = new Tiff({
                    buffer: xhrA.response
                });
                var canvas = tiff.toCanvas();
                document.querySelector("div[class~='actaDefuncionAdversoTIF']").append(canvas);
            };
            xhrA.send();
        }
    }

    function prepareFrame() {
        let nameFileByURL = (location.search.split('namefile=')[1]).split('&')[0];
        var ifrm = document.createElement("iframe");
        ifrm.setAttribute("src", "/fichas/"+getCarpetaPadreCondicion()+"/defun/" + nameFileByURL);
        ifrm.style.width = "800px";
        ifrm.style.height = "600px";
        ifrm.style.border = "none";
        document.querySelector("div[class='actaDefuncionAdversoPDF']").appendChild(ifrm);
    }

    let yearByURL = parseInt(location.search.split('year=')[1]);
    if ((location.search.split('namefile=')[1]).split('&')[0].split('.')[1] == 'pdf') {
        prepareFrame();
    }
    if ((location.search.split('namefile=')[1]).split('&')[0].split('.')[1] == 'tif') {
        prepareCanvas();
    }

    if (document.querySelector("div[id='contenedorAdjuntoList'] ul").childElementCount) { // si existe adjuntos en la lista , se cargará el primero, verificando que fileName es undefined entonces cargará el primer adjunto de la lista por defecto
        const sizeAdjList = document.querySelector("div[id='contenedorAdjuntoList'] ul").children.length;
        if (sizeAdjList > 0) {
            if ([undefined, 'undefined'].includes((location.search.split('namefile=')[1]).split('&')[0])) {
                document.querySelector("div[id='contenedorAdjuntoList'] ul").children[0].querySelector("a").click()
            }
        }
    }
</script>
@endsection