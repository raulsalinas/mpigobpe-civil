var tempArchivoAdjuntoList = [];
class ControlMatrimonioView {

    constructor(model) {
        this.model = model;
    }

    /**
     * inicializar mediante DataTables
     */
    obtenerMatrimonio = () => {

        let idByURL = parseInt(location.search.split('id=')[1]);
        Util.cambiarEstadoBotonera('DESHABILITAR', ['guardar']);

        if ((idByURL) != null && idByURL > 0) {
            this.model.cargarDatosMatrimonio(idByURL).then((respuesta) => {
                // console.log(respuesta);
                $('[name=id]').val(respuesta.id);
                $('[name=ano_cel]').val(respuesta.ano_cel);
                $('[name=nro_lib]').val(respuesta.nro_lib);
                $('[name=nro_fol]').val(respuesta.nro_fol);

                $('[name=fch_cel]').val(respuesta.fch_cel);

                $('[name=ape_pat_ma]').val(respuesta.ape_pat_ma);
                $('[name=ape_mat_ma]').val(respuesta.ape_mat_ma);
                $('[name=nom_mar]').val(respuesta.nom_mar);
                $('[name=ubigeo1]').val(respuesta.ubigeo1);

                $('[name=ape_pat_es]').val(respuesta.ape_pat_es);
                $('[name=ape_mat_es]').val(respuesta.ape_mat_es);
                $('[name=nom_esp]').val(respuesta.nom_esp);
                $('[name=ubigeo2]').val(respuesta.ubigeo2);

                $('[name=fch_cel]').val(respuesta.fch_cel);
                $('[name=fch_reg]').val(respuesta.fch_reg);

                $('[name=tipo]').val(respuesta.cod_reg);
                $('[name=usuario]').val(respuesta.usuario);
                $('[name=condicionActa]').val(respuesta.condic);
                $('[name=observa]').text(respuesta.observa);

                // adjuntos
                Util.limpiarTabla("tablaListaAdjuntosDeMatrimonio");

                let html = '';
                if (respuesta.adjunto != null && respuesta.adjunto.existe_archivo_nombre_base == true) {
                    tempArchivoAdjuntoList.push({
                        id: respuesta.adjunto.nombre_base,
                        fecha_emision: '',
                        nameFile: respuesta.adjunto.nombre_base + '.tif',
                        action: '',
                        file: []
                    })
                    html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base + '.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio"  title="Visualizar" 
                        data-nombre-archivo="${respuesta.adjunto.nombre_base + '.tif'}"  
                        data-año="${respuesta.ano_cel}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}"  
                        disabled>Visualizar</button>
                     </div>
                </td>
                </tr>`;
                }
                if (respuesta.adjunto != null && respuesta.adjunto.existe_archivo_nombre_a == true) {
                    tempArchivoAdjuntoList.push({
                        id: respuesta.adjunto.nombre_base + 'A',
                        fecha_emision: '',
                        nameFile: respuesta.adjunto.nombre_base + 'A.tif',
                        action: '',
                        file: []
                    })
                    html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base + 'A.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio"  title="Visualizar"
                        data-nombre-archivo="${respuesta.adjunto.nombre_base + 'A.tif'}"  
                        data-año="${respuesta.ano_cel}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}" 
                        disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
                }
                if (respuesta.adjunto != null && respuesta.adjunto.existe_archivo_nombre_b == true) {
                    tempArchivoAdjuntoList.push({
                        id: respuesta.adjunto.nombre_base + 'B',
                        fecha_emision: '',
                        nameFile: respuesta.adjunto.nombre_base + 'B.tif',
                        action: '',
                        file: []
                    })
                    html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base + 'B.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio"  title="Visualizar"
                        data-nombre-archivo="${respuesta.adjunto.nombre_base + 'B.tif'}"  
                        data-año="${respuesta.ano_cel}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}" 
                        disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
                }
                if (respuesta.adjunto != null && respuesta.adjunto.existe_archivo_nombre_c == true) {
                    tempArchivoAdjuntoList.push({
                        id: respuesta.adjunto.nombre_base + 'C',
                        fecha_emision: '',
                        nameFile: respuesta.adjunto.nombre_base + 'C.tif',
                        action: '',
                        file: []
                    })
                    html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base + 'C.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio"  title="Visualizar"
                        data-nombre-archivo="${respuesta.adjunto.nombre_base + 'C.tif'}"  
                        data-año="${respuesta.ano_cel}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}" 
                        disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
                }
                if (respuesta.adjunto != null && respuesta.adjunto.existe_archivo_nombre_d == true) {
                    tempArchivoAdjuntoList.push({
                        id: respuesta.adjunto.nombre_base + 'D',
                        fecha_emision: '',
                        nameFile: respuesta.adjunto.nombre_base + 'D.tif',
                        action: '',
                        file: []
                    })
                    html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base + 'D.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio"  title="Visualizar"
                        data-nombre-archivo="${respuesta.adjunto.nombre_base + 'D.tif'}"  
                        data-año="${respuesta.ano_cel}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}" 
                        disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
                }
                if (respuesta.adjunto != null && respuesta.adjunto.existe_archivo_nombre_e == true) {
                    tempArchivoAdjuntoList.push({
                        id: respuesta.adjunto.nombre_base + 'E',
                        fecha_emision: '',
                        nameFile: respuesta.adjunto.nombre_base + 'E.tif',
                        action: '',
                        file: []
                    })
                    html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base + 'E.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio"  title="Visualizar"
                        data-nombre-archivo="${respuesta.adjunto.nombre_base + 'E.tif'}"  
                        data-año="${respuesta.ano_cel}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}" 
                        disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
                }
                if (respuesta.adjunto != null &&
                    respuesta.adjunto.existe_archivo_nombre_base == false &&
                    respuesta.adjunto.existe_archivo_nombre_a == false &&
                    respuesta.adjunto.existe_archivo_nombre_b == false &&
                    respuesta.adjunto.existe_archivo_nombre_c == false &&
                    respuesta.adjunto.existe_archivo_nombre_d == false &&
                    respuesta.adjunto.existe_archivo_nombre_e == false) {
                    html += `<tr style="text-align:center">
                <td style="text-align:center;" colSpan="2">Sin adjuntos para mostrar</td>           
                </td>
                </tr>`;
                }

                document.querySelector("table[id='tablaListaAdjuntosDeMatrimonio'] tbody").insertAdjacentHTML('beforeend', html);





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
        const $modal = $("#modalListadoDeMatrimonios");

        /**
         * buscar - Buscar en modal de listado de matrimonios
         */
        $("#botoneraPrincipal").on("click", "a.buscar", (e) => {

            $modal.find(".modal-title").text('Listado de Matrimonios');
            $modal.modal('show');
            this.listarMatrimonios();
        });

        /**
         * nuevo - Nuevo matrimonio
         */
        $("#botoneraPrincipal").on("click", "a.nuevo", (e) => {

            // let url = `/matrimonios/control/index`;
            // var win = window.open(url, "_self");
            // win.focus();

            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "Nuevo Registro";
            Util.cambiarEstadoBotonera('DESHABILITAR', ['nuevo', 'modificar', 'observar']);
            Util.cambiarEstadoBotonera('HABILITAR', ['guardar']);


            $('#controlMatrimoniosForm')[0].reset();
            Util.readOnlyAllInputForm("controlMatrimoniosForm", false);
            Util.limpiarTabla("tablaListaAdjuntosDeMatrimonio");
            document.querySelector("input[id='adjuntosMatrimonio']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
        });

        /**
         * nuevo - Nuevo matrimonio
         */
        $("#botoneraPrincipal").on("click", "a.guardar", (e) => {
            // const $form = $("#controlMatrimoniosForm").serializeArray();
            let formData = new FormData($('#controlMatrimoniosForm')[0]);
            if (tempArchivoAdjuntoList.length > 0) {
                tempArchivoAdjuntoList.forEach(element => {
                    if (element.action == 'GUARDAR') {
                        formData.append(`id_adjunto[]`, element.id);
                        formData.append(`archivo_adjunto[]`, element.file);
                        formData.append(`nombre_adjunto[]`, element.nameFile);
                        formData.append(`accion_adjunto[]`, 'GUARDAR');
                    }
                });
            }
            const $route = route(document.querySelector("input[name='id']").value > 0 ? "matrimonios.control.actualizar" : "matrimonios.control.guardar");
            console.log($route);
            this.model.registrarMatrimonio(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    let url = `/matrimonios/control/index/?id=${respuesta.id}`;
                    var win = window.open(url, "_selft");
                    win.focus();
                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {

            });
        });


        /**
     * modificar - Modificar registro
     */
        $("#botoneraPrincipal").on("click", "a.modificar", (e) => {
            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "Modificar Registro";

            Util.cambiarEstadoBotonera('DESHABILITAR', ['nuevo', 'observar']);
            Util.cambiarEstadoBotonera('HABILITAR', ['guardar']);
            Util.readOnlyAllInputForm("controlMatrimoniosForm", false, ['ano_cel', 'nro_lib', 'nro_fol']);


            // Util.limpiarTabla("tablaListaAdjuntosDeMatrimonio");
            document.querySelector("input[id='adjuntosMatrimonio']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosMatrimonio']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");


        });
        /**
         * modificar - Modificar registro
         */
        $("#botoneraPrincipal").on("click", "a.observar", (e) => {

            if (document.querySelector("input[name='id']").value > 0) {
                document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "Observar Registro";

                let observacion = '';
                Swal.fire({
                    title: 'Ingrese la observación',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',

                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        observacion = result.value;

                        const $data = {
                            'id': document.querySelector("form[id='controlMatrimoniosForm'] input[name='id']").value,
                            'observa': observacion
                        };
                        const $route = route("matrimonios.control.observar");
                        // console.log($data);
                        this.model.observarMatrimonio($data, $route).then((respuesta) => {
                            Util.mensaje(respuesta.alerta, respuesta.mensaje);
                            if (respuesta.respuesta == "ok") {
                                let url = `/matrimonios/control/index/?id=${document.querySelector("form[id='controlMatrimoniosForm'] input[name='id']").value}`;
                                var win = window.open(url, "_self");
                                win.focus();
                            } else if (respuesta.respuesta == "duplicado") {
                            }
                        }).fail(() => {
                            Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
                        }).always(() => {

                        });

                    } else {
                        console.log('cancel');
                    }
                });
            }else{
                Util.mensaje("warning", "No seleccionó ningun registro que pueda ser observado");
            }

        });
        /**
         * cancelar - Cancelar acción de accion nuevo, editar 
         */
        $("#botoneraPrincipal").on("click", "a.cancelar", (e) => {
            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "";
            
            Util.cambiarEstadoBotonera('HABILITAR', ['nuevo', 'modificar', 'observar']);
            $('#controlMatrimoniosForm')[0].reset();
            document.querySelector("div[name='observa']").textContent = "";
            Util.readOnlyAllInputForm("controlMatrimoniosForm", false);
            Util.limpiarTabla("tablaListaAdjuntosDeMatrimonio");
            document.querySelector("input[id='adjuntosMatrimonio']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosMatrimonio']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
        });


        $("#tablaModalMatrimonio").on("click", "button.seleccionar", (e) => {

            let url = `/matrimonios/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_self");
            win.focus();

        });

        /**
         * imprimir - Imprimir matrimonio 
         */
        $("#botoneraPrincipal").on("click", "a.imprimir", (e) => {
            const idMatrim = document.querySelector("input[name='id']").value;
            const ano = document.querySelector("input[name='ano_cel']").value;
            const libro = document.querySelector("input[name='nro_lib']").value;
            const folio = document.querySelector("input[name='nro_fol']").value;

            if (parseInt(idMatrim) > 0) {
                document.querySelector("div[id='modalRecibo'] input[name='matrim_id']").value = idMatrim;
                document.querySelector("div[id='modalRecibo'] input[name='ano']").value = ano;
                document.querySelector("div[id='modalRecibo'] input[name='libro']").value = libro;
                document.querySelector("div[id='modalRecibo'] input[name='folio']").value = folio;

                $("#modalRecibo").find(".modal-title").text('Recibo');
                $("#modalRecibo").modal('show')

                document.querySelector("input[name='nro_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='nombre_solicitante_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='fecha_recibo']").removeAttribute("readOnly");
                document.querySelector("select[name='tipo_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='importe_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='detalle_recibo']").removeAttribute("readOnly");

            } else {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Primero debe seleccionar un registro',
                    text: "Desea ver el listado?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, ver listado',
                    cancelButtonText: 'No, cerrar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $modal.find(".modal-title").text('Listado de Matrimonios');
                        $modal.modal('show');
                        this.listarMatrimonios();
                    }
                })
            }
        });

