class GestionarMaestroMotivoDefuncionModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosMaestroMotivoDefuncion = (id) => {
        return $.ajax({
            url: route("configuracion.visualizar-motivo-defuncion", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarMaestroMotivoDefuncion = (data, route) => {
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