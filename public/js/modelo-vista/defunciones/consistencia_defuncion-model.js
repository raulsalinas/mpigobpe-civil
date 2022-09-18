class ConsistenciaDefuncionModel {

    constructor(token) {
        this.token = token;
    }

    reporteDefuncion = (data, route) => {
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