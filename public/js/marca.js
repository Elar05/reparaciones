// Load table
function loadTable() {
  $("#table_marca").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "marca/list",
      data: {},
    },
  });
}

$(document).ready(function () {
  loadTable();
});

// Establecer la acción al agregar marca -> create
$("#add_marca").click(function () {
  $("#action").val("create");
  $("#form_marca")[0].reset();
  $("#id").val("");
  $("#form_marca").removeClass("was-validated");
});

// Form marca => create / update
$("#form_marca").submit(function (e) {
  e.preventDefault();
  e.stopPropagation();

  var form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();
    $.post(
      `marca/${url}`,
      data,
      function (data, textStatus, jqXHR) {
        form[0].reset();
        $("#modal_marca").modal("toggle");

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

// Llenar el form marca
$(document).on("click", "button.edit", function () {
  $("#form_marca")[0].reset();
  $("#action").val("edit");
  $("#modal_marca").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    `marca/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("marca" in data) {
        $("#id").val(data.marca.id);
        $("#nombre").val(data.marca.nombre);
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
    `marca/updateStatus`,
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
