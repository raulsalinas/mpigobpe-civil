<div class="modal fade" id="modal-filtro_nacimientos" tabindex="-1" role="dialog" aria-labelledby="modal-filtro_nacimientos" style="top: -25px; position: absolute; left: 0px; right: 0px;">

    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formulario-filtro-nacimiento" method="POST" autocomplete="off">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="id" value="0">
                @csrf
                <div class="modal-header" style="padding: 8px;">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$(this).closest('.modal').modal('hide')"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="padding: 4px">
                    <div class="card-body" style="padding: 5px;">


                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Datos de registro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Datos del nacido</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Datos de padres</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Fecha Nacimiento Desde:</label>
                                                    <div class="input-group date" data-target-input="nearest">
                                                        <input type="date" class="form-control form-control-sm datetimepicker-input" name="fch_nac_desde">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Fecha Nacimiento Hasta:</label>
                                                    <div class="input-group date" data-target-input="nearest">
                                                        <input type="date" class="form-control form-control-sm datetimepicker-input" name="fch_nac_hasta">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condic" id="condicionTodos" value="4" checked>
                                    <label class="form-check-label" for="inlineRadio4">Mostrar Todos</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condic" id="condicionAnulados" value="5">
                                    <label class="form-check-label" for="inlineRadio5">Mostrar Anulados</label>
                                </div>
                            </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
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
                            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Nombres del padre:</label>
                                                <div class="input-group date" data-target-input="nearest">
                                                    <input type="text" class="form-control form-control-sm datetimepicker-input" name="nom_pad">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Apellidos del padre:</label>
                                                <div class="input-group date" data-target-input="nearest">
                                                    <input type="text" class="form-control form-control-sm" name="ape_pad">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Nombres de la madre:</label>
                                                    <div class="input-group date" data-target-input="nearest">
                                                        <input type="text" class="form-control form-control-sm datetimepicker-input" name="nom_mad">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
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

                    <div class="modal-footer" style="padding: 4px;">
                        <button type="button" class="btn btn-pill btn-default shadow-none" data-dismiss="modal" onclick="$(this).closest('.modal').modal('hide')">Cerrar</button>
                        <button type="button" class="btn btn-pill btn-success shadow-none filtrar" id="btnFiltrar">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>