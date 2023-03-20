<div class="modal fade" id="modal-filtro_matrimonios" tabindex="-1" role="dialog" aria-labelledby="modal-filtro_matrimonios">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formulario-filtro-matrimonios" method="POST" autocomplete="off">
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
                                    <label>Año:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="ano_eje">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Libro:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nro_lib">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Folio:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm" name="nro_fol">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Apellidos (Marido):</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm busquedaEnTiempo" name="ape_mar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nombres (Marido):</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm datetimepicker-input busquedaEnTiempo" name="nom_mar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Apellidos (Esposa):</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm busquedaEnTiempo" name="ape_esp">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nombres (Esposa):</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control form-control-sm datetimepicker-input busquedaEnTiempo" name="nom_esp">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Fecha Desde:</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="date" class="form-control form-control-sm datetimepicker-input" name="fch_cel_desde">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Fecha Hasta:</label>
                                    <div class="input-group date" data-target-input="nearest">
                                        <input type="date" class="form-control form-control-sm datetimepicker-input"  name="fch_cel_hasta">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row text-center">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condic" id="condicionOrdinaria" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Ordinario</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condic" id="condicionExtraordinaria" value="2">
                                    <label class="form-check-label" for="inlineRadio2">Extraordinario</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condic" id="condicionEspecial" value="3">
                                    <label class="form-check-label" for="inlineRadio3">Especial</label>
                                </div>
                            </div>
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal" onclick="$(this).closest('.modal').modal('hide')">Cerrar</button>
                        <button type="button" class="btn btn-pill btn-success shadow-none filtrar" id="btnFiltrar">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>