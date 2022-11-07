
class ListadoMatrimonioView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (anio_filtro=null,libro_filtro=null,folio_filtro=null,apellido_paterno_marido_filtro=null,apellido_materno_marido_filtro=null,nombres_marido_filtro=null,apellido_paterno_esposa_filtro=null,apellido_materno_esposa_filtro=null,nombres_esposa_filtro=null,fecha_desde_filtro=null,fecha_hasta_filtro=null) => {
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
                data: {
                    'anio_filtro':anio_filtro,
                    'libro_filtro':libro_filtro,
                    'folio_filtro':folio_filtro,
                    'apellido_paterno_marido_filtro':apellido_paterno_marido_filtro,
                    'apellido_materno_marido_filtro':apellido_materno_marido_filtro,
                    'nombres_marido_filtro':nombres_marido_filtro,
                    'apellido_paterno_esposa_filtro':apellido_paterno_esposa_filtro,
                    'apellido_materno_esposa_filtro':apellido_materno_esposa_filtro,
                    'nombres_esposa_filtro':nombres_esposa_filtro,
                    'fecha_desde_filtro':fecha_desde_filtro,
                    'fecha_hasta_filtro':fecha_hasta_filtro
                        },
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'ano_cel',className: 'text-center' },
                { data: 'nro_lib' },
                { data: 'nro_fol' },
                { data: 'ape_pat_ma' },
                { data: 'ape_mat_ma' },
                { data: 'nom_mar' },
                { data: 'ubigeo_marido', name:'ubigeo_marido.nombre' },
                { data: 'ape_pat_es' },
                { data: 'ape_mat_es' },
                { data: 'nom_esp' },
                { data: 'ubigeo_esposa', name:'ubigeo_esposa.nombre' },
                { data: 'fch_cel'},
                { data: 'fch_reg'},
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

        /**
         * filtrar - Filtrar de listado de matrimonio
         */
        $("#modal-filtro_matrimonios").on("click", "button.filtrar", (e) => {
            const $modal=$("#modal-filtro_matrimonios");

            let anioEjeFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='anio_eje_filtro']").value;
            let nroLibFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nro_lib_filtro']").value;
            let nroFolFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nro_fol_filtro']").value;
            let apellidoPaternoMaridoFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='apellido_paterno_marido_filtro']").value;
            let apellidoMaternoMaridoFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='apellido_materno_marido_filtro']").value;
            let nombresMaridoFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nombres_marido_filtro']").value;
            let apellidoPaternoEsposaFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='apellido_paterno_esposa_filtro']").value;
            let apellidoMaternoEsposaFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='apellido_materno_esposa_filtro']").value;
            let nombresEsposaFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='nombres_esposa_filtro']").value;
            let fechaDesdeFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='fecha_desde_filtro']").value;
            let fechaHastaFiltro= document.querySelector("div[id='modal-filtro_matrimonios'] input[name='fecha_hasta_filtro']").value;


            this.listar(anioEjeFiltro,nroLibFiltro,nroFolFiltro,apellidoPaternoMaridoFiltro,apellidoMaternoMaridoFiltro,nombresMaridoFiltro,apellidoPaternoEsposaFiltro,apellidoMaternoEsposaFiltro,nombresEsposaFiltro,fechaDesdeFiltro,fechaHastaFiltro);   
            $modal.modal("hide");
            let cantidadFiltrosActivos=0;
            if(anioEjeFiltro !=''){cantidadFiltrosActivos++;}
            if(nroLibFiltro != ''){cantidadFiltrosActivos++;}
            if(nroFolFiltro != ''){cantidadFiltrosActivos++;}
            if(apellidoPaternoMaridoFiltro !=''){cantidadFiltrosActivos++;}
            if(apellidoMaternoMaridoFiltro !=''){cantidadFiltrosActivos++;}
            if(nombresMaridoFiltro !=''){cantidadFiltrosActivos++;}
            if(apellidoPaternoEsposaFiltro !=''){cantidadFiltrosActivos++;}
            if(apellidoMaternoEsposaFiltro !=''){cantidadFiltrosActivos++;}
            if(nombresEsposaFiltro !=''){cantidadFiltrosActivos++;}
            if(fechaDesdeFiltro !=''){cantidadFiltrosActivos++;}
            if(fechaHastaFiltro !=''){cantidadFiltrosActivos++;}
            document.querySelector("div[id='tablaMatrimonio_wrapper'] button[id='btnFiltrarMatrimonios']").innerHTML='<i class="fas fa-filter"></i> Filtrar: '+cantidadFiltrosActivos;

        });

    }
}