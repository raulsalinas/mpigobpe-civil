class ControlMatrimonioModel {

    constructor(token) {
        this.token = token;
    }

    registrarMatrimonio = (data, route) => {
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
    registrarRecibo = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    observarMatrimonio = (data, route) => {
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


    cargarDatosMatrimonio = (id) => {
        return $.ajax({
            url: route("matrimonios.control.visualizar", {id: id}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    eliminarMatrimonio = (id) => {
        return $.ajax({
            url: route("matrimonios.eliminar", {id: id}),
            type: "PUT",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }
    
    archivarAdjunto = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            processData: false,
            contentType: false,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
}