class ListadoDefuncionModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosDefuncion = (id) => {
        return $.ajax({
            url: route("defuncion.control.editar", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
}