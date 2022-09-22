class GestionarMaestroTipoRegistroModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosMaestroTipoRegistro = (id) => {
        return $.ajax({
            url: route("configuracion.visualizar-tipo-recibo", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarMaestroTipoRegistro = (data, route) => {
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