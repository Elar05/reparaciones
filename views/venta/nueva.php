<?php require_once 'views/layout/head.php'; ?>

<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <form id="form_venta" class="row" method="POST" novalidate>
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="detalle_venta" id="detalle_venta">

        <div class="col-4">
          <div class="card">
            <div class="card-header">
              <h4>Datos del cliente</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <?php require_once 'views/cliente/inputs.php'; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-5">
          <div class="card">
            <div class="card-header">
              <h4>Productos en venta</h4>
            </div>
            <div class="card-body">
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

          <div class="card">
            <div class="card-header">
              <h4>Productos a comprar</h4>
            </div>
            <div class="card-body">
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
            </div>
          </div>
        </div>

        <div class="col-3">
          <div class="card">
            <div class="card-header">
              <h4>Pago</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="comprobante">Comprobante</label>
                <select id="comprobante" name="comprobante" class="form-control">
                  <option value="B">Boleta</option>
                  <option value="F">Factura</option>
                </select>
              </div>

              <div class="d-flex">
                <div class="form-group">
                  <label for="subtotal">Subtotal</label>
                  <input id="subtotal" name="subtotal" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="igv">IGV (18%)</label>
                  <input id="igv" name="igv" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="total">Total</label>
                  <input id="total" name="total" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" class="form-control">
              </div>

              <div class="d-flex justify-content-end">
                <button class="btn btn-success text-uppercase" id="save_venta">Registrar Nueva Venta <i class="fas fa-check"></i></button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= URL ?>public/bundles/datatables/datatables.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= URL ?>public/js/venta.js" type="module"></script>

<?php require_once 'views/layout/foot.php'; ?>