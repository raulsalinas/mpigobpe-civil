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
        xhrA.open('GET', "/fichas/" + getCarpetaPadreCondicion() + "/matri/" + nameFileByURL);
        xhrA.onload = function (e) {
            var tiff = new Tiff({
                buffer: xhrA.response
            });
            var canvas = tiff.toCanvas();
            document.querySelector("div[class~='actaMatrimonioAdversoTIF']").append(canvas);
        };
        xhrA.send();
    }
}

function prepareFrame() {
    let nameFileByURL = (location.search.split('namefile=')[1]).split('&')[0];
    var ifrm = document.createElement("iframe");
    ifrm.setAttribute("src", "/fichas/" + getCarpetaPadreCondicion() + "/matri/" + nameFileByURL);
    ifrm.style.width = "800px";
    ifrm.style.height = "600px";
    ifrm.style.border = "none";
    document.querySelector("div[class='actaMatrimonioAdversoPDF']").appendChild(ifrm);
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