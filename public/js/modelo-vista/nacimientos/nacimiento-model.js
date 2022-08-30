class NacimientoModel {

    constructor(token) {
        this.token = token;
    }

    registrarNacimiento = (data, route) => {
        return $.ajax({
            url: route,
            type: "POST",
            dataType: "JSON",
            data: data,
        });
    }

    cargarDatosNacimiento = (anio, libro, folio) => {
        return $.ajax({
            url: route("nacimientos.editar", {anio:anio,libro:libro,folio:folio}),
            type: "GET",
            dataType: "JSON",
            data: { _token: this.token },
        });
    }

    // filtrarListaNacimientos = (anio, libro, folio) => {
    //     return $.ajax({
    //         url: route("nacimientos.filtrar", {anio:anio,libro:libro,folio:folio}),
    //         type: "GET",
    //         dataType: "JSON",
    //         data: { _token: this.token },
    //     });
    // }

    // eliminarNacimiento = (id) => {
    //     return $.ajax({
    //         url: route("nacimientos.eliminar", {id: id}),
    //         type: "PUT",
    //         dataType: "JSON",
    //         data: { _token: this.token },
    //     });
    // }
}