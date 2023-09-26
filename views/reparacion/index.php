<?php require_once 'views/layout/head.php'; ?>

<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/bootstrap-daterangepicker/daterangepicker.css">

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Mantenimiento de reparaciones</h4>

              <button type="button" class="btn btn-primary" id="add_reparacion" data-toggle="modal" data-target="#modal_reparacion">
                <i class="fa fa-plus"></i> Agregar</button>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <label for="f_inicio">Fecha de inicio:</label>
                  <input type="date" name="f_inicio" id="f_inicio">

                  <label for="f_fin">Fecha de fin:</label>
                  <input type="date" name="f_fin" id="f_fin">

                  <button id="filtrarBtn" class="btn btn-info">Filtrar</button>
                  <button id="clean_filtro" class="btn btn-success">Limpiar</button>
                </div>

                <div class="col-6">
                  <input type="text" id="fechas" class="form-control daterange-cus">
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-striped w-100" id="table_reparacion">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Técnico</th>
                      <th>Cliente</th>
                      <th>Modelo - Serie</th>
                      <th>Costo</th>
                      <th>F. Inicio</th>
                      <th>F. Fin</th>
                      <th>Estado</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal_reparacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulario reparación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_reparacion" method="POST" novalidate>
            <input type="hidden" class="input_hidden" name="id" id="id">
            <input type="hidden" class="input_hidden clean_equipo" name="idequipo" id="idequipo">
            <input type="hidden" class="input_hidden" name="action" id="action" value="create">

            <ul class="nav nav-pills" id="myTab3" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tab-cliente" data-toggle="tab" href="#tab_cliente" role="tab" aria-controls="cliente" aria-selected="true">Datos del cliente</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" id="tab-equipo" data-toggle="tab" href="#tab_equipo" role="tab" aria-controls="equipo" aria-selected="false">Datos del equipo</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" id="tab-reparacion" data-toggle="tab" href="#tab_reparacion" role="tab" aria-controls="reparacion" aria-selected="false">Datos de repación</a>
              </li>
            </ul>
            <div class="tab-content tab-bordered" id="myTabContent2">
              <div class="tab-pane fade active show" id="tab_cliente" role="tabpanel" aria-labelledby="tab-cliente">
                <?php require_once 'views/cliente/inputs.php'; ?>

                <div class="form-group text-right">
                  <button id="next1" class="btn btn-primary">Siguiente <i class="fas fa-arrow-right"></i></button>
                </div>
              </div>

              <div class="tab-pane fade" id="tab_equipo" role="tabpanel" aria-labelledby="tab-equipo">
                <div class="form-group">
                  <label for="equipo">Equipos del cliente</label>
                  <div class="input-group">
                    <select id="equipo" name="equipo" class="form-control clean_equipo">
                      <option value="" selected disabled>__ Seleccione __</option>
                    </select>
                    <div class="input-group-append">
                      <button class="btn btn-primary" id="clean_equipo"><i class="fas fa-times"></i></button>
                    </div>
                  </div>
                </div>

                <?php require_once 'views/equipo/inputs.php'; ?>

                <div class="form-group text-right">
                  <button id="next2" class="btn btn-primary">Siguiente <i class="fas fa-arrow-right"></i></button>
                </div>
              </div>

              <div class="tab-pane fade" id="tab_reparacion" role="tabpanel" aria-labelledby="tab-reparacion">
                <div class="form-group">
                  <label for="usuario">Técnico</label>
                  <select id="usuario" name="usuario" class="form-control" required>
                    <option value="" selected disabled>__ Seleccione __</option>
                    <?php
                    foreach ($this->d['usuarios'] as $usuario) {
                      echo "<option value='{$usuario['id']}'>{$usuario['nombres']}</option>";
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Seleccione un técnico
                  </div>
                </div>

                <div class="form-group">
                  <label for="detalle">Detalle</label>
                  <textarea id="detalle" name="detalle" class="form-control" required cols="30" rows="10"></textarea>
                  <div class="invalid-feedback">
                    Detalle es requerido.
                  </div>
                </div>

                <div class="form-group">
                  <label for="costo">Costo</label>
                  <input type="text" id="costo" name="costo" class="form-control" pattern="[0-9.]+" required>
                  <div class="invalid-feedback">
                    Costo es requerido. Solo digitos
                  </div>
                </div>

                <div class="form-group text-right">
                  <button type="submit" class="btn btn-primary">Registrar <i class="fas fa-check"></i></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<!-- JS Libraies -->
<script src="<?= URL ?>public/bundles/datatables/datatables.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/export-tables/buttons.flash.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/export-tables/jszip.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/export-tables/pdfmake.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/export-tables/vfs_fonts.js"></script>
<script src="<?= URL ?>public/bundles/datatables/export-tables/buttons.print.min.js"></script>
<script src="<?= URL ?>public/bundles/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Page Specific JS File -->
<script src="<?= URL ?>public/js/reparacion.js" type="module"></script>

<?php require_once 'views/layout/foot.php'; ?>