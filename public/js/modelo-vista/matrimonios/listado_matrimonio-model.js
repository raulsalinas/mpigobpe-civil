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

    
    recuperarMatrimonio = (data, route) => {
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