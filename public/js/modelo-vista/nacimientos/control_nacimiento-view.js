class ControlNacimientoView {

    constructor(model) {
        this.model = model;

        let searchParams = new URLSearchParams(window.location.search);
        document.querySelector("input[name='condicionActa']").value = searchParams.get('id_tipo');
        this.condicionActa=searchParams.get('id_tipo');
        this.updateSubtituloCondicionActa(parseInt(searchParams.get('id_tipo')));
    }

    /**
     * inicializar mediante DataTables
     */
    obtenerNacimiento = () => {

        let idByURL = parseInt(location.search.split('id=')[1]);
        Util.cambiarEstadoBotonera('DESHABILITAR', ['guardar']);

        if ((idByURL) != null && idByURL > 0) {
            this.model.cargarDatosNacimiento(idByURL).then((respuesta) => {
                console.log(respuesta);
                $('[name=id]').val(respuesta.id);
                $('[name=ano_eje]').val(respuesta.ano_eje);
                $('[name=nro_lib]').val(respuesta.nro_lib);
                $('[name=nro_fol]').val(respuesta.nro_fol);

                $('[name=ano_nac]').val(respuesta.ano_nac);
                $('[name=ape_pat_nac]').val(respuesta.ape_pat_nac);
                $('[name=ape_mat_nac]').val(respuesta.ape_mat_nac);
                $('[name=nom_nac]').val(respuesta.nom_nac);
                $('[name=sex_nac]').val(respuesta.sex_nac);
                // $('[name="cen_asi"]').val(respuesta.cen_asi);
                // $('[name="ubigeo"]').val(respuesta.ubigeo);
                $('[name="cen_asi"]').val(respuesta.cen_asi).trigger('change')
                $('[name="ubigeo"]').val(respuesta.ubigeo).trigger('change')

                
                $('[name=fch_nac]').val(respuesta.fch_nac);
                $('[name=fch_ing]').val(respuesta.fch_ing);
                $('[name=tipo]').val(respuesta.tipo);
                $('[name=usuario]').val(respuesta.usuario);

                $('[name=ape_pad]').val(respuesta.ape_pad);
                $('[name=nom_pad]').val(respuesta.nom_pad);
                $('[name=dir_pad]').val(respuesta.dir_pad);

                $('[name=ape_mad]').val(respuesta.ape_mad);
                $('[name=nom_mad]').val(respuesta.nom_mad);
                $('[name=dir_mad]').val(respuesta.dir_mad);

                $('[name=condicionActa]').val(respuesta.condic);
                this.condicionActa=respuesta.condic;
                this.updateSubtituloCondicionActa(respuesta.condic);
                $('[name=observa]').text(respuesta.observa);
                $('[name=observa]').val(respuesta.observa);

                // adjuntos
                Util.limpiarTabla("tablaListaAdjuntos");

                let html = '';
                if (respuesta.adjuntos.length > 0) {
                    (respuesta.adjuntos).forEach(element => {
                        tempArchivoAdjuntoList.push({
                            id: element.id,
                            nombre_completo: element.nombre_completo,
                            nombre_extension: element.nombre_extension,
                            nombre_sin_extension: element.nombre_sin_extension,
                            tipo: 'nacimientos',
                            idtipo: 1,
                            ruta: element.ruta,
                            condic_id: element.condic_id,
                            accion: '',
                            archivo: []
                        })

                        html += `<tr style="text-align:center">
                        <td style="text-align:left;">${element.nombre_completo}</td>
                        <td style="text-align:center;">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-xs visualizarAdjunto" name="btnVisualizarAdjunto"  title="Visualizar" 
                                data-id-registro="${respuesta.id}"  
                                data-id-archivo="${element.id}"  
                                data-tipo="nacimientos"  
                                data-ruta="${element.ruta}"  
                                disabled>Visualizar</button>
                                <button type="button" class="btn btn-outline-primary btn-xs descargarAdjunto " name="btnDescargarAdjunto"  title="Descargar" 
                                data-id-registro="${respuesta.id}"  
                                data-id-archivo="${element.id}"  
                                data-tipo="nacimientos"  
                                data-ruta="${element.ruta}" 
                                disabled>Descargar</button>
                                <button type="button" class="btn btn-outline-danger btn-xs anularAdjunto" name="btnAnularadjunto"  title="Archivar" 
                                data-id-registro="${respuesta.id}"  
                                data-id-archivo="${element.id}"  
                                data-tipo="nacimientos"  
                                data-ruta="${element.ruta}" 
                                >Anular</button>
                            </div>
                        </td>
                        </tr>`;

                    });
                    document.querySelector("table[id='tablaListaAdjuntos'] tbody").insertAdjacentHTML('beforeend', html);

                } else if (respuesta.adjuntos.length == 0) {
                    this.mostrarAdjuntosSinResultados();
                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            });
        } else {
            this.mostrarAdjuntosSinResultados();

        }
    }

    mostrarAdjuntosSinResultados() {
        let html='';
            html += `<tr style="text-align:center">
        <td style="text-align:center;" colSpan="2">Sin adjuntos para mostrar</td>           
        </td>
        </tr>`;
        document.querySelector("table[id='tablaListaAdjuntos'] tbody").insertAdjacentHTML('beforeend', html);
    }

    /**
     * Se ejecutan los eventos que nacen de una accion, solo crear funcion a parte de ser necesario
     */

    eventos = () => {
        const $modal = $("#modalListadoDeNacimientos");

        /**
         * buscar - Buscar en modal de listado de nacimientos
         */
        // $("#botoneraPrincipal").on("click", "a.buscar", (e) => {

        //     $modal.find(".modal-title").text('Listado de Nacimientos');
        //     $modal.modal('show');
        //     this.listarNacimientos();
        // });

        /**
         * nuevo - Nuevo nacimiento
         */
        $("#botoneraPrincipal").on("click", "a.nuevo", (e) => {
 

            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "Nuevo Registro";
            Util.cambiarEstadoBotonera('DESHABILITAR', ['nuevo', 'modificar', 'observar']);
            Util.cambiarEstadoBotonera('HABILITAR', ['guardar']);


            $('#controlNacimientoForm')[0].reset();
            Util.readOnlyAllInputForm("controlNacimientoForm", false);
            Util.limpiarTabla("tablaListaAdjuntos");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionOrdinaria']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionExtraordinaria']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionEspecial']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
            tempArchivoAdjuntoList=[];

            window.history.replaceState(null, null, window.location.pathname+'?id_tipo='+this.condicionActa);
            document.querySelector("input[name='condicionActa']").value =this.condicionActa;
        });

        /**
         * nuevo - Nuevo nacimiento
         */
        $("#botoneraPrincipal").on("click", "a.guardar", (e) => {
            // const $form = $("#controlNacimientoForm").serializeArray();
            let formData = new FormData($('#controlNacimientoForm')[0]);
            if (tempArchivoAdjuntoList.length > 0) {
                tempArchivoAdjuntoList.forEach(element => {
                    if (element.accion == 'GUARDAR') {
                        formData.append(`id_list[]`, element.id);
                        formData.append(`nombre_completo_list[]`, element.nombre_completo);
                        formData.append(`nombre_extension_list[]`, element.nombre_extension);
                        formData.append(`nombre_sin_extension_list[]`, element.nombre_sin_extension);
                        formData.append(`tipo_list[]`, element.tipo);
                        formData.append(`accion_list[]`, 'GUARDAR');
                        formData.append(`archivo_list[]`, element.archivo);
                    }
                });
            }
            const $route = route(document.querySelector("input[name='id']").value > 0 ? "nacimientos.control.actualizar" : "nacimientos.control.guardar");
            console.log($route);
            this.model.registrarNacimiento(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    // window.history.pushState({ 'id': respuesta.id }, '', '/nacimientos/control/index');
                    let url = `/nacimientos/control/index/?id=${respuesta.id}`;
                    var win = window.open(url, "_self");
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
            Util.readOnlyAllInputForm("controlNacimientoForm", false, ['ano_eje', 'nro_lib', 'nro_fol']);


            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionOrdinaria']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionExtraordinaria']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionEspecial']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");


        });
    

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
                            'id': document.querySelector("form[id='controlNacimientoForm'] input[name='id']").value,
                            'observa': observacion
                        };
                        const $route = route("nacimientos.control.observar");
                        // console.log($data);
                        this.model.observarNacimiento($data, $route).then((respuesta) => {
                            Util.mensaje(respuesta.alerta, respuesta.mensaje);
                            if (respuesta.respuesta == "ok") {
                                let url = `/nacimientos/control/index/?id=${document.querySelector("form[id='controlNacimientoForm'] input[name='id']").value}`;
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
            } else {
                Util.mensaje("warning", "No seleccionó ningun registro que pueda ser observado");
            }

        });
    

        $("#botoneraPrincipal").on("click", "a.cancelar", (e) => {
            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "";

            Util.cambiarEstadoBotonera('HABILITAR', ['nuevo', 'modificar', 'observar']);
            $('#controlNacimientoForm')[0].reset();
            document.querySelector("div[name='observa']").textContent = "";
            Util.readOnlyAllInputForm("controlNacimientoForm", false);
            Util.limpiarTabla("tablaListaAdjuntos");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionOrdinaria']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionExtraordinaria']").removeAttribute("disabled");
            // document.querySelector("input[id='condicionEspecial']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
            tempArchivoAdjuntoList=[];
        });


        $("#tablaModalNacimiento").on("click", "button.seleccionar", (e) => {

            let url = `/nacimientos/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_self");
            win.focus();

        });

        $("#botoneraPrincipal").on("click", "a.imprimir", (e) => {
            const idNacimi = document.querySelector("input[name='id']").value;
            const ano = document.querySelector("input[name='ano_eje']").value;
            const libro = document.querySelector("input[name='nro_lib']").value;
            const folio = document.querySelector("input[name='nro_fol']").value;
            const condic = document.querySelector("input[name='condicionActa']").value;

            document.querySelector("div[id='modalRecibo'] button[id='btnGuardarRecibo']").removeAttribute("disabled");

            if (parseInt(idNacimi) > 0) {
                document.querySelector("div[id='modalRecibo'] input[name='nacimi_id']").value = idNacimi;
                document.querySelector("div[id='modalRecibo'] input[name='ano']").value = ano;
                document.querySelector("div[id='modalRecibo'] input[name='libro']").value = libro;
                document.querySelector("div[id='modalRecibo'] input[name='folio']").value = folio;
                document.querySelector("div[id='modalRecibo'] input[name='condic']").value = condic;

                $("#modalRecibo").find(".modal-title").text('Recibo');
                $("#modalRecibo").modal('show')

                document.querySelector("input[name='nro_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='nombre_solicitante_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='fecha_recibo']").removeAttribute("readOnly");
                document.querySelector("select[name='tipo_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='importe_recibo']").removeAttribute("readOnly");
                document.querySelector("input[name='detalle_recibo']").removeAttribute("readOnly");

            } else {

                Util.mensaje("info", "Primero debe seleccionar un registro");

            }
        });

        $('#modalRecibo').on("blur", "input.handleNroRecibo", (e) => {
            if ((e.currentTarget.value).length > 0) {
                document.querySelector("button[id='btnGuardarRecibo']").removeAttribute("disabled");
            } else {
                document.querySelector("button[id='btnGuardarRecibo']").setAttribute("disabled", true);

            }
        });


        $('#modalRecibo').on("click", "button.guardarRecibo", (e) => {
            const $form = new FormData($('#formulario-recibo')[0]);
            // const $route = route("nacimientos.control.guardar-recibo");
            const $route = route("nacimientos.control.guardar-cobro");
            this.model.registrarRecibo($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").removeAttribute("disabled");
                    // $('#modalRecibo').modal('hide');
                    document.querySelector("div[id='modalRecibo'] button[id='btnGuardarRecibo']").setAttribute("disabled",true);
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
            const elementTablaListaAdjuntos = document.querySelectorAll("table[id='tablaListaAdjuntos'] tbody tr button");
            const idRegistro = document.querySelector("form[id='controlNacimientoForm'] input[name='id']").value;

            [].forEach.call(elementTablaListaAdjuntos, child => {
                child.removeAttribute("disabled");
            });

            Util.mensaje("info", "Se habilitó la botonera de la sección de adjuntos");
            $('#modalRecibo').modal('hide');

            abrirPestañaVisualizarAdjunto(1,idRegistro, 0);
        });
    }

    // listarNacimientos = (anio_filtro = null, libro_filtro = null, folio_filtro = null, apellido_paterno_filtro = null, apellido_materno_filtro = null, nombres_filtro = null, fecha_desde_filtro = null, fecha_hasta_filtro = null) => {
    //     const $tabla = $('#tablaModalNacimiento').DataTable({
    //         dom: 'Bfrtip',
    //         pageLength: 20,
    //         language: idioma,
    //         destroy: true,
    //         serverSide: true,
    //         initComplete: function (settings, json) {
    //             const $filter = $('#tablaModalNacimiento_filter');
    //             const $input = $filter.find('input');
    //             $filter.append('<button id="btnBuscar" class="btn btn-default btn-sm pull-right" type="button"><i class="fas fa-search"></i></button>');
    //             $input.off();
    //             $input.on('keyup', (e) => {
    //                 if (e.key == 'Enter') {
    //                     $('#btnBuscar').trigger('click');
    //                 }
    //             });
    //             $('#btnBuscar').on('click', (e) => {
    //                 $tabla.search($input.val()).draw();
    //             });
    //         },
    //         drawCallback: function (settings) {
    //             $('#tablaModalNacimiento_filter input').prop('disabled', false);
    //             $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
    //             $('#tablaModalNacimiento_filter input').trigger('focus');
    //         },
    //         order: [[2, 'asc']],
    //         ajax: {
    //             url: route('nacimientos.listar'),
    //             method: 'POST',
    //             data: {
    //                 'anio_filtro': anio_filtro,
    //                 'libro_filtro': libro_filtro,
    //                 'folio_filtro': folio_filtro,
    //                 'apellido_paterno_filtro': apellido_paterno_filtro,
    //                 'apellido_materno_filtro': apellido_materno_filtro,
    //                 'nombres_filtro': nombres_filtro,
    //                 'fecha_desde_filtro': fecha_desde_filtro,
    //                 'fecha_hasta_filtro': fecha_hasta_filtro
    //             },
    //             headers: { 'X-CSRF-TOKEN': csrf_token }
    //         },
    //         columns: [
    //             {
    //                 render: function (data, type, row, index) {
    //                     return index.row + 1;
    //                 }, orderable: false, searchable: false, className: 'text-center'
    //             },
    //             { data: 'ano_nac' },
    //             { data: 'nro_lib' },
    //             { data: 'nro_fol' },
    //             { data: 'ape_pat_na' },
    //             { data: 'ape_mat_na' },
    //             { data: 'nom_nac' },
    //             { data: 'sexo_desc', name: 'sexo.nombre' },
    //             { data: 'ubigeo_desc', name: 'ubigeo.nombre' },
    //             { data: 'fch_nac' },
    //             { data: 'fch_ing' },
    //             { data: 'accion-seleccionar', orderable: false, searchable: false, className: 'text-center' }
    //         ],
    //         buttons: []
    //     });
    //     $tabla.on('search.dt', function () {
    //         $('#tablaModalNacimiento_filter input').attr('disabled', true);
    //         $('#btnBuscar').html('<i class="fas fa-clock" aria-hidden="true"></i>').prop('disabled', true);
    //     });
    //     $tabla.on('init.dt', function (e, settings, processing) {
    //         $(e.currentTarget).LoadingOverlay('show', { imageAutoResize: true, progress: true, imageColor: '#3c8dbc' });
    //     });
    //     $tabla.on('processing.dt', function (e, settings, processing) {
    //         if (processing) {
    //             $(e.currentTarget).LoadingOverlay('show', { imageAutoResize: true, progress: true, imageColor: '#3c8dbc' });
    //         } else {
    //             $(e.currentTarget).LoadingOverlay("hide", true);
    //         }
    //     });
    // }

    updateSubtituloCondicionActa(idCondicion) {
        let titulosCondicionActa = document.querySelectorAll("span[name='nombreCondicionActa']");
        switch (idCondicion) {
            case 1:
                titulosCondicionActa.forEach(element => {
                    element.textContent = 'Ordinario';
                });
                break;

            case 2:
                titulosCondicionActa.forEach(element => {
                    element.textContent = 'Extraordinario';
                });
                break;

            case 2:
                titulosCondicionActa.forEach(element => {
                    element.textContent = 'Especial';
                });
                break;

            default:
                break;
        }
    }

}

function getCarpetaPadreCondicion() {
    let condicionActa = document.querySelector("input[name='condicionActa']").value;
    switch (parseInt(condicionActa)) {
        case 1:
            return 'ordinarias';
            break;
        case 2:
            return 'extraordinarias';
            break;
        case 3:
            return 'especiales';
            break;

        default:
            return 'ordinarias';
            break;
    }
}


