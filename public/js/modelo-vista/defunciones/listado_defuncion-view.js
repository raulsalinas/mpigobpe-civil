
class ListadoDefuncionView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (anio_filtro=null,libro_filtro=null,folio_filtro=null,apellido_paterno_filtro=null,apellido_materno_filtro=null,nombres_filtro=null,fecha_desde_filtro=null,fecha_hasta_filtro=null,condicion_filtro=null) => {
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
                    'anio_filtro':anio_filtro,
                    'libro_filtro':libro_filtro,
                    'folio_filtro':folio_filtro,
                    'apellido_paterno_filtro':apellido_paterno_filtro,
                    'apellido_materno_filtro':apellido_materno_filtro,
                    'nombres_filtro':nombres_filtro,
                    'fecha_desde_filtro':fecha_desde_filtro,
                    'fecha_hasta_filtro':fecha_hasta_filtro,
                    'condicion_filtro':condicion_filtro
                        },
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'ano_des',className: 'text-center' },
                { data: 'nro_lib' },
                { data: 'nro_fol' },
                { data: 'ape_pat_de' },
                { data: 'ape_mat_de' },
                { data: 'nom_des' },
                { data: 'motivo_defuncion', name:'motvos.nombre' },
                { data: 'fch_des'},
                { data: 'usuario' },
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

        /**
         * filtrar - Filtrar de listado de matrimonio
         */
        $("#modal-filtro_defunciones").on("click", "button.filtrar", (e) => {
            const $modal=$("#modal-filtro_defunciones");

            let anioEjeFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='anio_eje_filtro']").value;
            let nroLibFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nro_lib_filtro']").value;
            let nroFolFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nro_fol_filtro']").value;
            let apellidoPaternoFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='apellido_paterno_filtro']").value;
            let apellidoMaternoFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='apellido_materno_filtro']").value;
            let nombresFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='nombres_filtro']").value;
            let fechaDesdeFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='fecha_desde_filtro']").value;
            let fechaHastaFiltro= document.querySelector("div[id='modal-filtro_defunciones'] input[name='fecha_hasta_filtro']").value;
            this.listar(anioEjeFiltro,nroLibFiltro,nroFolFiltro,apellidoPaternoFiltro,apellidoMaternoFiltro,nombresFiltro,fechaDesdeFiltro,fechaHastaFiltro);   
            $modal.modal("hide");
            let cantidadFiltrosActivos=0;
            if(anioEjeFiltro !=''){cantidadFiltrosActivos++;}
            if(nroLibFiltro != ''){cantidadFiltrosActivos++;}
            if(nroFolFiltro != ''){cantidadFiltrosActivos++;}
            if(apellidoPaternoFiltro !=''){cantidadFiltrosActivos++;}
            if(apellidoMaternoFiltro !=''){cantidadFiltrosActivos++;}
            if(nombresFiltro !=''){cantidadFiltrosActivos++;}
            if(fechaDesdeFiltro !=''){cantidadFiltrosActivos++;}
            if(fechaHastaFiltro !=''){cantidadFiltrosActivos++;}
            document.querySelector("div[id='tablaDefuncion_wrapper'] button[id='btnFiltrarDefunciones']").innerHTML='<i class="fas fa-filter"></i> Filtrar: '+cantidadFiltrosActivos;

        });

    }
}