        $('#modalRecibo').on("blur", "input.handleNroRecibo", (e) => {
            if ((e.currentTarget.value).length > 0) {
                document.querySelector("button[id='btnGuardarRecibo']").removeAttribute("disabled");
            } else {
                document.querySelector("button[id='btnGuardarRecibo']").setAttribute("disabled", true);

            }
        });

        $('#tablaListaAdjuntosDeMatrimonio').on("click", "button.visualizarArchivoAdjunto", (e) => {
            let url = `/matrimonios/control/visualizar-adjunto/?namefile=${$(e.currentTarget).data('nombre-archivo')}?year=${$(e.currentTarget).data('año')}?book=${$(e.currentTarget).data('libro')}?folio=${$(e.currentTarget).data('folio')}`;
            var win = window.open(url, "_black");
            win.focus();
        });
        $('#tablaListaAdjuntosDeMatrimonio').on("click", "button.eliminarArchivoAdjunto", (e) => {
            this.eliminarArchivoAdjunto(e.currentTarget)
        });


        $('#modalRecibo').on("click", "button.guardarRecibo", (e) => {
            const $form = new FormData($('#formulario-recibo')[0]);
            // const $route = route("matrimonios.control.guardar-recibo");
            const $route = route("matrimonios.control.guardar-cobro");
            this.model.registrarRecibo($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").removeAttribute("disabled");
                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {

            });

        });

