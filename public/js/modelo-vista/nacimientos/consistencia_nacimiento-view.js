class ConsistenciaNacimientoView {

    constructor(model) {
        this.model = model;
    }

    eventos = () => {

        $("#vert-tabs-todoLosRegistros").on("click", "button.ejecutarConsistenciaTodoLosRegistros", (e) => {
            let ano_nac= (document.querySelector("form[id='todoLosRegistrosForm'] input[name='ano_nac']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] input[name='ano_nac']").value).toString():'SIN_DATA';
            let nro_lib= (document.querySelector("form[id='todoLosRegistrosForm'] input[name='nro_lib']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] input[name='nro_lib']").value).toString():'SIN_DATA';
            let sex_nac= (document.querySelector("form[id='todoLosRegistrosForm'] select[name='sex_nac']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] select[name='sex_nac']").value).toString():'SIN_DATA';
            let ubigeo= (document.querySelector("form[id='todoLosRegistrosForm'] select[name='ubigeo']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] select[name='ubigeo']").value).toString():'SIN_DATA';
            let usuario= (document.querySelector("form[id='todoLosRegistrosForm'] select[name='usuario']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] select[name='usuario']").value).toString():'SIN_DATA';
            let cen_asi= (document.querySelector("form[id='todoLosRegistrosForm'] select[name='cen_asi']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] select[name='cen_asi']").value).toString():'SIN_DATA';
            let fch_nac_desde= (document.querySelector("form[id='todoLosRegistrosForm'] input[name='fch_nac_desde']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] input[name='fch_nac_desde']").value).toString():'SIN_DATA';
            let fch_nac_hasta= (document.querySelector("form[id='todoLosRegistrosForm'] input[name='fch_nac_hasta']").value).toString().length>0?(document.querySelector("form[id='todoLosRegistrosForm'] input[name='fch_nac_hasta']").value).toString():'SIN_DATA';
            let url = "/nacimientos/consistencia/reporte-todo-registro/"+ano_nac+"/"+nro_lib+"/"+sex_nac+"/"+ubigeo+"/"+usuario+"/"+cen_asi+"/"+fch_nac_desde+"/"+fch_nac_hasta;
            var win = window.open(url, "_black");
            win.focus();

            // $.ajax({
            //     type: 'GET',
            //     // url:   route("nacimientos.consistencia.reporteTodoRegistro",{ano_nac,nro_lib,sex_nac,ubigeo,usuario,cen_asi,fch_nac_desde,fch_nac_hasta}),
            //     url:   "/nacimientos/consistencia/reporte-todo-registro/"+ano_nac+"/"+nro_lib+"/"+sex_nac+"/"+ubigeo+"/"+usuario+"/"+cen_asi+"/"+fch_nac_desde+"/"+fch_nac_hasta
             
            //     ,xhrFields: {
            //         responseType: 'blob'
            //     },
            //     // headers: {
            //     //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     // },
            //     success: function(response){
            //         var blob = new Blob([response]);
            //         var link = document.createElement('a');
            //         link.href = window.URL.createObjectURL(blob);
            //         link.download = "Sample.pdf";
            //         link.click();
            //     },
            //     error: function(blob){
            //         console.log(blob);
            //     }
            // });

        });

        $("#vert-tabs-porAño").on("click", "button.ejecutarConsistenciaPorAño", (e) => {
            console.log("ejecutar reporte porAño");
        });

        $("#vert-tabs-porNumeroDeLibro").on("click", "button.ejecutarConsistenciaPorNumeroDeLibro", (e) => {
            console.log("ejecutar reporte porNumeroDeLibro");
        });
        $("#vert-tabs-porSexo").on("click", "button.ejecutarConsistenciaPorSexo", (e) => {
            console.log("ejecutar reporte porSexo");
        });
        $("#vert-tabs-porFechaDeNacimiento").on("click", "button.ejecutarConsistenciaPorFechaDeNacimiento", (e) => {
            console.log("ejecutar reporte porFechaDeNacimiento");
        });
        $("#vert-tabs-porLugaroUbicacion").on("click", "button.ejecutarConsistenciaPorLugaroUbicacion", (e) => {
            console.log("ejecutar reporte porLugaroUbicacion");
        });
        $("#vert-tabs-porRegistrador").on("click", "button.ejecutarConsistenciaPorRegistrador", (e) => {
            console.log("ejecutar reporte porRegistrador");
        });
        $("#vert-tabs-librosEstructurados").on("click", "button.ejecutarConsistenciaLibrosEstructurados", (e) => {
            console.log("ejecutar reporte librosEstructurados");
        });
        $("#vert-tabs-porCentroAsistencial").on("click", "button.ejecutarConsistenciaPorCentroAsistencial", (e) => {
            console.log("ejecutar reporte porCentroAsistencial");
        });
    }

}