var tempArchivoAdjuntoList = [];
class ControlDefuncionView {

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
    obtenerDefuncion = () => {

        let idByURL = parseInt(location.search.split('id=')[1]);
        Util.cambiarEstadoBotonera('DESHABILITAR', ['guardar']);

        if ((idByURL) != null && idByURL > 0) {
            this.model.cargarDatosDefuncion(idByURL).then((respuesta) => {
                console.log(respuesta);
                $('[name=id]').val(respuesta.id);
                $('[name=ano_eje]').val(respuesta.ano_eje);
                $('[name=nro_lib]').val(respuesta.nro_lib);
                $('[name=nro_fol]').val(respuesta.nro_fol);

                $('[name=fch_des]').val(respuesta.fch_des);

                $('[name=ape_des]').val(respuesta.ape_des);
                $('[name=nom_des]').val(respuesta.nom_des);
                $('[name=dni]').val(respuesta.dni);
                $('[name=sexo]').val(respuesta.sexo);
                $('[name=lugar]').val(respuesta.lugar);
                $('[name=ubigeo]').val(respuesta.ubigeo);
                $('[name=cod_mot]').val(respuesta.cod_mot);


                $('[name=fch_des]').val(respuesta.fch_des);
                $('[name=fch_reg]').val(respuesta.fch_reg);

                $('[name=tipo]').val(respuesta.tipo);
                $('[name=usuario]').val(respuesta.usuario);
                $('[name=condicionActa]').val(respuesta.condic);
                this.updateSubtituloCondicionActa(respuesta.condic);
                $('[name=observa]').text(respuesta.observa);

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
                            tipo: 'defunciones',
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
                                data-tipo="defunciones"  
                                data-ruta="${element.ruta}"  
                                disabled>Visualizar</button>
                                <button type="button" class="btn btn-outline-primary btn-xs descargarAdjunto " name="btnDescargarAdjunto"  title="Descargar" 
                                data-id-registro="${respuesta.id}"  
                                data-id-archivo="${element.id}"  
                                data-tipo="defunciones"  
                                data-ruta="${element.ruta}" 
                                disabled>Descargar</button>
                                <button type="button" class="btn btn-outline-danger btn-xs anularAdjunto" name="btnAnularadjunto"  title="Archivar" 
                                data-id-registro="${respuesta.id}"  
                                data-id-archivo="${element.id}"  
                                data-tipo="defunciones"  
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
        const $modal = $("#modalListadoDeDefunciones");

 

        /**
         * nuevo - Nuevo matrimonio
         */
        $("#botoneraPrincipal").on("click", "a.nuevo", (e) => {

            // let url = `/defunciones/control/index`;
            // var win = window.open(url, "_self");
            // win.focus();

            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "Nuevo Registro";
            Util.cambiarEstadoBotonera('DESHABILITAR', ['nuevo', 'modificar', 'observar']);
            Util.cambiarEstadoBotonera('HABILITAR', ['guardar']);


            $('#controlDefuncionesForm')[0].reset();
            Util.readOnlyAllInputForm("controlDefuncionesForm", false);
            Util.limpiarTabla("tablaListaAdjuntos");
            document.querySelector("input[id='adjuntosDefuncion']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
            tempArchivoAdjuntoList=[];

            window.history.replaceState(null, null, window.location.pathname+'?id_tipo='+this.condicionActa);
            document.querySelector("input[name='condicionActa']").value =this.condicionActa;
        });

        /**
         * nuevo - Nuevo matrimonio
         */
        $("#botoneraPrincipal").on("click", "a.guardar", (e) => {
            // const $form = $("#controlDefuncionesForm").serializeArray();
            let formData = new FormData($('#controlDefuncionesForm')[0]);
            if (tempArchivoAdjuntoList.length > 0) {
                tempArchivoAdjuntoList.forEach(element => {
                    if (element.action == 'GUARDAR') {
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
            const $route = route(document.querySelector("input[name='id']").value > 0 ? "defunciones.control.actualizar" : "defunciones.control.guardar");
            console.log($route);
            this.model.registrarDefuncion(formData, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    let url = `/defunciones/control/index/?id=${respuesta.id}`;
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
            Util.readOnlyAllInputForm("controlDefuncionesForm", false, ['ano_des', 'nro_lib', 'nro_fol']);


            // Util.limpiarTabla("tablaListaAdjuntos");
            document.querySelector("input[id='adjuntosDefuncion']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosDefuncion']").removeAttribute("disabled");
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
                            'id': document.querySelector("form[id='controlDefuncionesForm'] input[name='id']").value,
                            'observa': observacion
                        };
                        const $route = route("defunciones.control.observar");
                        // console.log($data);
                        this.model.observarDefuncion($data, $route).then((respuesta) => {
                            Util.mensaje(respuesta.alerta, respuesta.mensaje);
                            if (respuesta.respuesta == "ok") {
                                let url = `/defunciones/control/index/?id=${document.querySelector("form[id='controlDefuncionesForm'] input[name='id']").value}`;
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
        /**
         * cancelar - Cancelar acción de accion nuevo, editar 
         */
        $("#botoneraPrincipal").on("click", "a.cancelar", (e) => {
            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "";

            Util.cambiarEstadoBotonera('HABILITAR', ['nuevo', 'modificar', 'observar']);
            $('#controlDefuncionesForm')[0].reset();
            document.querySelector("div[name='observa']").textContent = "";
            Util.readOnlyAllInputForm("controlDefuncionesForm", false);
            Util.limpiarTabla("tablaListaAdjuntos");
            document.querySelector("input[id='adjuntosDefuncion']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosDefuncion']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
            tempArchivoAdjuntoList=[];
        });




        $("#tablaModalDefuncion").on("click", "button.seleccionar", (e) => {

            let url = `/defunciones/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_self");
            win.focus();

        });

        /**
         * imprimir - Imprimir matrimonio 
         */
        $("#botoneraPrincipal").on("click", "a.imprimir", (e) => {
            const idNacimi = document.querySelector("input[name='id']").value;
            const ano = document.querySelector("input[name='ano_eje']").value;
            const libro = document.querySelector("input[name='nro_lib']").value;
            const folio = document.querySelector("input[name='nro_fol']").value;
            document.querySelector("div[id='modalRecibo'] button[id='btnGuardarRecibo']").removeAttribute("disabled");


            if (parseInt(idNacimi) > 0) {
                document.querySelector("div[id='modalRecibo'] input[name='nacimi_id']").value = idNacimi;
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
            // const $route = route("defunciones.control.guardar-recibo");
            const $route = route("defunciones.control.guardar-cobro");
            this.model.registrarRecibo($form, $route).then((respuesta) => {
                console.log(respuesta);
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").removeAttribute("disabled");
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
            const idRegistro = document.querySelector("form[id='controlDefuncionesForm'] input[name='id']").value;


            [].forEach.call(elementTablaListaAdjuntos, child => {
                child.removeAttribute("disabled");
            });

            Util.mensaje("info", "Se habilitó la botonera de la sección de adjuntos");
            $('#modalRecibo').modal('hide');

            abrirPestañaVisualizarAdjunto(3,idRegistro, 0);
        });

    }

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

function getCarpetaPadreCondicion(){
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
