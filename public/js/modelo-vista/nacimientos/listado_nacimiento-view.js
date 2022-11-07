
class ListadoNacimientoView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (anio_filtro=null,libro_filtro=null,folio_filtro=null,apellido_paterno_filtro=null,apellido_materno_filtro=null,nombres_filtro=null,fecha_desde_filtro=null,fecha_hasta_filtro=null,condicion_filtro=null) => {
        const $tabla = $('#tablaNacimiento').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaNacimiento_filter');
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
                $('#tablaNacimiento_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaNacimiento_filter input').trigger('focus');
            },
            order: [[2, 'asc']],
            ajax: {
                url: route('nacimientos.listar'),
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
                { data: 'ano_nac',className: 'text-center' },
                { data: 'nro_lib' },
                { data: 'nro_fol' },
                { data: 'ape_pat_na' },
                { data: 'ape_mat_na' },
                { data: 'nom_nac' },
                { data: 'sexo_desc', name: 'sexo.nombre' },
                { data: 'ubigeo_desc', name: 'ubigeo.nombre' },
                { data: 'fch_nac', className: 'text-center' },
                { data: 'fch_ing',  className: 'text-center' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: [
                {
                    text: '<i class="fas fa-filter"></i> Filtrar: 0',
                    action: function () {
                        $("#modal-filtro_nacimientos").find(".modal-title").text("Filtrar nacimientos");
                        // $("#btnFiltrar").html("Registrar");
                        // $("#btnFiltrar").data("evento", "registrar");
                        $("#modal-filtro_nacimientos").modal("show");


                    },
                    className: 'btn btn-sm btn-info filtrar',
                    attr:  {
                        id: 'btnFiltrarNacimientos'
                    }
                },
                {
                    text: '<i class="fas fa-clear"></i> Limpiar filtros activos',
                    action: ()=> {
                        document.getElementById('formulario-filtro-nacimiento').reset();
                        document.querySelector("div[id='tablaNacimiento_wrapper'] button[id='btnFiltrarNacimientos']").innerHTML='<i class="fas fa-filter"></i> Filtrar: 0';
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
            $('#tablaNacimiento_filter input').attr('disabled', true);
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
        $("#tablaNacimiento").on("click", "button.ver", (e) => {

            let url = `/nacimientos/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_blank");
            win.focus();

        });

        /**
         * Editar - Cargar información por ID y llenar en el formulario
         */
        // $("#tablaNacimiento").on("click", "button.editar", (e) => {
        //     this.model.cargarDatosPersona($(e.currentTarget).data('año'), $(e.currentTarget).data('libro'), $(e.currentTarget).data('folio')).then((respuesta) => {
        //         $boton.html("Editar");
        //         $boton.data("evento", "registrar");

        //         $('[name=id]').val(respuesta.id);
        //         $('[name=documento_identidad_id]').val(respuesta.documento_identidad_id);
        //         $('[name=documento]').val(respuesta.documento);
        //         $('[name=nombres]').val(respuesta.nombres);
        //         $('[name=apellido_paterno]').val(respuesta.apellido_paterno);
        //         $('[name=apellido_materno]').val(respuesta.apellido_materno);
        //         $('[name=sexo]').val(respuesta.sexo);
        //         $('[name=fecha_nacimiento]').val(respuesta.fecha_nacimiento);
        //         $('[name=estado_civil_id]').val(respuesta.estado_civil_id);

        //         $modal.find(".modal-title").text('Editar persona [' + respuesta.nombres + ' ' + respuesta.apellido_paterno + ']');
        //         $modal.modal('show');
        //     }).fail(() => {
        //         Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        //     });
        // });

        /**
         * filtrar - Filtrar de listado de nacimientos
         */
        $("#modal-filtro_nacimientos").on("click", "button.filtrar", (e) => {
            const $modal=$("#modal-filtro_nacimientos");

            let anioEjeFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='anio_eje_filtro']").value;
            let nroLibFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nro_lib_filtro']").value;
            let nroFolFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nro_fol_filtro']").value;
            let apellidoPaternoFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='apellido_paterno_filtro']").value;
            let apellidoMaternoFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='apellido_materno_filtro']").value;
            let nombresFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nombres_filtro']").value;
            let fechaDesdeFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='fecha_desde_filtro']").value;
            let fechaHastaFiltro= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='fecha_hasta_filtro']").value;

            let condicionFiltro;
            let condicion= document.querySelectorAll("div[id='modal-filtro_nacimientos'] input[name='condicionActaRadioOptions']");
            condicion.forEach(element => {
                if(element.checked){
                    condicionFiltro=element.value;
                }else{
                    condicionFiltro='';
                }
            });

            this.listar(anioEjeFiltro,nroLibFiltro,nroFolFiltro,apellidoPaternoFiltro,apellidoMaternoFiltro,nombresFiltro,fechaDesdeFiltro,fechaHastaFiltro,condicionFiltro);   
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
            if(condicionFiltro !=''){cantidadFiltrosActivos++;}
            document.querySelector("div[id='tablaNacimiento_wrapper'] button[id='btnFiltrarNacimientos']").innerHTML='<i class="fas fa-filter"></i> Filtrar: '+cantidadFiltrosActivos;
        });


        /**
        * Ver - Ver información por ID y llenar en el formulario
        */
        // $("#tablaNacimiento").on("click", "button.filtrar", (e) => {
        //     this.model.cargarDatosNacimiento($(e.currentTarget).data('año'), $(e.currentTarget).data('libro'), $(e.currentTarget).data('folio')).then((respuesta) => {
        //         $boton.html("Imprimir");
        //         $boton.data("evento", "registrar");
        //         // console.log(respuesta);

        //         // $modal.find(".modal-title").text('Editar nacimiento ['+ respuesta.nombres +' '+ respuesta.apellido_paterno + ']');
        //         $modal.find(".modal-title").text('Visualizar Nacimiento');
        //         $modal.modal('show');
        //     }).fail(() => {
        //         Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
        //     });
        // });

    }
}