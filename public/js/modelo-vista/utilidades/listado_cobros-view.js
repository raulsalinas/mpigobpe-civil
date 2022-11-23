
class ListadoCobrosView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listar = (anio_filtro = null, libro_filtro = null, folio_filtro = null, apellido_paterno_filtro = null, apellido_materno_filtro = null, nombres_filtro = null, fecha_desde_filtro = null, fecha_hasta_filtro = null, condicion_filtro = null) => {
        const $tabla = $('#tablaCobros').DataTable({
            dom: 'Bfrtip',
            buttons: [
 
                {
                    extend: 'excelHtml5',
                    text: '<span class="far fa-file-excel" aria-hidden="true"></span> Descargar página actual',
                    customize: function ( xlsx ){
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
         
                        // jQuery selector to add a border
                        $('row c[r*="10"]', sheet).attr( 's', '25' );
    
                    },
                    className: 'btn-success btn-sm'

                },
                {
                    text: '<span class="far fa-file-excel" aria-hidden="true"></span> Descargar todo los registros',
                    attr: {
                        id: 'btnDescargarListaCobrosExcel'
                    },
                    action: () => {
                        this.descargarListaCobrosExcel();

                    },
                    className: 'btn-success btn-sm'
                }
                
            ],
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaCobros_filter');
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
                $('#tablaCobros_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaCobros_filter input').trigger('focus');
            },
            order: [[2, 'asc']],
            ajax: {
                url: route('utilidades.cobros.listar'),
                method: 'POST',
                data: {
                    'anio_filtro': anio_filtro,
                    'libro_filtro': libro_filtro,
                    'folio_filtro': folio_filtro,
                    'apellido_paterno_filtro': apellido_paterno_filtro,
                    'apellido_materno_filtro': apellido_materno_filtro,
                    'nombres_filtro': nombres_filtro,
                    'fecha_desde_filtro': fecha_desde_filtro,
                    'fecha_hasta_filtro': fecha_hasta_filtro,
                    'condicion_filtro': condicion_filtro
                },
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'fecha', className: 'text-center' },
                { data: 'recibo' },
                { data: 'tipo', className: 'text-center' },
                { data: 'ano', className: 'text-center' },
                { data: 'libro', className: 'text-center' },
                { data: 'folio', className: 'text-center' },
                { data: 'tiprec' },
                { data: 'monto', className: 'text-right' },
                { data: 'solicitant' },
                { data: 'estado', className: 'text-center' },
                // { data: 'accion', orderable: false, searchable: false, className: 'text-center' }
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaCobros_filter input').attr('disabled', true);
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

    descargarListaCobrosExcel(){
        window.open(`reporte-cobros-excel`);

    }

    /**
     * Se ejecutan los eventos que nacen de una accion, solo crear funcion a parte de ser necesario
     */

    eventos = () => {

        /**
         * Ver - Ver información por ID y llenar en el formulario
         */
        $("#tablaCobros").on("click", "button.ver", (e) => {

            let url = `/matrimonios/control/index/?id=${$(e.currentTarget).data('id')}`;
            var win = window.open(url, "_blank");
            win.focus();

        });

        /**
         * filtrar - Filtrar de listado de matrimonio
         */
        $("#modal-filtro_matrimonio").on("click", "button.filtrar", (e) => {
            const $modal = $("#modal-filtro_matrimonio");

            let anioEjeFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='anio_eje_filtro']").value;
            let nroLibFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='nro_lib_filtro']").value;
            let nroFolFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='nro_fol_filtro']").value;
            let apellidoPaternoFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='apellido_paterno_filtro']").value;
            let apellidoMaternoFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='apellido_materno_filtro']").value;
            let nombresFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='nombres_filtro']").value;
            let fechaDesdeFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='fecha_desde_filtro']").value;
            let fechaHastaFiltro = document.querySelector("div[id='modal-filtro_matrimonio'] input[name='fecha_hasta_filtro']").value;

            let condicionFiltro;
            let condicion = document.querySelectorAll("div[id='modal-filtro_matrimonio'] input[name='condicionActaRadioOptions']");
            condicion.forEach(element => {
                if (element.checked) {
                    condicionFiltro = element.value;
                }
            });


            this.listar(anioEjeFiltro, nroLibFiltro, nroFolFiltro, apellidoPaternoFiltro, apellidoMaternoFiltro, nombresFiltro, fechaDesdeFiltro, fechaHastaFiltro, condicionFiltro);
            $modal.modal("hide");

        });

    }
}