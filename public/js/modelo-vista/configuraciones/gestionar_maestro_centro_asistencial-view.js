
class GestionarMaestroCentroAsistencialView {

    constructor(model) {
        this.model = model;
    }
    /**
     * Listar mediante DataTables
     */
    listarCentroAsistencial = () => {
        const $tabla = $('#tablaCentroAsistencial').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaCentroAsistencial_filter');
                const $input = $filter.find('input');
                $filter.append('<button id="btnBuscarCentroAsistencial" class="btn btn-default btn-sm pull-right" type="button"><i class="fas fa-search"></i></button>');
                $input.off();
                $input.on('keyup', (e) => {
                    if (e.key == 'Enter') {
                        $('#btnBuscarCentroAsistencial').trigger('click');
                    }
                });
                $('#btnBuscarCentroAsistencial').on('click', (e) => {
                    $tabla.search($input.val()).draw();
                });
            },
            drawCallback: function (settings) {
                $('#tablaCentroAsistencial_filter input').prop('disabled', false);
                $('#btnBuscarCentroAsistencial').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaCentroAsistencial_filter input').trigger('focus');
            },
            order: [[0, 'asc']],
            ajax: {
                url: route('configuracion.listar-centro-asistencial'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [

                { data: 'codigo',className: 'text-center' },
                { data: 'nombre' },
                { data: 'direccion' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'deleted_at' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: [
                {
                    text: '<i class="fas fa-plus"></i> Nuevo',
                    action: function () {
                        $("#modal-centro_asistencial").find(".modal-title").text("Nuevo Centro Asistencial");
                        $("#btnAccion").html("Guardar");
                        $('#formulario-centro_asistencial')[0].reset();
                        document.querySelector("div[id='modal-centro_asistencial'] button[id='btnAccion']").classList.replace("actualizar","guardar")
                        document.querySelector("div[id='modal-ubigeo'] input[id='estado1']").checked =true;
                        document.querySelector("div[id='modal-ubigeo'] input[id='estado1']").setAttribute('disabled',true);
                        document.querySelector("div[id='modal-ubigeo'] input[id='estado2']").setAttribute('disabled',true);

                        $("#modal-centro_asistencial").modal("show");



                    },
                    className: 'btn btn-sm btn-success nuevo',
                }
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaCentroAsistencial_filter input').attr('disabled', true);
            $('#btnBuscarCentroAsistencial').html('<i class="fas fa-clock" aria-hidden="true"></i>').prop('disabled', true);
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
        $("#tablaCentroAsistencial").on("click", "button.editar", (e) => {
            document.querySelector("form[id='formulario-centro_asistencial'] input[name='id']").value="";
            document.querySelector("div[id='modal-ubigeo'] input[id='estado1']").removeAttribute('disabled');
            document.querySelector("div[id='modal-ubigeo'] input[id='estado2']").removeAttribute('disabled');
            $("#btnAccion").html("Actualizar");
            document.querySelector("div[id='modal-centro_asistencial'] button[id='btnAccion']").classList.replace("guardar","actualizar")
            $("#modal-centro_asistencial").find(".modal-title").text("Editar Centro Asistencial");
            $("#modal-centro_asistencial").modal("show");
            
            if ((e.currentTarget.dataset.id) != null && e.currentTarget.dataset.id > 0) {
                this.model.cargarDatosMaestroCentroAsistencial(e.currentTarget.dataset.id).then((respuesta) => {
                    console.log(respuesta);
                    $('[name=id]').val(respuesta.id);
                    $('[name=codigo]').val(respuesta.codigo);
                    $('[name=nombre]').val(respuesta.nombre);
                    $('[name=direccion]').val(respuesta.direccion);
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

        $('#formulario-centro_asistencial').on("click", "button.actualizar", (e) => {
            const $form = new FormData($('#formulario-centro_asistencial')[0]);
            const $route = route("configuracion.actualizar-centro-asistencial");
            this.model.registrarMaestroCentroAsistencial($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("form[id='formulario-centro_asistencial'] input[name='id']").value="";
                    $('#modal-centro_asistencial').modal('hide');
                    $("#tablaCentroAsistencial").DataTable().ajax.reload(null, false);


                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
            });

        });

        $('#formulario-centro_asistencial').on("click", "button.guardar", (e) => {
            const $form = new FormData($('#formulario-centro_asistencial')[0]);
            const $route = route("configuracion.guardar-centro-asistencial");
            this.model.registrarMaestroCentroAsistencial($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("form[id='formulario-centro_asistencial'] input[name='id']").value="";
                    $('#modal-centro_asistencial').modal('hide');
                    $("#tablaCentroAsistencial").DataTable().ajax.reload(null, false);

                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {

            });

        });

    }

 
}