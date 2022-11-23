<div class="modal fade" id="modalRecibo" tabindex="-1" role="dialog" aria-labelledby="modal-recibo">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formulario-recibo" method="POST" autocomplete="off">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="nacimi_id" value="0">
                <input type="hidden" name="ano" value="0">
                <input type="hidden" name="libro" value="0">
                <input type="hidden" name="folio" value="0">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal-recibo" onclick="$('#modalRecibo').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h6>Selecciona si corresponde aplicar pago o no para desbloquear las acciones de la sección de adjuntos.</h6>
                    <div class="card-body">
                        <div class="col-md-12 text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input siAplicaRecibo" type="radio" name="aplicaRecibo" id="siAplicaRecibo" value="1" data-target="#collapseRecibo" aria-expanded="false" aria-controls="collapseRecibo">
                                <label class="form-check-label" for="siAplicaRecibo">Aplica</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input noAplicaRecibo" type="radio" name="aplicaRecibo" id="noAplicaRecibo" value="0" data-target="#collapseRecibo" aria-expanded="false" aria-controls="collapseRecibo">
                                <label class="form-check-label" for="noAplicaRecibo">No aplica</label>
                            </div>
                        </div>

                        <div id="collapseRecibo" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Recibo Nro *</label>
                                            <input type="text" class="form-control form-control-sm handleNroRecibo" name="nro_recibo" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>Solicitante</label>
                                            <input type="text" class="form-control form-control-sm" name="nombre_solicitante_recibo" placeholder="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input type="date" class="form-control form-control-sm" name="fecha_recibo" placeholder="" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>Tipo recibo</label>
                                            <select class="form-control form-control-sm" name="tipo_recibo" readOnly>
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($tipoRegistroList as $tipo)
                                                <option value="{{$tipo->codigo}}">{{$tipo->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Importe S/ *</label>
                                            <input type="text" class="form-control form-control-sm" name="importe_recibo" placeholder="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <input type="text" class="form-control form-control-sm" name="detalle_recibo" placeholder="Comentario adiciona (Opcional)" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="btn btn-success btn-block btn-flat guardarRecibo" id="btnGuardarRecibo" disabled><i class="fas fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-primary continuar" id="btnContinuar" data-dismiss="modal" disabled>Continuar</button>
                        <button type="button" class="btn btn-pill btn-default" id="btnCerrar"  onclick="$('#modalRecibo').modal('hide');" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>