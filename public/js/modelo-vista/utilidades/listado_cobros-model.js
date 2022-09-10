class ListadoCobrosModel {

    constructor(token) {
        this.token = token;
    }

    cargarDatosCobros = (id) => {
        return $.ajax({
            url: route("utilidades.pagos.editar", id),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
}