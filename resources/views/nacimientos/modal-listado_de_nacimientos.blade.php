<div class="modal fade" id="modalListadoDeNacimientos" tabindex="-1" role="dialog" aria-labelledby="modal-listado_de_nacimientos">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="modal-listado-de-nacimientos">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(this).closest('.modal').modal('hide')"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-striped table-bordered table-okc-view" id="tablaModalNacimiento" width="100%">
                                <thead>
                                    <tr>
                                        <th width="10">N°</th>
                                        <th width="10">Año</th>
                                        <th width="10">Nro. Libro</th>
                                        <th width="10">Nro. Folio</th>
                                        <th width="50">Apellido Paterno</th>
                                        <th width="50">Apellido Matero</th>
                                        <th width="50">Nombres</th>
                                        <th width="10">Sexo</th>
                                        <th width="20">Ubigeo</th>
                                        <th width="20">Fecha de Nacimiento</th>
                                        <th width="20">Fecha de Inscripción</th>
                                        <th width="20">Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal" onclick="$(this).closest('.modal').modal('hide')">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>