<?php require_once 'views/layout/head.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Mantenimiento de tipos de equipos</h4>

            <a href="<?= URL ?>equipotipos/create" class="btn btn-primary">
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
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($this->d["tipos"] as $tipo) : ?>
                    <tr>
                      <td><?= $tipo['id'] ?></td>
                      <td><?= $tipo['tipo'] ?></td>
                      <td>
                        <a href="<?= URL ?>equipotipos/edit/<?= $tipo['id'] ?>" class="ml-1 btn btn-warning">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="<?= URL ?>equipotipos/delete?id=<?= $tipo['id'] ?>" class="btn btn-danger">
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
</div>

<?php require_once 'views/layout/footer.php'; ?>

<?php require_once 'views/layout/foot.php'; ?>