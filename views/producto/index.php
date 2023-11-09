<?php require_once 'views/layout/head.php'; ?>

<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<?php require_once 'views/layout/header.php'; ?>

<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Registrar Nueva Reparación</h4>
              <div class="card-header-action">
                <a data-collapse="#card_producto" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
              </div>
            </div>
            <div class="collapse" id="card_producto">
              <div class="card-body">
                <form id="form_producto" class="row" method="post" novalidate>
                  <input type="hidden" name="id" id="id">
                  <input type="hidden" name="action" id="action" value="create">
                  <input type="hidden" name="urlFoto" id="urlFoto">

                  <div class="col-md-6">
                    <div class="row">
                      <?php require_once 'views/equipo/inputs.php'; ?>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-6 form-group">
                        <label for="unidad">Unidad</label>
                        <select id="unidad" name="unidad" class="form-control" style="width: 100%;" required>
                          <option value="" selected disabled>__ Seleccione __</option>
                        </select>

                        <div class="invalid-feedback">
                          Oh no! Unidad is invalid.
                        </div>
                      </div>
                      <div class="col-6 form-group">
                        <label for="destino">Destino</label>
                        <select id="destino" name="destino" class="form-control" required>
                          <option value="" selected disabled>__ Seleccione __</option>
                          <option value="1">Tienda</option>
                          <option value="2">Local</option>
                        </select>

                        <div class="invalid-feedback">
                          Oh no! Tipo is invalid.
                        </div>
                      </div>

                      <div class="col-6 form-group">
                        <label for="precio_c">P. Compra</label>
                        <input type="number" id="precio_c" name="precio_c" class="form-control" required>
                        <div class="invalid-feedback">
                          Oh no! P. Compra is invalid.
                        </div>
                      </div>

                      <div class="col-6 form-group">
                        <label for="precio_v">P. Venta</label>
                        <input type="number" id="precio_v" name="precio_v" class="form-control" required>
                        <div class="invalid-feedback">
                          Oh no! producto is invalid.
                        </div>
                      </div>

                      <div class="col-6 form-group">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" class="form-control" required>
                        <div class="invalid-feedback">
                          Oh no! Stock is invalid.
                        </div>
                      </div>

                      <div class="col-6 form-group">
                        <label for="stock_min">Stock Min</label>
                        <input type="number" id="stock_min" name="stock_min" class="form-control" required>
                        <div class="invalid-feedback">
                          Oh no! Stock Min is invalid.
                        </div>
                      </div>

                      <div class="col-6 form-group">
                        <label for="foto">Foto</label>
                        <input type="file" id="foto" name="foto" class="form-control" accept=".png, .jpg, .jpeg, .webp, .svg">
                      </div>

                      <div class="col-6 form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mt-2 text-right">
                    <button class="btn btn-primary">Registrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h4>Mantenimiento de productos</h4>

              <button type="button" class="btn btn-primary" id="add_producto">
                <i class="fa fa-plus"></i> Agregar</button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped w-100" id="table_producto">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Modelo - Serie</th>
                      <th>Unidad</th>
                      <th>P. C.</th>
                      <th>P. V.</th>
                      <th>Stock</th>
                      <th>Stock min</th>
                      <th>Estado</th>
                      <th>Acciones</th>
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

  <div class="modal fade" id="modal_img" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto de producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="body_img"></div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= URL ?>public/bundles/datatables/datatables.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= URL ?>public/bundles/select2/dist/js/select2.full.min.js"></script>

<script src="<?= URL ?>public/js/producto.js" type="module"></script>

<?php require_once 'views/layout/foot.php'; ?>