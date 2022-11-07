class ConsistenciaDefuncionView {

    constructor(model) {
        this.model = model;
    }

    eventos = () => {

        $("#vert-tabs-contenedor").on("click", "button", (e) => {
            const formId=this.obtenerFormDeTabActivo();
            console.log(formId);
            let mensaje=[];
            let ano_des="SIN_DATA";
            let nro_lib="SIN_DATA";
            let usuario="SIN_DATA";
            let fch_des_desde="SIN_DATA";
            let fch_des_hasta="SIN_DATA";

            if(formId == "todoLosRegistrosForm"){
                ano_des= (document.querySelector("form[id='"+formId+"'] input[name='ano_des']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='ano_des']").value).toString():'SIN_DATA';
                nro_lib= (document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString():'SIN_DATA';
                usuario= (document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString():'SIN_DATA';
                // fch_des_desde= (document.querySelector("form[id='"+formId+"'] input[name='fch_des_desde']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_des_desde']").value).toString():'SIN_DATA';
                // fch_des_hasta= (document.querySelector("form[id='"+formId+"'] input[name='fch_des_hasta']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_des_hasta']").value).toString():'SIN_DATA';
                
                if(ano_des == null || ano_des== "SIN_DATA"){
                    mensaje.push("Campo de año");
                }
                if(nro_lib == null || nro_lib== "SIN_DATA"){
                    mensaje.push("Campo de libro");
                    
                }
            }
            if(formId == "porAñoForm"){
                ano_des= (document.querySelector("form[id='"+formId+"'] select[name='ano_des']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='ano_des']").value).toString():'SIN_DATA';
                if(ano_des == null || ano_des== "SIN_DATA"){
                    mensaje.push("Campo de año");
                }

            }
            if(formId == "porNumeroDeLibroForm"){
                nro_lib= (document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='nro_lib']").value).toString():'SIN_DATA';
                if(nro_lib == null || nro_lib== "SIN_DATA"){
                    mensaje.push("Campo de libro");
                    
                }
            }
            if(formId == "porFechaDeNacimientoForm"){
                fch_des_desde= (document.querySelector("form[id='"+formId+"'] input[name='fch_des_desde']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_des_desde']").value).toString():'SIN_DATA';
                fch_des_hasta= (document.querySelector("form[id='"+formId+"'] input[name='fch_des_hasta']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] input[name='fch_des_hasta']").value).toString():'SIN_DATA';

                if(fch_des_desde == null || fch_des_desde== "SIN_DATA"){
                    mensaje.push("Campo fecha desde");
                    
                }
                if(fch_des_hasta == null || fch_des_hasta== "SIN_DATA"){
                    mensaje.push("Campo fecha hasta");
    
                }
            }
            if(formId == "porRegistradorForm"){
                usuario= (document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString().length>0?(document.querySelector("form[id='"+formId+"'] select[name='usuario']").value).toString():'SIN_DATA';
                if(usuario == null || usuario== "SIN_DATA"){
                    mensaje.push("Campo de usuario");
                    
                } 
            }

            if(mensaje.length ==0) {
                let url = "/defunciones/consistencia/reporte/"+ano_des+"/"+nro_lib+"/"+usuario+"/"+fch_des_desde+"/"+fch_des_hasta;
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