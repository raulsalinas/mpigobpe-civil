class ControlNacimientoView {

    constructor(model) {
        this.model = model;
    }

    /**
     * inicializar mediante DataTables
     */
    obtenerNacimiento = () => {

        let añoByURL = parseInt(location.search.split('ano=')[1]);
        let libroByURL = parseInt(location.search.split('libro=')[1]);
        let folioByURL = parseInt(location.search.split('folio=')[1]);

        if ((añoByURL, libroByURL, folioByURL) != null) {
            this.model.cargarDatosNacimiento(añoByURL, libroByURL, folioByURL).then((respuesta) => {
                // $boton.html("Imprimir");
                // $boton.data("evento", "registrar");
                console.log(respuesta);
                $('[name=ano_eje]').val(respuesta.ano_eje);
                $('[name=nro_lib]').val(respuesta.nro_lib);
                $('[name=nro_fol]').val(respuesta.nro_fol);

                $('[name=ape_pat_na]').val(respuesta.ape_pat_na);
                $('[name=ape_mat_na]').val(respuesta.ape_mat_na);
                $('[name=nom_nac]').val(respuesta.nom_nac);
                $('[name=nom_nac]').val(respuesta.nom_nac);
                $('[name=sex_nac]').val(respuesta.sex_nac);
                $('[name=ubigeo]').val(respuesta.ubigeo);
                $('[name=fch_nac]').val(respuesta.fch_nac);
                $('[name=fch_ing]').val(respuesta.fch_ing);
                $('[name=tipo]').val(respuesta.tipo);
                $('[name=usuario]').val(respuesta.usuario);

                $('[name=ape_pat_ma]').val(respuesta.ape_pat_ma);
                $('[name=ape_mat_ma]').val(respuesta.ape_mat_ma);
                $('[name=nom_mad]').val(respuesta.nom_mad);
                $('[name=dir_mad]').val(respuesta.dir_mad);

                $('[name=ape_pat_pa]').val(respuesta.ape_pat_pa);
                $('[name=ape_mat_pa]').val(respuesta.ape_mat_pa);
                $('[name=nom_pad]').val(respuesta.nom_pad);
                $('[name=dir_pad]').val(respuesta.dir_pad);


            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            });
        } else {
        }

    }

    /**
     * Se ejecutan los eventos que nacen de una accion, solo crear funcion a parte de ser necesario
     */

    eventos = () => {
        const $modal = $("#modalListadoDeNacimientos");
        // const $boton = $("#btnGuardar");

        /**
         * buscar - Buscar en listado de nacimientos
         */
        $("#botoneraPrincipal").on("click", "a.buscar", (e) => {

            $modal.find(".modal-title").text('Listado de Nacimientos');
            $modal.modal('show');
            this.listarNacimientos();
        });

        /**
         * imprimir - Imprimir información por ID y llenar en el formulario
         */
        $("#botoneraPrincipal").on("click", "a.imprimir", (e) => {
            document.querySelector("input[name='nro_recibo']").removeAttribute("readOnly");
            document.querySelector("input[name='nombre_solicitante_recibo']").removeAttribute("readOnly");
            document.querySelector("input[name='fecha_recibo']").removeAttribute("readOnly");
            document.querySelector("select[name='tipo_recibo']").removeAttribute("readOnly");
            document.querySelector("input[name='importe_recibo']").removeAttribute("readOnly");
            document.querySelector("input[name='detalle_recibo']").removeAttribute("readOnly");

        });

        $("#tablaNacimiento").on("click", "button.seleccionar", (e) => {

            let url = `/nacimientos/control/index/?ano=${$(e.currentTarget).data('año')}?libro=${$(e.currentTarget).data('libro')}/?folio=${$(e.currentTarget).data('folio')}`;
            var win = window.open(url, "_self");
            win.focus();

        });

        $('#card-recibo').on("blur", "input.handleNroRecibo", (e) => {
            if((e.currentTarget.value).length > 0){
                document.querySelector("button[id='btnVerActaAdverso']").removeAttribute("disabled");
                document.querySelector("button[id='btnVerActaReverso']").removeAttribute("disabled");
                document.querySelector("button[id='btnGuardarRecibo']").removeAttribute("disabled");
            }else{
                document.querySelector("button[id='btnVerActaAdverso']").setAttribute("disabled",true);
                document.querySelector("button[id='btnVerActaReverso']").setAttribute("disabled",true);
                document.querySelector("button[id='btnGuardarRecibo']").setAttribute("disabled",true);

            }
        });

        $('#card-recibo').on("click", "button.verActaAdverso", (e) => {
            let url = `/nacimientos/control/ver-acta-adverso/?ano=${$(e.currentTarget).data('año')}?libro=${$(e.currentTarget).data('libro')}/?folio=${$(e.currentTarget).data('folio')}`;
            var win = window.open(url, "_black");
            win.focus();
        });
        $('#card-recibo').on("click", "button.verActaReverso", (e) => {
            let url = `/nacimientos/control/ver-acta-reverso/?ano=${$(e.currentTarget).data('año')}?libro=${$(e.currentTarget).data('libro')}/?folio=${$(e.currentTarget).data('folio')}`;
            var win = window.open(url, "_black");
            win.focus();
        });

    }


    listarNacimientos = (anio_filtro=null,libro_filtro=null,folio_filtro=null,apellido_paterno_filtro=null,apellido_materno_filtro=null,nombres_filtro=null,fecha_desde_filtro=null,fecha_hasta_filtro=null) => {
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
                { data: 'ano_eje' },
                { data: 'nro_lib' },
                { data: 'nro_fol' },
                { data: 'ape_pat_na' },
                { data: 'ape_mat_na' },
                { data: 'nom_nac' },
                { data: 'sexo_desc', name: 'sexo.nombre' },
                { data: 'ubigeo_desc', name: 'ubigeo.nombre' },
                { data: 'fch_nac' },
                { data: 'fch_ing' },
                { data: 'accion-seleccionar', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: []
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


}