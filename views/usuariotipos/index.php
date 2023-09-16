<?php require_once 'views/layout/head.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Mantenimiento de tipo de usuarios</h4>

            <a href="<?= URL ?>usuariotipos/create" class="btn btn-primary">
              <i class="fa fa-plus"></i> Agregar Nuevo</a>
          </div>
          <div class="card-body">
            <div class="mb-2"><?php $this->showMessages() ?></div>

            <div class="table-responsive">
              <table class="table table-striped w-100">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Permisos</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($this->d["tipos"] as $tipo) : ?>
                    <tr>
                      <td><?= $tipo['id'] ?></td>
                      <td><?= $tipo['tipo'] ?></td>
                      <td>
                        <button class='btn btn-success permisos' data-id='<?= $tipo['id'] ?>' data-toggle="modal" data-target="#modal_usuario"><i class="fas fa-id-card"></i></button>
                      </td>
                      <td>
                        <a href="<?= URL ?>usuariotipos/edit/<?= $tipo['id'] ?>" class="ml-1 btn btn-warning">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="<?= URL ?>usuariotipos/delete?id=<?= $tipo['id'] ?>" class="btn btn-danger">
                          <i class="fas fa-times"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
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
          <h5 class="modal-title">Asignar vistas al tipo de usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <div class="selectgroup selectgroup-pills">
                  <input type="hidden" id="tipo">
                  <?php foreach ($this->d['vistas'] as $vista) : ?>
                    <label class="selectgroup-item">
                      <input type="checkbox" name="vista" id="vista<?= $vista['id'] ?>" value="<?= $vista['id'] ?>" class="selectgroup-input vista">
                      <span class="selectgroup-button"><?= $vista['vista'] ?></span>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= URL ?>public/js/usuariotipos.js"></script>

<?php require_once 'views/layout/foot.php'; ?>