var tempArchivoAdjuntoList = [];

class AdjuntoView {

    constructor(model) {
        this.model = model;
    }

    mostrarAnoLibroFolioRegistroAdjunto = (idRegistroByURL, idArchivoByURL=null,tipo) => {
        console.log(idRegistroByURL, idArchivoByURL,tipo);
        this.model.mostrarAnoLibroFolioRegistroAdjunto(idRegistroByURL,idArchivoByURL,tipo).then((respuesta) => {

            $("span[id='tipo']").text(tipo.charAt(0).toUpperCase()+tipo.slice(1));
            document.querySelector("span[id='claveLibroAño']").textContent = 'Año: ' + respuesta.ano ? respuesta.ano  : 'S/N';
            document.querySelector("span[id='claveLibroLibro']").textContent = 'Libro: ' + respuesta.libro ? respuesta.libro  : 'S/N';
            document.querySelector("span[id='claveLibroFolio']").textContent = 'Folio: ' + respuesta.folio ? respuesta.folio  : 'S/N';
            document.querySelector("span[id='claveLibroCondic']").textContent = 'Condición: ' + respuesta.condicion ? respuesta.condicion : 'S/C';
        }).fail(() => {
            Util.mensaje("error", "Hubo un problema al intentar obtener la data. Por favor vuelva a intentarlo");
        });
    }


    listarAdjuntos = (idRegistroByURL, idArchivoByURL=null,tipo) => {
        let dataAdjunto=[];
        this.model.obtenerAdjuntos(idRegistroByURL,tipo).then((respuesta) => {
            dataAdjunto=respuesta;
            let contenedorAdjuntos = document.querySelector("div[id='contenedorAdjuntoList']");
            let html = '';
            respuesta.forEach(element => {
                
                html += `<li class="nav-item" style="padding-left: 1rem;">
                    <span class="nav-link btn btn-outline-primary cargarAdjunto" data-id-archivo="${element.id}" data-tipo="${tipo}" data-nombre-sin-extension="${element.nombre_sin_extension}" data-nombre-extension="${element.nombre_extension}" data-ruta="${element.ruta}">${element.nombre_completo}</span>
                </li>`;
            });

    
        contenedorAdjuntos.querySelector("ul").insertAdjacentHTML('beforeend', html);

        this.seleccionarAdjuntoParaMostrar(dataAdjunto,idArchivoByURL);

        }).fail(() => {
            Util.mensaje("error", "Hubo un problema al intentar obtener los adjuntos. Por favor vuelva a intentarlo");
        });
    }

    seleccionarAdjuntoParaMostrar(data, idArchivoSeleccionado){
        let archivo ={};
        if(idArchivoSeleccionado>0){
            data.forEach(element => {
                if(element.id == idArchivoSeleccionado){
                    archivo= element;
                }
            });
        }else{
            archivo = data[0];
        }
        
        this.mostrarAdjuntoEnPantallaSegunExtension(archivo);
    }

    mostrarAdjuntoEnPantallaSegunExtension(archivo){
        if(archivo.hasOwnProperty('id')){
            if(archivo.nombre_extension == 'tif' || archivo.nombre_extension=='TIF' ){
                this.prepareCanvas(archivo.ruta);
            }else if(archivo.nombre_extension == 'pdf' || archivo.nombre_extension=='PDF'){
                this.prepareFrame(archivo.ruta);
            }
        }else{
            Util.mensaje("error", "Hubo un problema al intentar obtener el archivo. Por favor vuelva a intentarlo");

        }
    }


    prepareFrame(ruta) {
        document.querySelector("div[class='actaAdversoPDF']").innerHTML='';

        
        $('.actaAdversoPDF').LoadingOverlay("show", {
            imageAutoResize: true,
            progress: true,
            imageColor: "#3c8dbc"
        });

        var ifrm = document.createElement("iframe");
        ifrm.setAttribute("src", ruta);
        ifrm.style.width = "800px";
        ifrm.style.height = "600px";
        ifrm.style.border = "none";
        document.querySelector("div[class='actaAdversoPDF']").appendChild(ifrm);
        $('.actaAdversoPDF').LoadingOverlay("hide", true);

    }

