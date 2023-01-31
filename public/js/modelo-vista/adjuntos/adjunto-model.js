class AdjuntoModel {

    constructor(token) {
        this.token = token;
    }

    // registrarAdjunto = (data, route) => {
    //     return $.ajax({
    //         url: route,
    //         type: "POST",
    //         dataType: "JSON",
    //         data: data,
    //     });
    // }

    obtenerAdjuntos = (idRegistro,tipo) => {
        return $.ajax({
            url: route("adjunto.obtener", {idRegistro: idRegistro,tipo:tipo}),
            type: "GET",
            dataType: "JSON",
            // headers: { 'X-CSRF-TOKEN': csrf_token },
            data: { _token: this.token },
        });
    }
    mostrarAnoLibroFolioRegistroAdjunto = (idRegistro,idArchivo,tipo) => {
        return $.ajax({
            url: route("adjunto.mostrar-ano-libro-folio-registro-adjunto", {idRegistro: idRegistro,idArchivo:idArchivo, tipo:tipo}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    anularAdjunto = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            processData: false,
            contentType: false,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    // eliminarAdjunto = (id) => {
    //     return $.ajax({
    //         url: route("administracion.aprobacion.configuracion.tipo_visto.eliminar", {id: id}),
    //         type: "PUT",
    //         dataType: "JSON",
    //         data: { _token: this.token },
    //     });
    // }
}
