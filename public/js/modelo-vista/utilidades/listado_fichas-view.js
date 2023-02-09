
class ListadoFichasView {

    constructor(model) {
        this.model = model;
    }

    /**
     * Listar mediante DataTables
     */
    listarFichaNacimientos = () => {
        const $tabla = $('#tablaFichasNacimientos').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaFichasNacimientos_filter');
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
                $('#tablaFichasNacimientos_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaFichasNacimientos_filter input').trigger('focus');
            },
            order: [[7, 'desc']],
            ajax: {
                url: route('utilidades.fichas.listar-fichas-nacimientos'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'condicion.nombre', className: 'text-center' },
                { data: 'nombre_completo',className: 'text-left'  },
                { data: 'nombre_sin_extension', className: 'text-left' },
                { data: 'ruta', className: 'text-left' },
                { data: 'nombre_extension', className: 'text-center' },
                { data: 'nacimi_id', className: 'text-center' },
                { data: 'created_at', className: 'text-center'  },
                { data: 'deleted_at', className: 'text-center' },
                { data: 'id', className: 'text-center',  render:function(data, type, row, index){
                    return `<a href="${row.ruta}" target="_blank">${row.nombre_completo}</a>`;
                } },
                
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaFichasNacimientos_filter input').attr('disabled', true);
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
    listarFichaMatrimonios = () => {
        const $tabla = $('#tablaFichasMatrimonios').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaFichasMatrimonios_filter');
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
                $('#tablaFichasMatrimonios_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaFichasMatrimonios_filter input').trigger('focus');
            },
            order: [[7, 'desc']],
            ajax: {
                url: route('utilidades.fichas.listar-fichas-matrimonios'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'condicion.nombre', className: 'text-center' },
                { data: 'nombre_completo',className: 'text-left'  },
                { data: 'nombre_sin_extension', className: 'text-left' },
                { data: 'ruta', className: 'text-left' },
                { data: 'nombre_extension', className: 'text-center' },
                { data: 'matrim_id', className: 'text-center' },
                { data: 'created_at', className: 'text-center'  },
                { data: 'deleted_at', className: 'text-center' },
                { data: 'id', className: 'text-center',  render:function(data, type, row, index){
                    return `<a href="${row.ruta}" target="_blank">${row.nombre_completo}</a>`;
                } },
                
                
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaFichasMatrimonios_filter input').attr('disabled', true);
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
    listarFichaDefunciones = () => {
        const $tabla = $('#tablaFichasDefunciones').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            pageLength: 20,
            language: idioma,
            destroy: true,
            serverSide: true,
            initComplete: function (settings, json) {
                const $filter = $('#tablaFichasDefunciones_filter');
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
                $('#tablaFichasDefunciones_filter input').prop('disabled', false);
                $('#btnBuscar').html('<i class="fas fa-search"></i>').prop('disabled', false);
                $('#tablaFichasDefunciones_filter input').trigger('focus');
            },
            order: [[7, 'desc']],
            ajax: {
                url: route('utilidades.fichas.listar-fichas-defunciones'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf_token }
            },
            columns: [
                {
                    render: function (data, type, row, index) {
                        return index.row + 1;
                    }, orderable: false, searchable: false, className: 'text-center'
                },
                { data: 'condicion.nombre', className: 'text-center' },
                { data: 'nombre_completo',className: 'text-left'  },
                { data: 'nombre_sin_extension', className: 'text-left' },
                { data: 'ruta', className: 'text-left' },
                { data: 'nombre_extension', className: 'text-center' },
                { data: 'defun_id', className: 'text-center' },
                { data: 'created_at', className: 'text-center'  },
                { data: 'deleted_at', className: 'text-center' },
                { data: 'id', className: 'text-center',  render:function(data, type, row, index){
                    return `<a href="${row.ruta}" target="_blank">${row.nombre_completo}</a>`;
                } },
                
            ]
        });
        $tabla.on('search.dt', function () {
            $('#tablaFichasDefunciones_filter input').attr('disabled', true);
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