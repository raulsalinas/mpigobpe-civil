class Util {
    static seleccionarMenu(url) {
        $("ul.nav-sidebar a").filter(function () {
            return this.href == url;
        }).parent().addClass("active");
    
        $("ul.nav-treeview a").filter(function () {
            return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open');
    }
    
    static mensaje(tipo, mensaje) {
        Lobibox.notify(tipo, {
            size: "mini",
            rounded: true,
            sound: false,
            delayIndicator: false,
            iconSource: "fontAwesome",
            position: "top right",
            msg: mensaje
        });
    }
    
    static generarPuntosSvg() {
        return `<svg style="width: 16px; height: 16px; margin: 0px; display: inline-block" version="1.1" id="L5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" 
        viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <circle fill="#fff" stroke="none" cx="6" cy="50" r="6">
                <animateTransform attributeName="transform" dur="1s" type="translate" values="0 15 ; 0 -15; 0 15" repeatCount="indefinite" begin="0.1"/>
            </circle>
            <circle fill="#fff" stroke="none" cx="30" cy="50" r="6">
                <animateTransform attributeName="transform" dur="1s" type="translate" values="0 10 ; 0 -10; 0 10" repeatCount="indefinite" begin="0.2"/>
            </circle>
            <circle fill="#fff" stroke="none" cx="54" cy="50" r="6">
                <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3"/>
            </circle>
        </svg>`;
    }
    
    static leftZero(canti, number) {
        let vLen = number.toString();
        let nLen = vLen.length;
        let zeros = "";
        for (var i = 0; i < (canti - nLen); i++) {
            zeros = zeros + "0";
        }
        return zeros + number;
    }

    static limpiarTabla(idElement) {
        let nodeTbody = document.querySelector("table[id='" + idElement + "'] tbody");
        if (nodeTbody != null) {
            while (nodeTbody.children.length > 0) {
                nodeTbody.removeChild(nodeTbody.lastChild);
            }
    
        }
    }

    static readOnlyAllInputForm(formCurrent,trueOrFalse, inputNameToIgnoreList=null){
        var form  = document.getElementById(formCurrent);
        var allElements = form.elements;
        for (var i = 0, l = allElements.length; i < l; ++i) {

            if(inputNameToIgnoreList!=null){
                if(!inputNameToIgnoreList.includes(allElements[i].name)){
                    if(trueOrFalse == false){
                        allElements[i].removeAttribute("readonly"); 
                    }else if(trueOrFalse == true){
                        llElements[i].readOnly = true; 
                    }
                }
            }else{
                if(trueOrFalse == false){
                    allElements[i].removeAttribute("readonly"); 
                }else if(trueOrFalse == true){
                    llElements[i].readOnly = true; 
                }
            }
        }
    }
    
    static cambiarEstadoBotonera(HABILITAR_DESHABILITAR,BOTONES_LIST){
        
  

        const botoneraPrincipal = document.querySelectorAll("div[id='botoneraPrincipal'] a");

        botoneraPrincipal.forEach(btn => {
            BOTONES_LIST.forEach(btnAfectado => {
            if( btn.classList.contains(btnAfectado) ==true){
                if(HABILITAR_DESHABILITAR == 'HABILITAR'){
                    btn.classList.remove("disabled");
                    $('.select2').removeAttr('disabled');

                }else if(HABILITAR_DESHABILITAR == 'DESHABILITAR'){
                    btn.classList.add("disabled");
                    $('.select2').attr('disabled','disabled');

                }
            }
 
        });
        });
    }
}

function changePassword() {
    $("#form-password")[0].reset();
    $("#modal-password").modal("show");
    $("#modal-password").on("shown.bs.modal", function () {
        $("[name=profile_password]").focus();
    });
}

