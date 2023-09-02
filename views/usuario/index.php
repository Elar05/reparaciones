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
            <h4>Mantenimiento de usuarios</h4>

            <button type="button" class="btn btn-primary" id="add_usuario" data-toggle="modal" data-target="#modal_usuario">
              <i class="fa fa-plus"></i> Agregar
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped w-100" id="table_usuario">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
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

  <div class="modal fade" id="modal_usuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulario usuarios</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_usuario" class="row" method="post" novalidate>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="action" id="action" value="create">

            <div class="col-md-6 col-12 form-group">
              <label for="nombres">Nombres</label>
              <input type="text" id="nombres" name="nombres" class="form-control" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ ]+" required>
              <div class="invalid-feedback">
                Oh no! Nombres is invalid.
              </div>
            </div>

            <div class="col-md-6 col-12 form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
              <div class="invalid-feedback">
                Oh no! Email is invalid.
              </div>
            </div>

            <div class="col-md-6 col-12 form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" class="form-control" required>
              <div class="invalid-feedback">
                Oh no! Password is invalid.
              </div>
            </div>

            <div class="col-md-6 col-12 form-group">
              <label for="tipo">Tipo</label>
              <select id="tipo" name="tipo" class="form-control" required>
                <option value="" selected disabled>__ Seleccione __</option>
                <option value="1">Admin</option>
                <option value="2">Secretaria</option>
                <option value="3">Técnico</option>
              </select>
              <div class="invalid-feedback">
                Oh no! Tipo is invalid.
              </div>
            </div>

            <div class="col-md-6 col-12 form-group">
              <label for="telefono">Teléfono</label>
              <input type="text" id="telefono" name="telefono" class="form-control" pattern="[0-9]+" required>
              <div class="invalid-feedback">
                Oh no! Teléfono is invalid.
              </div>
            </div>

            <div class="col-md-6 col-12 form-group">
              <label for="direccion">Dirección</label>
              <input type="text" id="direccion" name="direccion" class="form-control" pattern="[A-Za-z0-9 ]+" required>
              <div class="invalid-feedback">
                Oh no! Dirección is invalid.
              </div>
            </div>

            <div class="col-12 mt-2 text-right">
              <button type="submit" class="btn btn-primary">Registrar usuario</button>
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

<script src="<?= URL ?>public/js/usuario.js"></script>

<?php require_once 'views/layout/foot.php'; ?>