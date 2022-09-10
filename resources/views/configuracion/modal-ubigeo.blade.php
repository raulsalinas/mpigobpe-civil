<div class="modal fade" id="modal-ubigeo" tabindex="-1" role="dialog" aria-labelledby="modal-ubigeo">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formulario-ubigeo" method="POST" autocomplete="off">
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
                                    <label>Codigo:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="anio_eje_filtro">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nombre corto:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nro_lib_filtro">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-pill btn-success shadow-none guardar" id="btnAccion">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>