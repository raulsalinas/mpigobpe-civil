<div class="modal fade" id="modal-filtro_nacimientos" tabindex="-1" role="dialog" aria-labelledby="modal-filtro_nacimientos">

    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formulario-filtro-nacimiento" method="POST" autocomplete="off">
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Datos del registro</h5>
                                        <div class="card-text">
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
                                                        <div class="input-group date" data-target-input="nearest">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Datos del nacido</h5>
                                        <div class="card-text">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Año nacim.:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" name="ano_nac">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Nombres:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm datetimepicker-input busquedaEnTiempo" name="nom_nac">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Apellido Paterno:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm busquedaEnTiempo" name="ape_pat_nac">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Apellido Materno:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm busquedaEnTiempo" name="ape_mat_nac">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Datos del padre</h5>
                                        <div class="card-text">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Nombres del padre:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" name="nom_pad">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Apellidos del padre:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm" name="ape_pad">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">Datos de la madre</h5>
                                        <div class="card-text">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Nombres de la madre:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm datetimepicker-input" name="nom_mad">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Apellidos de la madre:</label>
                                                        <div class="input-group date" data-target-input="nearest">
                                                            <input type="text" class="form-control form-control-sm" name="ape_mad">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Fechas</h5>
                                <div class="card-text">
                                    <div class="row">

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Fecha Desde:</label>
                                                <div class="input-group date" data-target-input="nearest">
                                                    <input type="date" class="form-control form-control-sm datetimepicker-input" name="fch_nac_desde">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Fecha Hasta:</label>
                                                <div class="input-group date" data-target-input="nearest">
                                                    <input type="date" class="form-control form-control-sm datetimepicker-input" name="fch_nac_hasta">
                                                </div>
                                            </div>
                                        </div>

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