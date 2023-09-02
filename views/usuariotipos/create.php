<?php require_once 'views/layout/head.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Registrar nuevo tipo de usuario</h4>

              <a href="<?= URL ?>usuariotipos" class="btn btn-info">
                <i class="fas fa-arrow-left"></i> Listado</a>
            </div>
            <div class="card-body">
              <div class="mb-2"><?php $this->showMessages() ?></div>

              <form class="row needs-validation" method="post" action="<?= URL ?>usuariotipos/save" novalidate>
                <div class="col-12 form-group">
                  <label for="tipo">Tipo de usuario</label>
                  <input type="text" name="tipo" class="form-control" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ ]+" required>
                  <div class="invalid-feedback">
                    Oh no! Tipo de usuario is invalid. Only letters
                  </div>
                </div>

                <div class="col-12 mt-2">
                  <button type="submit" class="btn btn-primary">Registrar tipo</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<?php require_once 'views/layout/foot.php'; ?>