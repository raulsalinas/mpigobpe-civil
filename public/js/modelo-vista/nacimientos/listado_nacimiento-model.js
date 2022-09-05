class ListadoNacimientoModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosNacimiento = (id) => {
        return $.ajax({
            url: route("nacimientos.control.editar", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
}