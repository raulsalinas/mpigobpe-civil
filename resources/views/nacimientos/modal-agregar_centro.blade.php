<div class="modal fade" id="modal-agregar_centro" tabindex="-1" role="dialog" aria-labelledby="modal-agregar_centro">

    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form id="formulario-agregar_centro" method="POST" autocomplete="off">
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Centro Asistencial:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nombre">
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