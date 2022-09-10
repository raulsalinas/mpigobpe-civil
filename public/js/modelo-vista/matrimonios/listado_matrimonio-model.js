class ListadoMatrimonioModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosMatrimonio = (id) => {
        return $.ajax({
            url: route("matrimonio.control.editar", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
}