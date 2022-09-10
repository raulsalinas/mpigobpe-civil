class ConsistenciaNacimientoModel {

    constructor(token) {
        this.token = token;
    }

    // reporteNacimiento = (id) => {
    //     return $.ajax({
    //         url: route("nacimientos.consistencia.reporte", {id: id}),
    //         type: "GET",
    //         dataType: "JSON",
    //         data: { _token: this.token },
    //     });
    // }

    reporteNacimiento = (data, route) => {
        return $.ajax({
            url: route,
            type: "GET",
            dataType: "JSON",
            processData: false,
            contentType: false,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

}