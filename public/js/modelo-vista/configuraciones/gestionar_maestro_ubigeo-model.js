class GestionarMaestroUbigeoModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosMaestroUbigeo = (id) => {
        return $.ajax({
            url: route("configuracion.visualizar-ubigeo", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarMaestroUbigeo = (data, route) => {
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