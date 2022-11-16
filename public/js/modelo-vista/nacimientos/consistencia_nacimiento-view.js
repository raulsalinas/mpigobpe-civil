class ConsistenciaNacimientoView {

    constructor(model) {
        this.model = model;
    }

    eventos = () => {

        $("#vert-tabs-contenedor").on("click", "button", (e) => {
            const formId=this.obtenerFormDeTabActivo();
            console.log(formId);
            let mensaje=[];
            let ano_nac="SIN_DATA";
            let nro_lib="SIN_DATA";
            let sex_nac="SIN_DATA";
            let ubigeo="SIN_DATA";
            let usuario="SIN_DATA";
            let cen_asi="SIN_DATA";
            let fch_nac_desde="SIN_DATA";
            let fch_nac_hasta="SIN_DATA";

            if(formId == "todoLosRegistrosForm"){
                ano_nac= (document.querySelector("form[id='"+formId+"'] input[name='ano_nac']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='ano_nac']").value).toString():'SIN_DATA';
                nro_lib= (document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString():'SIN_DATA';
                sex_nac= (document.querySelector("form[id='"+formId+"'] select[name='sex_nac']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='sex_nac']").value).toString():'SIN_DATA';
                ubigeo= (document.querySelector("form[id='"+formId+"'] select[name='ubigeo']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='ubigeo']").value).toString():'SIN_DATA';
                usuario= (document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString():'SIN_DATA';
                cen_asi= (document.querySelector("form[id='"+formId+"'] select[name='cen_asi']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='cen_asi']").value).toString():'SIN_DATA';
                // fch_nac_desde= (document.querySelector("form[id='"+formId+"'] input[name='fch_nac_desde']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_nac_desde']").value).toString():'SIN_DATA';
                // fch_nac_hasta= (document.querySelector("form[id='"+formId+"'] input[name='fch_nac_hasta']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_nac_hasta']").value).toString():'SIN_DATA';
                
                if(ano_nac == null || ano_nac== "SIN_DATA"){
                    mensaje.push("Campo de año");
                }
                if(nro_lib == null || nro_lib== "SIN_DATA"){
                    mensaje.push("Campo de libro");
                    
                }
                if(sex_nac == null || sex_nac== "SIN_DATA"){
                    mensaje.push("Campo de sexo");
                    
                }
                if(ubigeo == null || ubigeo== "SIN_DATA"){
                    mensaje.push("Campo de ubigeo");
                    
                }
                if(cen_asi == null || cen_asi== "SIN_DATA"){
                    mensaje.push("Campo de centro asistencial");
                    
                }
            }
            if(formId == "porAñoForm"){
                ano_nac= (document.querySelector("form[id='"+formId+"'] select[name='ano_nac']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='ano_nac']").value).toString():'SIN_DATA';
                if(ano_nac == null || ano_nac== "SIN_DATA"){
                    mensaje.push("Campo de año");
                }

            }
            if(formId == "porNumeroDeLibroForm"){
                nro_lib= (document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString():'SIN_DATA';
                if(nro_lib == null || nro_lib== "SIN_DATA"){
                    mensaje.push("Campo de libro");
                    
                }
            }
            if(formId == "porSexoForm"){
                sex_nac= (document.querySelector("form[id='"+formId+"'] select[name='sex_nac']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='sex_nac']").value).toString():'SIN_DATA';
                if(sex_nac == null || sex_nac== "SIN_DATA"){
                    mensaje.push("Campo de sexo");
                    
                }
            }
            if(formId == "porFechaDeNacimientoForm"){
                fch_nac_desde= (document.querySelector("form[id='"+formId+"'] input[name='fch_nac_desde']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_nac_desde']").value).toString():'SIN_DATA';
                fch_nac_hasta= (document.querySelector("form[id='"+formId+"'] input[name='fch_nac_hasta']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_nac_hasta']").value).toString():'SIN_DATA';

                if(fch_nac_desde == null || fch_nac_desde== "SIN_DATA"){
                    mensaje.push("Campo fecha desde");
                    
                }
                if(fch_nac_hasta == null || fch_nac_hasta== "SIN_DATA"){
                    mensaje.push("Campo fecha hasta");
    
                }
            }
            if(formId == "porLugaroUbicacionForm"){
                ubigeo= (document.querySelector("form[id='"+formId+"'] select[name='ubigeo']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='ubigeo']").value).toString():'SIN_DATA';
                if(ubigeo == null || ubigeo== "SIN_DATA"){
                    mensaje.push("Campo de ubigeo");
                    
                }
            }
            if(formId == "porRegistradorForm"){
                usuario= (document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString():'SIN_DATA';
                if(usuario == null || usuario== "SIN_DATA"){
                    mensaje.push("Campo de usuario");
                    
                } 
            }
            if(formId == "porCentroAsistencialForm"){
                cen_asi= (document.querySelector("form[id='"+formId+"'] select[name='cen_asi']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='cen_asi']").value).toString():'SIN_DATA';
                if(cen_asi == null || cen_asi== "SIN_DATA"){
                    mensaje.push("Campo de centro asistencial");
                    
                }
            }

            if(mensaje.length ==0) {
                let url = "/nacimientos/consistencia/reporte/"+e.currentTarget.dataset.extensionReporte+"/"+ano_nac+"/"+nro_lib+"/"+sex_nac+"/"+ubigeo+"/"+usuario+"/"+cen_asi+"/"+fch_nac_desde+"/"+fch_nac_hasta;
                var win = window.open(url, "_black");
                win.focus();
            }else{
                Swal.fire(
                    'Falta ingresar campos',
                    mensaje.toString(),
                    'warning'
                );

            }

        });

    }

    
    obtenerFormDeTabActivo(){
        let idElement ="";
        const tabVertical = document.querySelectorAll("div[id='vert-tabs-tab'] a");
        tabVertical.forEach(element => {
            if(element.classList.contains("active")==true){
                let idhrefElement=element.getAttribute("href").slice(1);
                idElement= document.querySelector("div[id='"+idhrefElement+"'] form").getAttribute("id")
            }
        });

        return idElement
    }
}