
class GestionarMaestroTipoRegistroView {

    constructor(model) {
        this.model = model;
    }
    /**
     * Listar mediante DataTables
     */
    listarTipoRegistro = () => {
        const $tabla = $('#tablaTipoRegistro').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaTipoRegistro_filter');
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
                $('#tablaTipoRegistro_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaTipoRegistro_filter input').trigger('focus');

            },
            order: [[0, 'asc']],
            ajax: {
                url: route('configuracion.listar-tipo-registro'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [

                { data: 'codigo', className: 'text-center' },
                { data: 'nombre' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'deleted_at' },
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: [
                {
                    text: '<i class="fas fa-plus"></i> Nuevo',
                    action: function () {
                        $("#modal-tipo_registro").find(".modal-title").text("Nuevo Tipo Registro");
                        $("#btnAccion").html("Guardar");
                        document.querySelector("div[id='modal-tipo_registro'] button[id='btnAccion']").classList.replace("actualizar","guardar")
                        document.querySelector("div[id='modal-tipo_registro'] input[id='estado1']").checked =true;
                         document.querySelector("div[id='modal-tipo_registro'] input[id='estado1']").setAttribute('disabled',true);
                         document.querySelector("div[id='modal-tipo_registro'] input[id='estado2']").setAttribute('disabled',true);

                        $("#modal-tipo_registro").modal("show");



                    },
                    className: 'btn btn-sm btn-success nuevo',
                }
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaTipoRegistro_filter input').attr('disabled', true);
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

        $( $.fn.dataTable.tables( true ) ).DataTable().columns.adjust();


    }

    /**
     * Se ejecutan los eventos que nacen de una accion, solo crear funcion a parte de ser necesario
     */

    eventos = () => {

     
        $("#tablaTipoRegistro").on("click", "button.editar", (e) => {
            document.querySelector("form[id='formulario-tipo_registro'] input[name='id']").value="";
            document.querySelector("div[id='modal-tipo_registro'] input[id='estado1']").removeAttribute('disabled');
            document.querySelector("div[id='modal-tipo_registro'] input[id='estado2']").removeAttribute('disabled');
            $("#btnAccion").html("Actualizar");
            document.querySelector("div[id='modal-tipo_registro'] button[id='btnAccion']").classList.replace("guardar","actualizar")
            $("#modal-tipo_registro").find(".modal-title").text("Editar ubigeo");
            $("#modal-tipo_registro").modal("show");
            
            if ((e.currentTarget.dataset.id) != null && e.currentTarget.dataset.id > 0) {
                this.model.cargarDatosMaestroUbigeo(e.currentTarget.dataset.id).then((respuesta) => {
                    console.log(respuesta);
                    $('[name=id]').val(respuesta.id);
                    $('[name=codigo]').val(respuesta.codigo);
                    $('[name=nombre]').val(respuesta.nombre);
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

        $('#formulario-tipo_registro').on("click", "button.actualizar", (e) => {
            const $form = new FormData($('#formulario-tipo_registro')[0]);
            const $route = route("configuracion.actualizar-ubigeo");
            this.model.registrarMaestroUbigeo($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("form[id='formulario-tipo_registro'] input[name='id']").value="";
                    $('#modal-tipo_registro').modal('hide');
                    $("#tablaTipoRegistro").DataTable().ajax.reload(null, false);


                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {
            });

        });

        $('#formulario-tipo_registro').on("click", "button.guardar", (e) => {
            const $form = new FormData($('#formulario-tipo_registro')[0]);
            const $route = route("configuracion.guardar-ubigeo");
            this.model.registrarMaestroUbigeo($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("form[id='formulario-tipo_registro'] input[name='id']").value="";
                    $('#modal-tipo_registro').modal('hide');
                    $("#tablaTipoRegistro").DataTable().ajax.reload(null, false);

                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {

            });

        });

    }

 
}