        $('#modalRecibo').on("click", "input.siAplicaRecibo", (e) => {
            $("#collapseRecibo").collapse("show");
            document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").setAttribute("disabled", true);

        });

        $('#modalRecibo').on("click", "input.noAplicaRecibo", (e) => {
            $("#collapseRecibo").collapse("hide");
            document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").removeAttribute("disabled");
        });

        $('#modalRecibo').on("click", "button.continuar", (e) => {
            const elementTablaListaAdjuntos = document.querySelectorAll("table[id='tablaListaAdjuntosDeMatrimonio'] tbody tr button");


            [].forEach.call(elementTablaListaAdjuntos, child => {
                child.removeAttribute("disabled");
            });

            Util.mensaje("info", "Se habilitó la botonera de la sección de adjuntos");

        });


        $(document).on("change", "input.handleChangeAgregarAdjunto", (e) => {
            this.agregarAdjunto(e.currentTarget);
        });

    }


    listarMatrimonios = (anio_filtro = null, libro_filtro = null, folio_filtro = null, apellido_paterno_filtro = null, apellido_materno_filtro = null, nombres_filtro = null, fecha_desde_filtro = null, fecha_hasta_filtro = null) => {
        const $tabla = $('#tablaModalMatrimonio').DataTable({
            dom: 'Bfrtip',
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaModalMatrimonio_filter');
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
                $('#tablaModalMatrimonio_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaModalMatrimonio_filter input').trigger('focus');
            },
            order: [[2, 'asc']],
            ajax: {
                url: route('matrimonios.listar'),
                method: 'POST',
                data: {
                    'anio_filtro': anio_filtro,
                    'libro_filtro': libro_filtro,
                    'folio_filtro': folio_filtro,
                    'apellido_paterno_filtro': apellido_paterno_filtro,
                    'apellido_materno_filtro': apellido_materno_filtro,
                    'nombres_filtro': nombres_filtro,
                    'fecha_desde_filtro': fecha_desde_filtro,
                    'fecha_hasta_filtro': fecha_hasta_filtro
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
                { data: 'ape_pat_es' },
                { data: 'ape_mat_es' },
                { data: 'nom_esp' },
                { data: 'fch_cel', className: 'text-center' },
                { data: 'fch_reg', className: 'text-center' },
                { data: 'accion-seleccionar', orderable: false, searchable: false, className: 'text-center' }
            ],
            buttons: []
        });
        $tabla.on('search.dt', function () {
            $('#tablaModalMatrimonio_filter input').attr('disabled', true);
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

    makeId() {
        let ID = "";
        let characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (let i = 0; i < 12; i++) {
            ID += characters.charAt(Math.floor(Math.random() * 36));
        }
        return ID;
    }

    estaHabilitadoLaExtension(file) {
        let extension = (file.name.match(/(?<=\.)\w+$/g) != null) ? file.name.match(/(?<=\.)\w+$/g)[0].toLowerCase() : ''; // assuming that this file has any extension
        if (extension !== 'tif') {
            return false;
        } else {
            return true;
        }
    }

    obtenerNombreDeNuevoAdjunto() {
        let nombreBaseAdjunto = ''.concat(document.querySelector("input[name='ano_cel']").value, document.querySelector("input[name='nro_fol']").value);
        let sufijo = ["A", "B", "C", "D", "E"];
        tempArchivoAdjuntoList.forEach(element => {

            if (element.action == '' || element.action == 'GUARDAR') {
                let nombreSinExtension = element.nameFile.slice(1, -4);
                if (nombreSinExtension.slice(-1) == "A") {
                    const isElement = (element) => element == "A";
                    sufijo.splice(sufijo.findIndex(isElement), 1);
                } else if (nombreSinExtension.slice(-1) == "B") {
                    const isElement = (element) => element == "B";
                    sufijo.splice(sufijo.findIndex(isElement), 1);
                } else if (nombreSinExtension.slice(-1) == "C") {
                    const isElement = (element) => element == "C";
                    sufijo.splice(sufijo.findIndex(isElement), 1);
                } else if (nombreSinExtension.slice(-1) == "D") {
                    const isElement = (element) => element == "D";
                    sufijo.splice(sufijo.findIndex(isElement), 1);
                }
            }
        });
        return nombreBaseAdjunto + sufijo[0];

    }
    agregarAdjunto(obj) {
        if ((obj.files.length + tempArchivoAdjuntoList.length) <= 5) {
            if (obj.files != undefined && obj.files.length > 0) {
                Array.prototype.forEach.call(obj.files, (file) => {

                    if (this.estaHabilitadoLaExtension(file) == true) {
                        const nombreAdjunto = this.obtenerNombreDeNuevoAdjunto() + '.tif';
                        let payload = {
                            id: this.makeId(),
                            fecha_emision: moment().format('YYYY-MM-DD'),
                            nameFile: nombreAdjunto,
                            action: 'GUARDAR',
                            file: file
                        };
                        this.addToTablaArchivos(payload);

                        tempArchivoAdjuntoList.push(payload);
                        // console.log(tempArchivoAdjuntoList);
                        // console.log(payload);
                    } else {
                        Swal.fire(
                            'Este tipo de archivo no esta permitido adjuntar',
                            file.name,
                            'warning'
                        );
                    }
                });
            }
        } else {
            Swal.fire(
                'Esta permitido adjuntar un máximo de 5 adjuntos',
                '',
                'warning'
            );
        }
    }

    addToTablaArchivos(payload) {

        let html = '';
        html = `<tr id="${payload.id}" style="text-align:center">
            <td style="text-align:left;">${payload.nameFile}</td>
            <td style="text-align:center;">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoMatrimonio" title="Visualizar" data-id="${payload.id}"  disabled>Visualizar</button>
                    <button type="button" class="btn btn-outline-danger btn-xs eliminarArchivoAdjunto"  name="btnEliminarAdjuntoMatrimonio" title="Eliminar" data-id="${payload.id}" >Eliminar</button>
                </div>
            </td>
            </tr>`;

        document.querySelector("table[id='tablaListaAdjuntosDeMatrimonio'] tbody").insertAdjacentHTML('beforeend', html);

    }

    eliminarArchivoAdjunto(obj) {
        obj.closest("tr").remove();
        var regExp = /[a-zA-Z]/g; //expresión regular
        if ((regExp.test(obj.dataset.id) == true)) {
            tempArchivoAdjuntoList = tempArchivoAdjuntoList.filter((element, i) => element.id != obj.dataset.id);
        } else {
            if (tempArchivoAdjuntoList.length > 0) {
                let indice = tempArchivoAdjuntoList.findIndex(elemnt => elemnt.id == obj.dataset.id);
                tempArchivoAdjuntoList[indice].action = 'ELIMINAR';
            } else {
                Swal.fire(
                    '',
                    'Hubo un error inesperado al intentar eliminar el adjunto, puede que no el objecto este vacio, elimine adjuntos y vuelva a seleccionar',
                    'error'
                );
            }

        }
    }

}