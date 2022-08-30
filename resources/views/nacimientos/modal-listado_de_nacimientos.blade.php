<div class="modal fade" id="modalListadoDeNacimientos" tabindex="-1" role="dialog" aria-labelledby="modal-listado_de_nacimientos">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formulario-modal-listado-de-nacimientos" method="POST" autocomplete="off">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="id" value="0">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-striped table-bordered table-okc-view" id="tablaNacimiento" width="100%">
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
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>