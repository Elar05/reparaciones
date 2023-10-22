<?php require_once 'views/layout/head.php'; ?>
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-md-8 mx-auto">
        <div class="card">
          <div class="card-header">
            <h4>Mantenimiento de tipos de equipos</h4>

            <button class="btn btn-primary" id="add_tipo" data-toggle="modal" data-target="#modal_tipo">
              <i class="fa fa-plus"></i> Agregar</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped w-100" id="table_tipo">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tipo</th>
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

  <div class="modal fade" id="modal_tipo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulario tipos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_tipo" method="post" novalidate>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="action" id="action" value="create">

            <div class="form-group">
              <label for="nombre">tipo</label>
              <input type="text" id="nombre" name="nombre" class="form-control" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ ]+" required>
              <div class="invalid-feedback">
                Oh no! tipo is invalid.
              </div>
            </div>

            <div class="mt-2 text-right">
              <button class="btn btn-primary">Registrar tipo</button>
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

<!-- Page Specific JS File -->
<script src="<?= URL ?>public/js/tipo.js"></script>
<?php require_once 'views/layout/foot.php'; ?>