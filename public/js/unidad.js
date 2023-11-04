// Load table
function loadTable() {
  $("#table_unidad").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "unidad/list",
      data: {},
    },
  });
}
$(document).ready(function () {
  loadTable();
});

// Establecer la acción al agregar unidad -> create
$("#add_unidad").click(function () {
  $("#form_unidad")[0].reset();
  $("#action").val("create");
  $("#id").val("");
  $("#form_unidad").removeClass("was-validated");
});

// Form unidad => create / update
$("#form_unidad").submit(function (e) {
  e.preventDefault();
  e.stopPropagation();

  var form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();
    $.post(
      `unidad/${url}`,
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
          $("#modal_unidad").modal("toggle");
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

// Llenar el form unidad
$(document).on("click", "button.edit", function () {
  $("#form_unidad")[0].reset();
  $("#action").val("edit");
  $("#modal_unidad").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    `unidad/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("unidad" in data) {
        $("#id").val(data.unidad.id);
        $("#codigo").val(data.unidad.codigo);
        $("#nombre").val(data.unidad.nombre);
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
    `unidad/updateStatus`,
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