    prepareCanvas(ruta) {
            // Inicia -> vista extendida
            document.querySelector("div[class~='actaAdversoTIF']").innerHTML='';
            
            $('.actaAdversoTIF').LoadingOverlay("show", {
                imageAutoResize: true,
                progress: true,
                imageColor: "#3c8dbc"
            });

            let body = document.getElementsByTagName("body")[0];
            body.classList.add("sidebar-collapse");
            // termina -> vista extendida
    
            var xhrA = new XMLHttpRequest();
            xhrA.responseType = 'arraybuffer';
            xhrA.open('GET', ruta);
            xhrA.onload = function (e) {
                var tiff = new Tiff({
                    buffer: xhrA.response
                });
                var canvas = tiff.toCanvas();
                document.querySelector("div[class~='actaAdversoTIF']").append(canvas);

                $('.actaAdversoTIF').LoadingOverlay("hide", true);

            };
            xhrA.send();
    }

    eventos = () =>{
        
        $(".content-header").on("click", "span.cargarAdjunto", (e) => {
            let archivo = {
                'id':e.currentTarget.dataset.idArchivo,
                'tipo':e.currentTarget.dataset.tipo,
                'nombre_completo':e.currentTarget.dataset.nombreCompleto,
                'nombre_sin_extension':e.currentTarget.dataset.nombreSinExtension,
                'nombre_extension':e.currentTarget.dataset.nombreExtension,
                'ruta':e.currentTarget.dataset.ruta,
                'accion':'',
                'archivo':[]
            };

            this.mostrarAdjuntoEnPantallaSegunExtension(archivo);
        });
        
        $("body").on("click", "button.descargarAdjunto", (e) => {
            var letters = 'abcdefghijklmnopqrstuvwxyz';
            var randomLetter = '';
        
            for (let index = 0; index < 4; index++) {
                let randomNum = Math.round(Math.random() * 26);
                randomLetter += letters.charAt(randomNum);
            }
        
            var link = document.createElement("a");
            link.id = randomLetter;
            link.href = e.currentTarget.dataset.ruta;
            link.click();
        });

        $("body").on("click", "button.anularAdjunto", (e) => {
            const formData = new FormData();
            
        
            // const idRegistro = document.querySelector("input[name='id']").value;
            // formData.append(`idRegistro`, idRegistro);
            formData.append(`id_archivo`, e.currentTarget.dataset.idArchivo);
            formData.append(`tipo`, e.currentTarget.dataset.tipo);
            const $route = route("adjunto.anular");
    
            Swal.fire({
                title: '¿Esta seguro que desea anular este archivo adjunto?',
                text: '',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, anular',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.model.anularAdjunto(formData, $route).then((respuesta) => {
                        // console.log(respuesta);
                        Util.mensaje(respuesta.alerta, respuesta.mensaje);
                        if (respuesta.respuesta == "ok") {
                            // let url = `/nacimientos/control/index/?id=${idRegistro}`;
                            // var win = window.open(url, "_selft");
                            // win.focus();
                            e.currentTarget.closest('tr').remove();
                        }
                    }).fail(() => {
                        Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
                    }).always(() => {
            
                    });
                }
            });



        });

        $("body").on("click", "button.visualizarAdjunto", (e) => {
            let idRegistro = $(e.currentTarget).data('id-registro') ?? 0;
            let idArchivo = $(e.currentTarget).data('id-archivo') ?? 0;
            let idTipo = $(e.currentTarget).data('id-tipo') ?? '';
            abrirPestañaVisualizarAdjunto(idTipo,idRegistro, idArchivo);
            
        });
        $("body").on("click", "button.eliminarAdjunto", (e) => {
                e.currentTarget.closest("tr").remove();
                var regExp = /[a-zA-Z]/g; //expresión regular
                if ((regExp.test(e.currentTarget.dataset.id) == true)) {
                    tempArchivoAdjuntoList = tempArchivoAdjuntoList.filter((element, i) => element.id != e.currentTarget.dataset.id);
                } else {
                    if (tempArchivoAdjuntoList.length > 0) {
                        let indice = tempArchivoAdjuntoList.findIndex(elemnt => elemnt.id == e.currentTarget.dataset.id);
                        tempArchivoAdjuntoList[indice].accion = 'ELIMINAR';
                    } else {
                        Swal.fire(
                            '',
                            'Hubo un error inesperado al intentar eliminar el adjunto, puede que no el objecto este vacio, elimine adjuntos y vuelva a seleccionar',
                            'error'
                        );
                    }
            }
        });

        $("body").on("change", "input.handleChangeAgregarAdjunto", (e) => {
            agregarAdjunto(e.currentTarget);
        });
    }
}


