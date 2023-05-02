
class ListadoNacimientoView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = ( ano_eje=null ,nro_lib=null ,nro_fol=null ,ano_nac=null ,nom_nac=null ,ape_pat_nac=null ,ape_mat_nac=null ,nom_pad=null ,ape_pad=null ,nom_mad=null ,ape_mad=null ,fch_nac_desde=null ,fch_nac_hasta=null ,condic=null
        ) => {
        const $tabla = $('#tablaNacimiento').DataTable({
            dom: 'Blfrtip',
        lengthChange: false,
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
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
            ],
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
            order: [[1, 'desc']],
            ajax: {
                url: route('nacimientos.listar'),
                method: 'POST',
                data: {ano_eje ,nro_lib ,nro_fol ,ano_nac ,nom_nac ,ape_pat_nac ,ape_mat_nac ,nom_pad ,ape_pad ,nom_mad ,ape_mad ,fch_nac_desde ,fch_nac_hasta ,condic},
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, meta) {
                        
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'ano_eje',className: 'text-center' },
                { data: 'nro_lib' },
                { data: 'nro_fol' },
                { data: 'nom_nac' },
                { data: 'ape_pat_nac' },
                { data: 'ape_mat_nac' },
                { data: 'sex_nac' },
                { data: 'fch_nac', className: 'text-center' },
                { data: 'ubigeo_desc', name: 'ubigeo.nombre' },
                { data: 'nom_pad' },
                { data: 'ape_pad' },
                { data: 'nom_mad' },
                { data: 'ape_mad' },
                { data: 'fch_ing',  className: 'text-center' },
                { data: 'condic',  className: 'text-center', render: function(data,type,row,index){
                    return row.condic==1?'Ordinario':(row.condic ==2?'Extraordinario':(row.condic==3?'Especial':''));
                } },
                { data: 'observa'},
                { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
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

        $("#tablaNacimiento").on("click", "button.recuperar", (e) => {

            const $route = route("nacimientos.control.recuperar");
            this.model.recuperarNacimiento({'id':$(e.currentTarget).data('id')}, $route).then((respuesta) => {
                Util.mensaje(respuesta.alerta, respuesta.mensaje);
                if (respuesta.respuesta == "ok") {
                    this.listar(null);
                }
            }).fail(() => {
                Util.mensaje("error", "Hubo un problema. Por favor vuelva a intentarlo");
            }).always(() => {

            });


        });

        $('.busquedaEnTiempo').on('keyup', this.debounce(function () {
            document.querySelector("button[id='btnFiltrar']").click();
        }, 500));

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

            let ano_eje= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='ano_eje']").value;
            let nro_lib= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nro_lib']").value;
            let nro_fol= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nro_fol']").value;
            let ano_nac= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='ano_nac']").value;
            let nom_nac= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nom_nac']").value;
            let ape_pat_nac= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='ape_pat_nac']").value;
            let ape_mat_nac= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='ape_mat_nac']").value;
            let nom_pad= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nom_pad']").value;
            let ape_pad= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='ape_pad']").value;
            let nom_mad= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='nom_mad']").value;
            let ape_mad= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='ape_mad']").value;
            let fch_nac_desde= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='fch_nac_desde']").value;
            let fch_nac_hasta= document.querySelector("div[id='modal-filtro_nacimientos'] input[name='fch_nac_hasta']").value;
            let condic;
            let condicion= document.querySelectorAll("div[id='modal-filtro_nacimientos'] input[name='condic']");
            condicion.forEach(element => {
                if(element.checked){
                    condic=element.value;
                }else{
                    condic='';
                }
            });

            this.listar( ano_eje ,nro_lib ,nro_fol ,ano_nac ,nom_nac ,ape_pat_nac ,ape_mat_nac ,nom_pad ,ape_pad ,nom_mad ,ape_mad ,fch_nac_desde ,fch_nac_hasta ,condic);   
            // $modal.modal("hide");
            let cantidadFiltrosActivos=0;
            if(ano_eje !=''){cantidadFiltrosActivos++;}
            if(nro_lib != ''){cantidadFiltrosActivos++;}
            if(nro_fol != ''){cantidadFiltrosActivos++;}
            if(ano_nac !=''){cantidadFiltrosActivos++;}
            if(nom_nac !=''){cantidadFiltrosActivos++;}
            if(ape_pat_nac !=''){cantidadFiltrosActivos++;}
            if(ape_mat_nac !=''){cantidadFiltrosActivos++;}
            if(nom_pad !=''){cantidadFiltrosActivos++;}
            if(ape_pad !=''){cantidadFiltrosActivos++;}
            if(nom_mad !=''){cantidadFiltrosActivos++;}
            if(ape_mad !=''){cantidadFiltrosActivos++;}
            if(fch_nac_desde !=''){cantidadFiltrosActivos++;}
            if(fch_nac_hasta !=''){cantidadFiltrosActivos++;}
            if(condic !=''){cantidadFiltrosActivos++;}
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


    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };
}