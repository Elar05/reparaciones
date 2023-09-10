<?php require_once 'views/layout/head.php'; ?>

<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

<style>
  .error {
    color: #fc544b !important;
  }
</style>
<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Mantenimiento de equipos</h4>

            <button type="button" class="btn btn-primary" id="add_equipo" data-toggle="modal" data-target="#modal_equipo">
              <i class="fa fa-plus"></i> Agregar
            </button>
          </div>
          <div class="card-body">
            <div class="mb-2"><?php $this->showMessages() ?></div>

            <div class="table-responsive">
              <table class="table table-striped w-100" id="table_equipo">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
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

  <div class="modal fade" id="modal_equipo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulario equipos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form_equipo" method="post" novalidate>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="action" id="action" value="create">

            <ul class="nav nav-pills" id="myTab3" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tab-cliente" data-toggle="tab" href="#tab_cliente" role="tab" aria-controls="cliente" aria-selected="true">Datos del cliente</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" id="tab-equipo" data-toggle="tab" href="#tab_equipo" role="tab" aria-controls="equipo" aria-selected="false">Datos del equipo</a>
              </li>
            </ul>
            <div class="tab-content tab-bordered" id="myTabContent2">
              <div class="tab-pane fade active show" id="tab_cliente" role="tabpanel" aria-labelledby="tab-cliente">
                <?php require_once 'views/cliente/inputs.php'; ?>

                <div class="form-group text-right">
                  <button id="next" class="btn btn-primary">Siguiente <i class="fas fa-arrow-right"></i></button>
                </div>
              </div>
              <div class="tab-pane fade" id="tab_equipo" role="tabpanel" aria-labelledby="tab-equipo">
                <?php require_once 'views/equipo/inputs.php'; ?>

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

<script src="<?= URL ?>public/bundles/datatables/datatables.min.js"></script>
<script src="<?= URL ?>public/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script src="<?= URL ?>public/bundles/jquery-steps/jquery.steps.min.js"></script>

<script src="<?= URL ?>public/js/equipo.js"></script>

<?php require_once 'views/layout/foot.php'; ?>