<?php require_once 'views/layout/head.php'; ?>
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-md-10 mx-auto">
        <div class="card">
          <div class="card-header">
            <h4>Mantenimiento de modelos de equipos</h4>

            <button class="btn btn-primary" id="add_modelo" data-toggle="modal" data-target="#modal_modelo">
              <i class="fa fa-plus"></i> Agregar</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped w-100" id="table_modelo">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Marca</th>
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

  <div class="modal fade" id="modal_modelo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulario modelos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_modelo" method="post" novalidate>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="action" id="action" value="create">

            <div class="form-group group_marca">
              <label for="tipo">Tipo</label>
              <div class="input-group">
                <select id="tipo" name="tipo" class="form-control select2 clean_equipo" style="width: 78%;" required>
                  <option value="" selected disabled>__ Seleccione __</option>
                </select>
                <div class="input-group-append">
                  <button type="button" class="btn btn-success shadow-none group_tipo group_modelo cancel_add_tipo" id="add_tipo"><i class="fas fa-plus"></i> Agregar</button>
                </div>
                <div class="invalid-feedback">
                  Seleccione tipo.
                </div>
              </div>
            </div>
            <div class="form-group group_tipo d-none" id="input_new_tipo">
              <label for="new_tipo">Agregar Nuevo Tipo</label>
              <input type="text" class="form-control" id="new_tipo">

              <div class="mt-2 d-flex justify-content-between">
                <button type="button" class="btn btn-danger shadow-none cancel_add_tipo">
                  <i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary shadow-none" id="save_new_tipo">
                  <i class="fas fa-check"></i> Guardar</button>
              </div>
            </div>

            <div class="form-group group_tipo">
              <label for="marca">Marca</label>
              <div class="input-group">
                <select id="marca" name="marca" class="form-control select2 input_equipo" style="width: 78%;" required>
                  <option value="" selected disabled>__ Seleccione __</option>
                </select>
                <div class="input-group-append">
                  <button type="button" class="btn btn-success shadow-none group_marca group_modelo cancel_add_marca" id="add_marca"><i class="fas fa-plus"></i> Agregar</button>
                </div>
                <div class="invalid-feedback">
                  Seleccione marca.
                </div>
              </div>

            </div>
            <div class="form-group group_marca d-none" id="input_new_marca">
              <label for="new_marca">Agregar Nueva Marca</label>
              <input type="text" class="form-control" id="new_marca">

              <div class="mt-2 d-flex justify-content-between">
                <button type="button" class="btn btn-danger shadow-none cancel_add_marca">
                  <i class="fas fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary shadow-none" id="save_new_marca">
                  <i class="fas fa-check"></i> Guardar</button>
              </div>
            </div>

            <div class="form-group group_tipo group_marca">
              <label for="nombre">Modelo</label>
              <input type="text" id="nombre" name="nombre" class="form-control" pattern="[A-Za-z0-9-_. ]+" required>
              <div class="invalid-feedback">
                Oh no! modelo is invalid. (A-Z a-z 0-9 - _ .)
              </div>
            </div>

            <div class="mt-2 text-right group_tipo group_marca">
              <button class="btn btn-primary">Registrar modelo</button>
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
<script src="<?= URL ?>public/bundles/select2/dist/js/select2.full.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= URL ?>public/js/modelo.js" type="module"></script>
<?php require_once 'views/layout/foot.php'; ?>