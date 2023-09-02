// Loadtable
function loadTable() {
  $("#table_usuario").DataTable({
    destroy: true,
    ajax: {
      type: "POST",
      url: "usuario/list",
    },
    order: [[0, "desc"]],
  });
}
$(document).ready(function () {
  loadTable();
});

// Register user => create / update
$("#form_usuario").submit(function (e) {
  e.preventDefault();

  let form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();

    $.post(
      `usuario/${url}`,
      data,
      function (data, textStatus, jqXHR) {
        if ("success" in data) {
          iziToast.success({
            title: "Éxito, ",
            message: data.success,
            position: "topCenter",
            displayMode: 1,
          });
          loadTable();

          form[0].reset();
          $("#modal_usuario").modal("toggle");
        } else {
          iziToast.error({
            title: "Error, ",
            message: data.error,
            position: "topCenter",
            displayMode: 1,
          });
        }
      },
      "json"
    );
  }

  form.addClass("was-validated");
});

// Editar usuario
$(document).on("click", "button.edit", function () {
  $("#form_usuario")[0].reset();
  $("#action").val("edit");
  $("#password").removeAttr("required");
  $("#modal_usuario").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    "usuario/get",
    { id },
    function (data, textStatus, jqXHR) {
      if ("usuario" in data) {
        $("#id").val(data.usuario.id);
        $("#nombres").val(data.usuario.nombres);
        $("#email").val(data.usuario.email);
        $("#tipo").val(data.usuario.idtipo_usuario);
        $("#telefono").val(data.usuario.telefono);
        $("#direccion").val(data.usuario.direccion);
      } else {
        iziToast.error({
          title: "Error, ",
          message: data.error,
          position: "topCenter",
          displayMode: 1,
        });
      }
    },
    "json"
  );
});

// Eliminar usuario
$(document).on("click", "button.delete", function () {
  let id = $(this).attr("id"),
    row = $(this).parent().parent();

  swal({
    title: "¿Seguro de querer eliminar?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((confirm) => {
    if (confirm) {
      $.post(
        "usuario/delete",
        { id },
        function (data, textStatus, jqXHR) {
          if ("success" in data) {
            iziToast.success({
              title: "Éxito, ",
              message: data.success,
              position: "topCenter",
              displayMode: 1,
            });

            // Eliminar row del usuario
            $("#table_usuario").DataTable().row(row).remove().draw();
          } else {
            iziToast.error({
              title: "Error, ",
              message: data.error,
              position: "topCenter",
              displayMode: 1,
            });
          }
        },
        "json"
      );
    }
  });
});

// Cambiar estado usuario
$(document).on("click", "button.estado", function () {
  let id = $(this).attr("id"),
    estado = $(this).attr("estado");

  $.post(
    "usuario/updateStatus",
    { id, estado },
    function (data, textStatus, jqXHR) {
      if ("success" in data) {
        iziToast.success({
          title: "Éxito, ",
          message: data.success,
          position: "topCenter",
          displayMode: 1,
        });
        loadTable();
      } else {
        iziToast.error({
          title: "Error, ",
          message: data.error,
          position: "topCenter",
          displayMode: 1,
        });
      }
    },
    "json"
  );
});
