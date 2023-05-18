
class ListadoDefuncionView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (ano_eje=null, nro_lib=null, nro_fol=null, ape_des=null, nom_des=null, fch_des_desde=null, fch_des_hasta=null, condic=null) => {
        const $tabla = $('#tablaDefuncion').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaDefuncion_filter');
                const $input = $filter.find('input');
                $filter.append('<button id="btnBuscar" class="btn btn-default btn-sm pull-right" type="button"><i class="fas fa-search"></i></button>');
                $input.off();
                $input.on('keyup', (e) => {
                    if (e.key == 'Enter') {
                        $('#btnBuscar').trigger('click');
                    }
                });
                $('#btnBuscar').on('click', (e) => {
                    $tabla.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaDefuncion_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaDefuncion_filter input').trigger('focus');
            },
            order: [[2, 'asc']],
            ajax: {
                url: route('defunciones.listar'),
                method: 'POST',
                data: {
                    ano_eje, nro_lib, nro_fol, ape_des, nom_des, fch_des_desde, fch_des_hasta, condic
                        },
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'ano_eje',className: 'text-center' },
                { data: 'nro_lib' },
                { data: 'nro_fol' },
                { data: 'ape_des' },
                { data: 'nom_des' },
                { data: 'motivo_defuncion', name:'motvos.nombre' },
                { data: 'fch_des'},
                { data: 'usuario' },
                { data: 'fch_reg' },
                { data: 'observa' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: [
                {
                    text: '<i class="fas fa-filter"></i> Filtrar: 0',
                    action: function () {
                        $("#modal-filtro_defunciones").find(".modal-title").text("Filtrar defunciones");
                        $("#modal-filtro_defunciones").modal("show");


                    },
                    className: 'btn btn-sm btn-info filtrar',
                    attr:  {
                        id: 'btnFiltrarDefunciones'
                    }
                },
                {
                    text: '<i class="fas fa-clear"></i> Limpiar filtros activos',
                    action: ()=> {
                        document.getElementById('formulario-filtro-defunciones').reset();
                        document.querySelector("div[id='tablaDefuncion_wrapper'] button[id='btnFiltrarDefunciones']").innerHTML='<i class="fas fa-filter"></i> Filtrar: 0';
                        this.listar(null);

                    },
                    className: 'btn btn-sm btn-default limpiar',
                    attr:  {
                        id: 'btnLimpiarFiltroDefunciones'
                    }
                },
                {
                    text: '<span class="far fa-file-excel"></span> Descargar',
                    attr: {
                        id: 'btnDescargarListadoDefuncionExcel'
                    },
                    action: () => {
                        this.descargarListadoDefuncionExcel();
    
                    },
                    className: 'btn btn-sm btn-default'
                }
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaDefuncion_filter input').attr('disabled', true);
            $('#btnBuscar').html('<i class="fas fa-clock" aria-hidden="true"></i>').prop('disabled', true);
        });
        $tabla.on('init.dt', function (e, settings, processing) {
            $(e.currentTarget).LoadingOverlay('show', { imageAutoResize: true, progress: true, imageColor: '#3c8dbc' });
        });
        $tabla.on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $(e.currentTarget).LoadingOverlay('show', { imageAutoResize: true, progress: true, imageColor: '#3c8dbc' });
            } else {
                $(e.currentTarget).LoadingOverlay("hide", true);
            }
        });
    }

    /**
     * Se ejecutan los eventos que nacen de una accion, solo crear funcion a parte de ser necesario
     */

    eventos = () => {
 
        /**
         * Ver - Ver información por ID y llenar en el formulario
         */
        $("#tablaDefuncion").on("click", "button.ver", (e) => {

            let url = `/defunciones/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_blank");
            win.focus();

        });

        $("#tablaDefuncion").on("click", "button.recuperar", (e) => {

            const $route = route("defunciones.control.recuperar");
            this.model.recuperarDefuncion({'id':$(e.currentTarget).data('id')}, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    this.listar(null);
                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {

            });


        });

        $('.busquedaEnTiempo').on('keyup', this.debounce(function () {
            document.querySelector("button[id='btnFiltrar']").click();
        }, 500));

        /**
         * filtrar - Filtrar de listado de matrimonio
         */
        $("#modal-filtro_defunciones").on("click", "button.filtrar", (e) => {
            const $modal=$("#modal-filtro_defunciones");

            let ano_eje= document.querySelector("div[id='modal-filtro_defunciones'] input[name='ano_eje']").value;
            let nro_lib= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nro_lib']").value;
            let nro_fol= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nro_fol']").value;
            let ape_des= document.querySelector("div[id='modal-filtro_defunciones'] input[name='ape_des']").value;
            let nom_des= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nom_des']").value;
            let fch_des_desde= document.querySelector("div[id='modal-filtro_defunciones'] input[name='fch_des_desde']").value;
            let fch_des_hasta= document.querySelector("div[id='modal-filtro_defunciones'] input[name='fch_des_hasta']").value;
            let condic;
            let condicion= document.querySelectorAll("div[id='modal-filtro_defunciones'] input[name='condic']");
            condicion.forEach(element => {
                if(element.checked){
                    condic=element.value;
                }else{
                    condic='';
                }
            });

            this.listar(ano_eje,nro_lib,nro_fol,ape_des,nom_des,fch_des_desde,fch_des_hasta,condic);   
            // $modal.modal("hide");
            let cantidadFiltrosActivos=0;
            if(ano_eje !=''){cantidadFiltrosActivos++;}
            if(nro_lib != ''){cantidadFiltrosActivos++;}
            if(nro_fol != ''){cantidadFiltrosActivos++;}
            if(ape_des !=''){cantidadFiltrosActivos++;}
            if(nom_des !=''){cantidadFiltrosActivos++;}
            if(fch_des_desde !=''){cantidadFiltrosActivos++;}
            if(fch_des_hasta !=''){cantidadFiltrosActivos++;}
            if(condic !=''){cantidadFiltrosActivos++;}
            document.querySelector("div[id='tablaDefuncion_wrapper'] button[id='btnFiltrarDefunciones']").innerHTML='<i class="fas fa-filter"></i> Filtrar: '+cantidadFiltrosActivos;

        });

    }


    debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    descargarListadoDefuncionExcel(){

        let ano_eje= document.querySelector("div[id='modal-filtro_defunciones'] input[name='ano_eje']").value;
        let nro_lib= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nro_lib']").value;
        let nro_fol= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nro_fol']").value;
        let ape_des= document.querySelector("div[id='modal-filtro_defunciones'] input[name='ape_des']").value;
        let nom_des= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nom_des']").value;
        let fch_des_desde= document.querySelector("div[id='modal-filtro_defunciones'] input[name='fch_des_desde']").value;
        let fch_des_hasta= document.querySelector("div[id='modal-filtro_defunciones'] input[name='fch_des_hasta']").value;
        let condic;
        let condicion= document.querySelectorAll("div[id='modal-filtro_defunciones'] input[name='condic']");
        condicion.forEach(element => {
            if(element.checked){
                condic=element.value;
            }else{
                condic='';
            }
        });        

        window.open(`listado-defuncion-excel/${ano_eje !=''?ano_eje:'SIN_FILTRO'}/${nro_lib!=''?nro_lib:'SIN_FILTRO'}/${nro_fol!=''?nro_fol:'SIN_FILTRO'}/${ape_des!=''?ape_des:'SIN_FILTRO'}/${nom_des!=''?nom_des:'SIN_FILTRO'}/${fch_des_desde!=''?fch_des_desde:'SIN_FILTRO'}/${fch_des_hasta!=''?fch_des_hasta:'SIN_FILTRO'}/${condic!=''?condic:'SIN_FILTRO'}`);

    }
}