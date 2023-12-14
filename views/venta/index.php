<?php require_once 'views/layout/head.php'; ?>

<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Mantenimiento de ventas</h4>

              <a href="<?= URL ?>venta/nueva" class="btn btn-primary">
                <i class="fa fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body">
              <?php $this->showMessages() ?>

              <div class="table-responsive">
                <table class="table table-striped w-100" id="table_venta">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Vendedor</th>
                      <th>Cliente</th>
                      <th>Comprobante</th>
                      <th>Subtotal</th>
                      <th>IGV</th>
                      <th>Total</th>
                      <th>Fecha</th>
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

  <div class="modal fade" id="modal_detalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalle de venta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="body_detalle">
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= URL ?>public/bundles/datatables/datatables.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= URL ?>public/js/venta.js" type="module"></script>

<?php require_once 'views/layout/foot.php'; ?>