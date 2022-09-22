
class GestionarUsuariosView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (anio_filtro=null,libro_filtro=null,folio_filtro=null,apellido_paterno_filtro=null,apellido_materno_filtro=null,nombres_filtro=null,fecha_desde_filtro=null,fecha_hasta_filtro=null,condicion_filtro=null) => {
        const $tabla = $('#tablaUsuario').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaUsuario_filter');
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
                $('#tablaUsuario_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaUsuario_filter input').trigger('focus');
            },
            order: [[0, 'asc']],
            ajax: {
                url: route('configuracion.listar-usuarios'),
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
                { data: 'usuario',className: 'text-center' },
                { data: 'correo' },
                { data: 'nombre_largo' },
                { data: 'es_administrador' ,'render': function (data, type, row, index) {
                    return row.es_administrador ==true?'Administrador':'Usuario Regular';
                }
                },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'deleted_at' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: [
                {
                    text: '<i class="fas fa-plus"></i> Nuevo',
                    action: function () {
                        $("#modal-usuario").find(".modal-title").text("Nuevo usuario");
                        $("#btnAccion").html("Guardar");
                        $('#formulario-usuario')[0].reset();
                        document.querySelector("div[id='modal-usuario'] button[id='btnAccion']").classList.replace("actualizar","guardar")

                        $("#modal-usuario").modal("show");


                    },
                    className: 'btn btn-sm btn-success nuevo',
                }
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaUsuario_filter input').attr('disabled', true);
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
 
        $("#tablaUsuario").on("click", "button.editar", (e) => {
            $("#btnAccion").html("Actualizar");
            document.querySelector("div[id='modal-usuario'] button[id='btnAccion']").classList.replace("guardar","actualizar")
            $("#modal-usuario").find(".modal-title").text("Editar Usuario");
            $("#modal-usuario").modal("show");

            if ((e.currentTarget.dataset.id) != null && e.currentTarget.dataset.id > 0) {
                this.model.cargarDatosUsuario(e.currentTarget.dataset.id).then((respuesta) => {
                    console.log(respuesta);
                    $('[name=id]').val(respuesta.id);
                    $('[name=usuario]').val(respuesta.usuario);
                    $('[name=nombre_corto]').val(respuesta.nombre_corto);
                    $('[name=nombre_largo]').val(respuesta.nombre_largo);
                    $('[name=correo]').val(respuesta.correo);
                    // $('[name=password]').val(respuesta.password);
                    if(respuesta.deleted_at ==null || respuesta.deleted_at =='' ){
                        $('[id=estado1]').prop("checked", true);
                    }else{
                        $('[id=estado2]').prop("checked", true);

                    }
    
    
                }).fail(() => {
                    Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
                });
            } else {
            }
        });


        $('#formulario-usuario').on("click", "button.actualizar", (e) => {
            const $form = new FormData($('#formulario-usuario')[0]);
            const $route = route("configuracion.actualizar-usuario");
            this.model.registrarUsuario($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("form[id='formulario-usuario'] input[name='id']").value="";
                    $('#modal-usuario').modal('hide');
                    $("#tablaUsuario").DataTable().ajax.reload(null, false);


                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
            });

        });
        $('#formulario-usuario').on("click", "button.guardar", (e) => {
            const $form = new FormData($('#formulario-usuario')[0]);
            const $route = route("configuracion.guardar-usuario");
            this.model.registrarUsuario($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("form[id='formulario-usuario'] input[name='id']").value="";
                    $('#modal-usuario').modal('hide');
                    $("#tablaUsuario").DataTable().ajax.reload(null, false);


                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
            });

        });

        /**
         * filtrar - Filtrar de listado de matrimonio
         */
        // $("#modal-filtro_gestionar_usuarios").on("click", "button.filtrar", (e) => {
        //     const $modal=$("#modal-filtro_gestionar_usuarios");

        //     let anioEjeFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='anio_eje_filtro']").value;
        //     let nroLibFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='nro_lib_filtro']").value;
        //     let nroFolFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='nro_fol_filtro']").value;
        //     let apellidoPaternoFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='apellido_paterno_filtro']").value;
        //     let apellidoMaternoFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='apellido_materno_filtro']").value;
        //     let nombresFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='nombres_filtro']").value;
        //     let fechaDesdeFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='fecha_desde_filtro']").value;
        //     let fechaHastaFiltro= document.querySelector("div[id='modal-filtro_gestionar_usuarios'] input[name='fecha_hasta_filtro']").value;

        //     let condicionFiltro;
        //     let condicion= document.querySelectorAll("div[id='modal-filtro_gestionar_usuarios'] input[name='condicionActaRadioOptions']");
        //     condicion.forEach(element => {
        //         if(element.checked){
        //             condicionFiltro=element.value;
        //         }
        //     });


        //     this.listar(anioEjeFiltro,nroLibFiltro,nroFolFiltro,apellidoPaternoFiltro,apellidoMaternoFiltro,nombresFiltro,fechaDesdeFiltro,fechaHastaFiltro,condicionFiltro);   
        //     $modal.modal("hide");

        // });

    }
}