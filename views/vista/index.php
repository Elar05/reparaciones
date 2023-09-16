<?php require_once 'views/layout/head.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Mantenimiento de vistas</h4>

              <a href="<?= URL ?>vista/create" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</a>
            </div>
            <div class="card-body">
              <div class="mb-2"><?php $this->showMessages() ?></div>

              <div class="table-responsive">
                <table class="table table-striped w-100">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Vista</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($this->d['vistas'] as $vista) : ?>
                      <tr>
                        <td><?= $vista['id'] ?></td>
                        <td><?= $vista['vista'] ?></td>
                        <td>
                          <a href="<?= URL . "vista/edit/" . $vista['id'] ?>" class='ml-1 btn btn-warning'><i class='fas fa-pencil-alt'></i></a>
                          <button class='btn btn-danger delete' id='<?= $vista['id'] ?>'><i class='fas fa-times'></i></button>
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
    </div>
  </section>
</div>

<?php require_once 'views/layout/footer.php'; ?>
<script>
  $(document).on("click", "button.delete", function() {
    let id = $(this).attr("id");
    swal({
      title: "¿Seguro de querer eliminar?",
      text: "",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        window.location.href = `<?= URL ?>vista/delete?id=${id}`;
      }
    });
  });
</script>
<?php require_once 'views/layout/foot.php'; ?>