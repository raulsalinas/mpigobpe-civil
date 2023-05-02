class GestionarMaestroLugaresModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosMaestroLugares = (id) => {
        return $.ajax({
            url: route("configuracion.visualizar-lugares", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarMaestroLugares = (data, route) => {
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