class GestionarMaestroCentroAsistencialModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosMaestroCentroAsistencial = (id) => {
        return $.ajax({
            url: route("configuracion.visualizar-centro-asistencial", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarMaestroCentroAsistencial = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

 
}