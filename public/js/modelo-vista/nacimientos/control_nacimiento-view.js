var tempArchivoAdjuntoList = [];
class ControlNacimientoView {

    constructor(model) {
        this.model = model;
    }

    /**
     * inicializar mediante DataTables
     */
    obtenerNacimiento = () => {

        let idByURL = parseInt(location.search.split('id=')[1]);
        Util.cambiarEstadoBotonera('DESHABILITAR', ['guardar']);

        if ((idByURL) != null && idByURL >0) {
            this.model.cargarDatosNacimiento(idByURL).then((respuesta) => {
                console.log(respuesta);
                $('[name=id]').val(respuesta.id);
                $('[name=ano_nac]').val(respuesta.ano_nac);
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
                switch (respuesta.condic_nac) {
                    case 1:
                        document.querySelector("input[id='condicionOrdinaria']").checked = true;
                        break;
                    case 2:
                        document.querySelector("input[id='condicionExtraordinaria']").checked = true;
                        break;
                    case 3:
                        document.querySelector("input[id='condicionEspecial']").checked = true;
                        break;
                    default:
                        document.querySelector("input[id='condicionOrdinaria']").checked = false
                        document.querySelector("input[id='condicionExtraordinaria']").checked = false
                        document.querySelector("input[id='condicionEspecial']").checked = false
                        break;
                }
                $('[name=observa]').text(respuesta.observa);

            // adjuntos
            Util.limpiarTabla("tablaListaAdjuntosDeNacimiento");

            let html = '';
            if(respuesta.adjunto!=null && respuesta.adjunto.existe_archivo_nombre_base ==true){
                tempArchivoAdjuntoList.push({
                    id: respuesta.adjunto.nombre_base,
                    fecha_emision:'',
                    nameFile: respuesta.adjunto.nombre_base+'.tif',
                    action: '',
                    file: []
                })
                html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base+'.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento"  title="Visualizar" 
                        data-nombre-archivo="${respuesta.adjunto.nombre_base+'.tif'}"  
                        data-año="${respuesta.ano_nac}"  
                        data-libro="${respuesta.nro_lib}"  
                        data-folio="${respuesta.nro_fol}"  
                        disabled>Visualizar</button>
                     </div>
                </td>
                </tr>`;
            }
            if(respuesta.adjunto!=null && respuesta.adjunto.existe_archivo_nombre_a ==true){
                tempArchivoAdjuntoList.push({
                    id: respuesta.adjunto.nombre_base+'A',
                    fecha_emision:'',
                    nameFile: respuesta.adjunto.nombre_base+'A.tif',
                    action: '',
                    file: []
                })
                html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base+'A.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento"  title="Visualizar"  disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
            }
            if(respuesta.adjunto!=null && respuesta.adjunto.existe_archivo_nombre_b ==true){
                tempArchivoAdjuntoList.push({
                    id: respuesta.adjunto.nombre_base+'B',
                    fecha_emision:'',
                    nameFile: respuesta.adjunto.nombre_base+'B.tif',
                    action: '',
                    file: []
                })
                html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base+'B.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento"  title="Visualizar"  disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
            }
            if(respuesta.adjunto!=null && respuesta.adjunto.existe_archivo_nombre_c ==true){
                tempArchivoAdjuntoList.push({
                    id: respuesta.adjunto.nombre_base+'C',
                    fecha_emision:'',
                    nameFile: respuesta.adjunto.nombre_base+'C.tif',
                    action: '',
                    file: []
                })
                html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base+'C.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento"  title="Visualizar"  disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
            }
            if(respuesta.adjunto!=null && respuesta.adjunto.existe_archivo_nombre_d ==true){
                tempArchivoAdjuntoList.push({
                    id: respuesta.adjunto.nombre_base+'D',
                    fecha_emision:'',
                    nameFile: respuesta.adjunto.nombre_base+'D.tif',
                    action: '',
                    file: []
                })
                html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base+'D.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento"  title="Visualizar"  disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
            }
            if(respuesta.adjunto!=null && respuesta.adjunto.existe_archivo_nombre_e ==true){
                tempArchivoAdjuntoList.push({
                    id: respuesta.adjunto.nombre_base+'E',
                    fecha_emision:'',
                    nameFile: respuesta.adjunto.nombre_base+'E.tif',
                    action: '',
                    file: []
                })
                html += `<tr style="text-align:center">
                <td style="text-align:left;">${respuesta.adjunto.nombre_base+'E.tif'}</td>
                <td style="text-align:center;">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento"  title="Visualizar"  disabled>Visualizar</button>
                    </div>
                </td>
                </tr>`;
            }
            if( respuesta.adjunto!=null &&
                respuesta.adjunto.existe_archivo_nombre_base ==false &&
                respuesta.adjunto.existe_archivo_nombre_a  == false &&
                respuesta.adjunto.existe_archivo_nombre_b  == false &&
                respuesta.adjunto.existe_archivo_nombre_c  == false &&
                respuesta.adjunto.existe_archivo_nombre_d  == false &&
                respuesta.adjunto.existe_archivo_nombre_e ==false){
                html += `<tr style="text-align:center">
                <td style="text-align:center;" colSpan="2">Sin adjuntos para mostrar</td>           
                </td>
                </tr>`;
            }
            
                document.querySelector("table[id='tablaListaAdjuntosDeNacimiento'] tbody").insertAdjacentHTML('beforeend', html);
        
            



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

        /**
         * buscar - Buscar en modal de listado de nacimientos
         */
        $("#botoneraPrincipal").on("click", "a.buscar", (e) => {

            $modal.find(".modal-title").text('Listado de Nacimientos');
            $modal.modal('show');
            this.listarNacimientos();
        });

        /**
         * nuevo - Nuevo nacimiento
         */
        $("#botoneraPrincipal").on("click", "a.nuevo", (e) => {

            // let url = `/nacimientos/control/index`;
            // var win = window.open(url, "_self");
            // win.focus();

            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "Nuevo Registro";
            Util.cambiarEstadoBotonera('DESHABILITAR', ['nuevo', 'modificar', 'observar']);
            Util.cambiarEstadoBotonera('HABILITAR', ['guardar']);


            $('#controlNacimientoForm')[0].reset();
            Util.readOnlyAllInputForm("controlNacimientoForm", false);
            Util.limpiarTabla("tablaListaAdjuntosDeNacimiento");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='condicionOrdinaria']").removeAttribute("disabled");
            document.querySelector("input[id='condicionExtraordinaria']").removeAttribute("disabled");
            document.querySelector("input[id='condicionEspecial']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
        });

        /**
         * nuevo - Nuevo nacimiento
         */
        $("#botoneraPrincipal").on("click", "a.guardar", (e) => {
            // const $form = $("#controlNacimientoForm").serializeArray();
            let formData = new FormData($('#controlNacimientoForm')[0]);
            if (tempArchivoAdjuntoList.length > 0) {
                tempArchivoAdjuntoList.forEach(element => {
                    if(element.action =='GUARDAR'){
                        formData.append(`id_adjunto[]`, element.id);
                        formData.append(`archivo_adjunto[]`, element.file);
                        formData.append(`nombre_adjunto[]`, element.nameFile);
                        formData.append(`accion_adjunto[]`, 'GUARDAR');
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
            Util.readOnlyAllInputForm("controlNacimientoForm", false, ['ano_nac', 'nro_lib', 'nro_fol']);


            // Util.limpiarTabla("tablaListaAdjuntosDeNacimiento");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='condicionOrdinaria']").removeAttribute("disabled");
            document.querySelector("input[id='condicionExtraordinaria']").removeAttribute("disabled");
            document.querySelector("input[id='condicionEspecial']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");


        });
        /**
         * modificar - Modificar registro
         */
        $("#botoneraPrincipal").on("click", "a.observar", (e) => {
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
                        } else if (respuesta.respuesta == "duplicado") {
                        }
                    }).fail(() => {
                        Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
                    }).always(() => {

                    });

                } else {
                    console.log('cancel');
                }
            })


        });
        /**
         * cancelar - Cancelar acción de accion nuevo, editar 
         */
        $("#botoneraPrincipal").on("click", "a.cancelar", (e) => {
            document.querySelector("span[id='descripcion-de-accion-formulario']").textContent = "";

            Util.cambiarEstadoBotonera('HABILITAR', ['nuevo', 'modificar', 'observar']);
            $('#controlNacimientoForm')[0].reset();
            Util.readOnlyAllInputForm("controlNacimientoForm", false);
            Util.limpiarTabla("tablaListaAdjuntosDeNacimiento");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='adjuntosNacimiento']").removeAttribute("disabled");
            document.querySelector("input[id='condicionOrdinaria']").removeAttribute("disabled");
            document.querySelector("input[id='condicionExtraordinaria']").removeAttribute("disabled");
            document.querySelector("input[id='condicionEspecial']").removeAttribute("disabled");
            document.querySelector("input[id='siAplicaRecibo']").removeAttribute("disabled");
            document.querySelector("input[id='noAplicaRecibo']").removeAttribute("disabled");
        });


        $("#tablaNacimiento").on("click", "button.seleccionar", (e) => {

            let url = `/nacimientos/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_self");
            win.focus();

        });

        /**
         * imprimir - Imprimir nacimiento 
         */
        $("#botoneraPrincipal").on("click", "a.imprimir", (e) => {
            const idNacimi = document.querySelector("input[name='id']").value;
            if (parseInt(idNacimi) > 0) {
                document.querySelector("div[id='modalRecibo'] input[name='nacimi_id']").value = idNacimi;

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
                        $modal.find(".modal-title").text('Listado de Nacimientos');
                        $modal.modal('show');
                        this.listarNacimientos();
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

        $('#tablaListaAdjuntosDeNacimiento').on("click", "button.visualizarArchivoAdjunto", (e) => {
            let url = `/nacimientos/control/visualizar-adjunto/?namefile=${$(e.currentTarget).data('nombre-archivo')}?year=${$(e.currentTarget).data('año')}?book=${$(e.currentTarget).data('libro')}?folio=${$(e.currentTarget).data('folio')}`;
            var win = window.open(url, "_black");
            win.focus();
        });
        $('#tablaListaAdjuntosDeNacimiento').on("click", "button.eliminarArchivoAdjunto", (e) => {
            this.eliminarArchivoAdjunto(e.currentTarget)
        });


        $('#modalRecibo').on("click", "button.guardarRecibo", (e) => {
            const $form = new FormData($('#formulario-recibo')[0]);
            // const $form = $("#controlNacimientoForm").serializeArray();
            const $route = route("nacimientos.control.guardar-recibo");
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
            document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").setAttribute("disabled",true);

        });
        
        $('#modalRecibo').on("click", "input.noAplicaRecibo", (e) => {
            $("#collapseRecibo").collapse("hide");
            document.querySelector("div[id='modalRecibo'] button[id='btnContinuar']").removeAttribute("disabled");
        });

        $('#modalRecibo').on("click", "button.continuar", (e) => {
            const elementTablaListaAdjuntos = document.querySelectorAll("table[id='tablaListaAdjuntosDeNacimiento'] tbody tr button");
   

            [].forEach.call(elementTablaListaAdjuntos, child => {
                child.removeAttribute("disabled");
            });

            Util.mensaje("info", "Se habilitó la botonera de la sección de adjuntos");

        });


        $(document).on("change", "input.handleChangeAgregarAdjunto", (e) => {
            this.agregarAdjunto(e.currentTarget);
        });

    }


    listarNacimientos = (anio_filtro = null, libro_filtro = null, folio_filtro = null, apellido_paterno_filtro = null, apellido_materno_filtro = null, nombres_filtro = null, fecha_desde_filtro = null, fecha_hasta_filtro = null) => {
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
                { data: 'ano_nac' },
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

    obtenerNombreDeNuevoAdjunto(){
        let nombreBaseAdjunto = ''.concat(document.querySelector("input[name='ano_nac']").value,document.querySelector("input[name='nro_fol']").value);
        let sufijo=["A","B","C","D","E"];
        tempArchivoAdjuntoList.forEach(element => {
            
            if(element.action=='' || element.action=='GUARDAR'){
                let nombreSinExtension= element.nameFile.slice(1,-4);
                if (nombreSinExtension.slice(-1) == "A") {
                    const isElement = (element) => element == "A";
                    sufijo.splice(sufijo.findIndex(isElement), 1);                    
                }else if(nombreSinExtension.slice(-1) == "B"){
                    const isElement = (element) => element == "B";
                    sufijo.splice(sufijo.findIndex(isElement), 1);    
                }else if(nombreSinExtension.slice(-1) == "C"){
                    const isElement = (element) => element == "C";
                    sufijo.splice(sufijo.findIndex(isElement), 1);    
                }else if(nombreSinExtension.slice(-1) == "D"){
                    const isElement = (element) => element == "D";
                    sufijo.splice(sufijo.findIndex(isElement), 1);    
                } 
            }
        });
        return nombreBaseAdjunto+sufijo[0];

    }
    agregarAdjunto(obj) {
        if(  (obj.files.length + tempArchivoAdjuntoList.length) <=5){
            if (obj.files != undefined && obj.files.length > 0) {
                Array.prototype.forEach.call(obj.files, (file) => {

                    if (this.estaHabilitadoLaExtension(file) == true) {
                        const nombreAdjunto = this.obtenerNombreDeNuevoAdjunto()+'.tif';
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
        }else{
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
                    <button type="button" class="btn btn-outline-primary btn-xs visualizarArchivoAdjunto" name="btnVisualizarAdjuntoNacimiento" title="Visualizar" data-id="${payload.id}"  disabled>Visualizar</button>
                    <button type="button" class="btn btn-outline-danger btn-xs eliminarArchivoAdjunto"  name="btnEliminarAdjuntoNacimiento" title="Eliminar" data-id="${payload.id}" >Eliminar</button>
                </div>
            </td>
            </tr>`;

        document.querySelector("table[id='tablaListaAdjuntosDeNacimiento'] tbody").insertAdjacentHTML('beforeend', html);

    }

    eliminarArchivoAdjunto(obj){
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