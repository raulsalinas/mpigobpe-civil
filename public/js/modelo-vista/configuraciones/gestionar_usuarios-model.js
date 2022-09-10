class GestionarUsuariosModel {

    constructor(token) {
        this.token = token;
    }

    // cargarDatosUsuario = (id) => {
    //     return $.ajax({
    //         url: route("configuracion.gestionar-usuarios.editar", id),
    //         type: "GET",
    //         dataType: "JSON",
    //         data: { _token: this.token },
    //     });
    // }
}