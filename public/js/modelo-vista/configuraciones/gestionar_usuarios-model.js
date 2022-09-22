class GestionarUsuariosModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosUsuario = (id) => {
        return $.ajax({
            url: route("configuracion.visualizar-usuario", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    registrarUsuario = (data, route) => {
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