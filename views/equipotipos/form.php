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
              <h4>Formulario tipo de equipo</h4>

              <a href="<?= URL ?>equipotipos" class="btn btn-info"><i class="fas fa-arrow-left"></i> Listado</a>
            </div>
            <div class="card-body">
              <div class="mb-2"><?php $this->showMessages() ?></div>

              <form class="row needs-validation" method="post" action="<?= URL . "equipotipos/" . $this->d['action'] ?>" novalidate>
                <input type="hidden" name="id" value="<?= $this->d['tipo']['id'] ?? '' ?>">
                <div class="col-12 form-group">
                  <label for="tipo">Tipo de equipo</label>
                  <input type="text" name="tipo" class="form-control" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ ]+" value="<?= $this->d['tipo']['tipo']  ?? ''?>" required>
                  <div class="invalid-feedback">
                    Oh no! Tipo de equipo is invalid. Only letters
                  </div>
                </div>

                <div class="col-12 mt-2">
                  <button type="submit" class="btn btn-primary">Guardar cambios</button>
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