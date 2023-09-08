// Loadtable
function loadTable() {
  $("#table_cliente").DataTable({
    destroy: true,
    ajax: {
      type: "POST",
      url: "cliente/list",
    },
    order: [[0, "desc"]],
  });
}
$(document).ready(function () {
  loadTable();
});

// Al abrir el modal
$("#add_cliente").click(function (e) {
  e.preventDefault();
  $("#action").val("create");
  $("#form_cliente")[0].reset();
  $("#form_cliente").removeClass("was-validated");
  $("#id").val("");
});

// Register user => create / update
$("#form_cliente").submit(function (e) {
  e.preventDefault();

  let form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();

    $.post(
      `cliente/${url}`,
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
          $("#modal_cliente").modal("toggle");
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

// Buscar cliente
$("#search_cliente").click(function (e) {
  e.preventDefault();
  let documento = $("#documento").val();
  $.post(
    "cliente/get",
    { value: documento, column: "documento" },
    function (data, textStatus, jqXHR) {
      if ("success" in data) {
        iziToast.success({
          title: "Éxito, ",
          message: data.success,
          position: "topCenter",
          displayMode: 1,
        });
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

// Editar cliente
$(document).on("click", "button.edit", function () {
  $("#form_cliente")[0].reset();
  $("#action").val("edit");
  $("#modal_cliente").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    "cliente/get",
    { value: id },
    function (data, textStatus, jqXHR) {
      if ("cliente" in data) {
        $("#id").val(data.cliente.id);
        $("#nombres").val(data.cliente.nombres);
        $("#email").val(data.cliente.email);
        $("#telefono").val(data.cliente.telefono);
        $("#documento").val(data.cliente.documento);
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
