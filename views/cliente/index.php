<?php require_once 'views/layout/head.php'; ?>

<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Mantenimiento de clientes</h4>

            <button type="button" class="btn btn-primary" id="add_cliente" data-toggle="modal" data-target="#modal_cliente">
              <i class="fa fa-plus"></i> Agregar
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped w-100" id="table_cliente">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Documento</th>
                    <th>Nombres</th>
                    <th>Email</th>
                    <th>Telefono</th>
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
  </section>

  <div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulario clientes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_cliente" class="row" method="post" novalidate>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="action" id="action" value="create">

            <?php require_once 'views/cliente/inputs.php'; ?>

            <div class="col-12 mt-2 text-right">
              <button type="submit" class="btn btn-primary">Registrar cliente</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= URL ?>public/bundles/datatables/datatables.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= URL ?>public/js/cliente.js"></script>

<?php require_once 'views/layout/foot.php'; ?>