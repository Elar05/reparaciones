<?php require_once 'views/layout/head.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h4>Formulario de vista</h4>

              <a href="<?= URL ?>vista" class="btn btn-info"><i class="fas fa-arrow-left"></i> Listado</a>
            </div>
            <div class="card-body">
              <div class="mb-2"><?php $this->showMessages() ?></div>

              <form class="row needs-validation" method="post" action="<?= URL . "vista/" . $this->d['action'] ?>" novalidate>
                <input type="hidden" name="id" value="<?= $this->d['vista']['id'] ?? '' ?>">
                <div class="col-12 form-group">
                  <label for="vista">Vista</label>
                  <input type="text" name="vista" class="form-control" pattern="[A-Za-z]+" value="<?= $this->d['vista']['vista']  ?? '' ?>" required>
                  <div class="invalid-feedback">
                    Vista is invalid. Only letters
                  </div>
                </div>

                <div class="col-12 mt-2">
                  <button type="submit" class="btn btn-primary">Guardar</button>
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