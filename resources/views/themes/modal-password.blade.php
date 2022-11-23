<div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modal-password">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form id="form-password" method="POST" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(this).closest('.modal').modal('hide')"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-row mb-3">
                        <div class="col-md-12">
                            <h6>Nueva contraseña</h6>
                            <div class="input-group">
                                <input type="password" name="profile_password" class="form-control form-control-sm" placeholder="Ingrese la nueva contraseña">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-block btn-success shadow-none">Grabar nueva contraseña</button>
                </div>
            </form>
        </div>
    </div>
</div>