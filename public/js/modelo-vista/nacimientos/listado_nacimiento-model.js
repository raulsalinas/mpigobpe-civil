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

    recuperarNacimiento = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}