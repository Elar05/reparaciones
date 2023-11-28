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
              <h4>Registrar Nueva Reparación</h4>
              <div class="card-header-action">
                <a data-collapse="#card_reparacion" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
              </div>
            </div>
            <div class="collapse" id="card_reparacion">
              <div class="card-body">
                <form id="form_reparacion" method="POST" novalidate>
                  <input type="hidden" class="input_hidden" name="id" id="id">
                  <input type="hidden" class="input_hidden" name="idcliente" id="idcliente">
                  <input type="hidden" class="input_hidden" name="idequipo" id="idequipo">
                  <input type="hidden" class="input_hidden" name="action" id="action" value="create">

                  <div class="row">
                    <div class="col-md-4">
                      <div class="row">
                        <?php require_once 'views/cliente/inputs.php';
                        ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="row">
                        <div class="col-12 form-group group_tipo group_marca group_modelo">
                          <label for="equipo">Equipos del cliente</label>
                          <div class="input-group">
                            <select id="equipo" name="equipo" class="form-control select2 input_equipo" style="width: 91%;">
                              <option value="" selected disabled>__ Seleccione __</option>
                            </select>
                            <div class="input-group-append">
                              <button class="btn btn-primary" id="clean_equipo"><i class="fas fa-times"></i></button>
                            </div>
                          </div>
                        </div>

                        <?php require_once 'views/equipo/inputs.php';
                        ?>
                      </div>
                    </div>
                    <div class="col-md-4">
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
                        <label for="servicio">Tipo de Servicio</label>
                        <select id="servicio" name="servicio" class="form-control" required>
                          <option value="" selected disabled>__ Seleccione __</option>
                          <?php
                          foreach ($this->d['servicios'] as $servicio) {
                            echo "<option value='{$servicio['id']}' precio='{$servicio['precio']}'>{$servicio['nombre']}</option>";
                          }
                          ?>
                        </select>
                        <div class="invalid-feedback">
                          Seleccione un Tipo de Servicio
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="costo">Costo referencial</label>
                        <input type="text" id="costo" name="costo" class="form-control" pattern="[0-9.]+" required>
                        <div class="invalid-feedback">
                          Costo es requerido. Solo digitos
                        </div>
                      </div>

                      <div class="form-group text-right">
                        <button type="button" class="btn btn-dark" id="cancel_reparacion">Cancelar <i class="fa fa-times"></i></button>
                        <button type="submit" class="btn btn-primary">Registrar <i class="fas fa-check"></i></button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h4>Mantenimiento de reparaciones</h4>

              <button class="btn btn-primary" id="add_reparacion">
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

  <div class="modal fade" id="modal_detalle" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Finalizar reparación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <h4>Listado de Productos</h4>
              <div class="table-responsive">
                <table class="table table-striped table-sm w-100" id="table_producto">
                  <thead>
                    <tr>
                      <th>Modelo - Serie</th>
                      <th>Precio</th>
                      <th>Stock</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
            <div class="col-6">
              <h4>Factura y resumen</h4>

              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <select id="comrpobante" name="comrpobante" class="form-control">
                      <option value="B">Boleta</option>
                      <option value="F">Factura</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input id="doc_cliente" name="doc_cliente" class="form-control" placeholder="N° Documento">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input id="cliente" name="cliente" class="form-control" placeholder="Cliente">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <input id="descripcion" name="descripcion" class="form-control" placeholder="Descripción">
                  </div>
                </div>
                <input type="hidden" id="cliente_hide">
                <input type="hidden" id="doc_cliente_hide">
              </div>

              <table class="table table-sm w-100">
                <thead>
                  <tr>
                    <th style="width: 33%;">Desc.</th>
                    <th>Precio</th>
                    <th style="width: 17%;">Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id="tbody_detalle"></tbody>
              </table>

              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label for="subtotal">Subtotal</label>
                    <input id="subtotal" name="subtotal" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label for="igv">IGV (18%)</label>
                    <input id="igv" name="subtotal" class="form-control form-control-sm">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label for="total">Total</label>
                    <input id="total" name="total" class="form-control form-control-sm">
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-end">
                <input type="hidden" id="detalle_reparacion">
                <button class="btn btn-success" id="terminar">Guardar Detalle y Terminar <i class="fas fa-check"></i></button>
              </div>
            </div>
          </div>
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
<script src="<?= URL ?>public/bundles/select2/dist/js/select2.full.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= URL ?>public/js/reparacion.js" type="module"></script>

<?php require_once 'views/layout/foot.php'; ?>