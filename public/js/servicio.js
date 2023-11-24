// Load table
function loadTable() {
  $("#table_servicio").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "servicio/list",
      data: {},
    },
  });
}

$(document).ready(function () {
  loadTable();
});

// Establecer la acción al agregar servicio -> create
$("#add_servicio").click(function () {
  $("#form_servicio")[0].reset();
  $("#action").val("create");
  $("#id").val("");
  $("#form_servicio").removeClass("was-validated");
});

// Form servicio => create / update
$("#form_servicio").submit(function (e) {
  e.preventDefault();
  e.stopPropagation();

  let form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();
    $.post(
      `servicio/${url}`,
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
          $("#modal_servicio").modal("toggle");
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

// Llenar el form servicio
$(document).on("click", "button.edit", function () {
  $("#form_servicio")[0].reset();
  $("#action").val("edit");
  $("#modal_servicio").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    `servicio/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("servicio" in data) {
        $("#id").val(data.servicio.id);
        $("#nombre").val(data.servicio.nombre);
        $("#precio").val(data.servicio.precio);
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
    `servicio/updateStatus`,
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
