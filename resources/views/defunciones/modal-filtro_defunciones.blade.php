<div class="modal fade" id="modal-filtro_defunciones" tabindex="-1" role="dialog" aria-labelledby="modal-filtro_defunciones">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formulario-filtro-defunciones" method="POST" autocomplete="off">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="id" value="0">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Año:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="anio_eje_filtro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Libro:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nro_lib_filtro">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Folio:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nro_fol_filtro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="apellido_paterno_filtro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="apellido_materno_filtro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm datetimepicker-input" name="nombres_filtro">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Fecha Desde:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="date" class="form-control form-control-sm datetimepicker-input" name="fecha_desde_filtro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Fecha Hasta:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="date" class="form-control form-control-sm datetimepicker-input"  name="fecha_hasta_filtro">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-pill btn-success shadow-none filtrar" id="btnFiltrar">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>