function abrirPestañaVisualizarAdjunto(idTipo,idRegistro = null, idArchivo = null) {

    let tipo = 0;
    switch (parseInt(idTipo)) {
        case 1:
            tipo = 'nacimientos';
            break;

        case 2:
            tipo = 'matrimonios';
            break;

        case 3:
            tipo = 'defunciones';

            break;

        default:
            break;
    }

    // let url = `/nacimientos/control/visualizar-adjunto/?idregistro=${document.querySelector("input[name='id']").value}&namefile=${$(e.currentTarget).data('nombre-archivo')}&year=${$(e.currentTarget).data('año')}&book=${$(e.currentTarget).data('libro')}&folio=${$(e.currentTarget).data('folio')}&condic=${$(e.currentTarget).data('condic')}`;
    let url = `/${tipo}/control/visualizar-adjunto/?tipo=${idTipo}&idregistro=${idRegistro}&idarchivo=${idArchivo}`;
    var win = window.open(url, "_black");
    win.focus();
}


function makeId() {
    let ID = "";
    let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for (let i = 0; i < 12; i++) {
        ID += characters.charAt(Math.floor(Math.random() * 36));
    }
    return ID;
}

function estaHabilitadoLaExtension(file) {
    let extension = (file.name.match(/(?<=\.)\w+$/g) != null) ? file.name.match(/(?<=\.)\w+$/g)[0].toLowerCase() : ''; // assuming that this file has any extension
    if (extension !== 'tif' && extension !== 'pdf') {
        return false;
    } else {
        return true;
    }
}

function obtenerNombreDeNuevoAdjunto() {
    let nombreBaseAdjunto = ''.concat(document.querySelector("input[name='ano_eje']").value, document.querySelector("input[name='nro_fol']").value);
    let sufijo = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"];
    tempArchivoAdjuntoList.forEach(element => {
        console.log(element);

        // if (element.accion == '') {
            let nombreSinExtension = element.nombre_sin_extension;
            if (nombreSinExtension.slice(-1) == "A") {
                const isElement = (element) => element == "A";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "B") {
                const isElement = (element) => element == "B";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "C") {
                const isElement = (element) => element == "C";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "D") {
                const isElement = (element) => element == "D";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "E") {
                const isElement = (element) => element == "E";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "F") {
                const isElement = (element) => element == "F";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "G") {
                const isElement = (element) => element == "G";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "H") {
                const isElement = (element) => element == "H";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "I") {
                const isElement = (element) => element == "I";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            } else if (nombreSinExtension.slice(-1) == "J") {
                const isElement = (element) => element == "J";
                sufijo.splice(sufijo.findIndex(isElement), 1);
            }
        // }
    });
    return nombreBaseAdjunto + sufijo[0];

}
function agregarAdjunto(obj) {
    if ($("input[name='ano_eje']").val() != "" && $("input[name='nro_folio']").val() != "") {
        if (obj.files != undefined && obj.files.length > 0) {
            Array.prototype.forEach.call(obj.files, (file) => {

                if (estaHabilitadoLaExtension(file) == true) {
                    const extension = file.name.substring(file.name.lastIndexOf('.') + 1, file.name.length) || file.name;
                    const nombreSinExtension = obtenerNombreDeNuevoAdjunto();
                    const nombreCompleto = nombreSinExtension + '.' + extension;
                    let payload = {
                        id: makeId(),
                        nombre_completo: nombreCompleto,
                        tipo:$("form").attr("name"),
                        idtipo:$("form").attr("idtipo"),
                        nombre_sin_extension: nombreSinExtension,
                        nombre_extension: extension,
                        ruta:'',
                        accion: 'GUARDAR',
                        archivo: file
                    };
                    addToTablaArchivos(payload);

                    tempArchivoAdjuntoList.push(payload);
                    // console.log(tempArchivoAdjuntoList);
                    // console.log(payload);
                } else {
                    Swal.fire(
                        'Este tipo de archivo no esta permitido adjuntar',
                        file.name,
                        'warning'
                    );
                }
            });
        }
    } else {
        Swal.fire(
            'Primero debe llenar el "Año de ejecución" y "Nro de folio".',
            '',
            'warning'
        );
    }
}

function addToTablaArchivos(payload) {
// console.log(payload);
    let html = '';
    html = `<tr id="${payload.id}" style="text-align:center">
        <td style="text-align:left;">${payload.nombre_sin_extension}.${payload.nombre_extension}</td>
        <td style="text-align:center;">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary btn-xs visualizarAdjunto" name="btnVisualizarAdjunto" title="Visualizar" data-id="${payload.id}"  data-id-tipo="${payload.tipo}"  disabled>Visualizar</button>
                <button type="button" class="btn btn-outline-danger btn-xs eliminarAdjunto"  name="btnEliminarAdjunto" title="Eliminar" data-id="${payload.id}" >Eliminar</button>
            </div>
        </td>
        </tr>`;

    document.querySelector("table[id='tablaListaAdjuntos'] tbody").insertAdjacentHTML('beforeend', html);

}