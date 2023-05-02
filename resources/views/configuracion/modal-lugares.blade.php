<div class="modal fade" id="modal-lugares" tabindex="-1" role="dialog" aria-labelledby="modal-lugares">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formulario-lugares" method="POST" autocomplete="off">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="id" value="0">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(this).closest('.modal').modal('hide')"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Codigo:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="number" class="form-control form-control-sm" name="codigo" placeholder="número correlativo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nombre:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nombre">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Estado:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="estado" id="estado1" value="ACTIVO" checked>
                                        <label class="form-check-label" for="estado1">
                                            Activo
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="estado" id="estado2" value="INACTIVO">
                                        <label class="form-check-label" for="estado2">
                                            Inactivo
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal" onclick="$(this).closest('.modal').modal('hide')">Cerrar</button>
                        <button type="button" class="btn btn-pill btn-success shadow-none guardar" id="btnAccion">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>