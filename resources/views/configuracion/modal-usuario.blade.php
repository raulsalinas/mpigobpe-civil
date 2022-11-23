<div class="modal fade" id="modal-usuario" tabindex="-1" role="dialog" aria-labelledby="modal-usuario">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formulario-usuario" method="POST" autocomplete="off">
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
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Nombres completo:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nombre_largo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nombre corto:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nombre_corto">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Correo:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="correo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Usuario:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="usuario">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Contraseña:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="password" class="form-control form-control-sm" name="password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="condicionActaRadioOptions" id="condicionOrdinaria" value="1">
                                <label class="form-check-label" for="inlineRadio1">Addmi</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="condicionActaRadioOptions" id="condicionExtraordinaria" value="2">
                                <label class="form-check-label" for="inlineRadio2">Extraordinario</label>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="condicionActaRadioOptions" id="condicionEspecial" value="3">
                                <label class="form-check-label" for="inlineRadio3">Especial</label>
                                </div> -->
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" name="es_administrador">
                                    <label class="form-check-label" for="es_administrador">Acceso como administrador</label>
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