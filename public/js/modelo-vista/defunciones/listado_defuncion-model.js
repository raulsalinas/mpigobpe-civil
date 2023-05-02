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

    recuperarDefuncion = (data, route) => {
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