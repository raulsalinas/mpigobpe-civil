
class ListadoMatrimonioView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (ano_eje=null ,nro_lib=null ,nro_fol=null ,ape_mar=null ,nom_mar=null ,ape_esp=null ,nom_esp=null ,fch_cel_desde=null ,fch_cel_hasta=null ,condic=null) => {
        const $tabla = $('#tablaMatrimonio').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaMatrimonio_filter');
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
                $('#tablaMatrimonio_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaMatrimonio_filter input').trigger('focus');
            },
            order: [[2, 'asc']],
            ajax: {
                url: route('matrimonios.listar'),
                method: 'POST',
                data: {ano_eje,nro_lib,nro_fol,ape_mar,nom_mar,ape_esp,nom_esp,fch_cel_desde,fch_cel_hasta,condic},

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
                { data: 'ape_mar' },
                { data: 'nom_mar' },
                { data: 'ubigeo_marido', name:'ubigeo_marido.nombre' },
                { data: 'ape_esp' },
                { data: 'nom_esp' },
                { data: 'ubigeo_esposa', name:'ubigeo_esposa.nombre' },
                { data: 'fch_cel'},
                { data: 'fch_reg'},
                { data: 'condic',  className: 'text-center', render: function(data,type,row,index){
                    return row.condic==1?'Ordinario':(row.condic ==2?'Extraordinario':(row.condic==3?'Especial':''));
                } },
                { data: 'observa'},
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: [
                {
                    text: '<i class="fas fa-filter"></i> Filtrar: 0',
                    action: function () {
                        $("#modal-filtro_matrimonios").find(".modal-title").text("Filtrar matrimonios");
                        $("#modal-filtro_matrimonios").modal("show");


                    },
                    className: 'btn btn-sm btn-info filtrar',
                    attr:  {
                        id: 'btnFiltrarMatrimonios'
                    }
                },
                {
                    text: '<i class="fas fa-clear"></i> Limpiar filtros activos',
                    action: ()=> {
                        document.getElementById('formulario-filtro-matrimonios').reset();
                        document.querySelector("div[id='tablaMatrimonio_wrapper'] button[id='btnFiltrarMatrimonios']").innerHTML='<i class="fas fa-filter"></i> Filtrar: 0';
                        this.listar(null);

                    },
                    className: 'btn btn-sm btn-default limpiar',
                    attr:  {
                        id: 'btnLimpiarFiltroNacimientos'
                    }
                }
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaMatrimonio_filter input').attr('disabled', true);
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
        $("#tablaMatrimonio").on("click", "button.ver", (e) => {

            let url = `/matrimonios/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_blank");
            win.focus();

        });

        $('.busquedaEnTiempo').on('keyup', this.debounce(function () {
            document.querySelector("button[id='btnFiltrar']").click();
        }, 500));

        /**
         * filtrar - Filtrar de listado de matrimonio
         */
        $("#modal-filtro_matrimonios").on("click", "button.filtrar", (e) => {
            const $modal=$("#modal-filtro_matrimonios");

            let ano_eje= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='ano_eje']").value;
            let nro_lib= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nro_lib']").value;
            let nro_fol= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nro_fol']").value;
            let ape_mar= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='ape_mar']").value;
            let nom_mar= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nom_mar']").value;
            let ape_esp= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='ape_esp']").value;
            let nom_esp= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nom_esp']").value;
            let fch_cel_desde= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='fch_cel_desde']").value;
            let fch_cel_hasta= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='fch_cel_hasta']").value;
            let condic;
            let condicion= document.querySelectorAll("div[id='modal-filtro_matrimonios'] input[name='condic']");
            condicion.forEach(element => {
                if(element.checked){
                    condic=element.value;
                }else{
                    condic='';
                }
            });

            this.listar(ano_eje,nro_lib,nro_fol,ape_mar,nom_mar,ape_esp,nom_esp,fch_cel_desde,fch_cel_hasta,condic);   
            // $modal.modal("hide");
            let cantidadFiltrosActivos=0;
            if(ano_eje !=''){cantidadFiltrosActivos++;}
            if(nro_lib != ''){cantidadFiltrosActivos++;}
            if(nro_fol != ''){cantidadFiltrosActivos++;}
            if(ape_mar !=''){cantidadFiltrosActivos++;}
            if(nom_mar !=''){cantidadFiltrosActivos++;}
            if(ape_esp !=''){cantidadFiltrosActivos++;}
            if(nom_esp !=''){cantidadFiltrosActivos++;}
            if(fch_cel_desde !=''){cantidadFiltrosActivos++;}
            if(fch_cel_hasta !=''){cantidadFiltrosActivos++;}
            if(condic !=''){cantidadFiltrosActivos++;}
            document.querySelector("div[id='tablaMatrimonio_wrapper'] button[id='btnFiltrarMatrimonios']").innerHTML='<i class="fas fa-filter"></i> Filtrar: '+cantidadFiltrosActivos;

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
}