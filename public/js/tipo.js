// Load table
function loadTable() {
  $("#table_tipo").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "tipo/list",
      data: {},
    },
  });
}

$(document).ready(function () {
  loadTable();
});

// Establecer la acción al agregar tipo -> create
$("#add_tipo").click(function () {
  $("#action").val("create");
  $("#form_tipo")[0].reset();
  $("#id").val("");
});

// Form tipo => create / update
$("#form_tipo").submit(function (e) {
  e.preventDefault();
  e.stopPropagation();

  var form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();
    $.post(
      `tipo/${url}`,
      data,
      function (data, textStatus, jqXHR) {
        form[0].reset();
        $("#modal_tipo").modal("toggle");

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
  }

  form.addClass("was-validated");
});

// Llenar el form tipo
$(document).on("click", "button.edit", function () {
  $("#form_tipo")[0].reset();
  $("#action").val("edit");
  $("#modal_tipo").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    `tipo/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("tipo" in data) {
        $("#id").val(data.tipo.id);
        $("#nombre").val(data.tipo.nombre);
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

// Cambiar estado
$(document).on("click", "button.estado", function () {
  let id = $(this).data("id"),
    estado = $(this).data("estado");
  $.post(
    `tipo/updateStatus`,
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
