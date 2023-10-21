import { getCliente } from "./exports.js";

// Loadtable
function loadTable() {
  $("#table_cliente").DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: {
      type: "POST",
      url: "cliente/list",
    },
    ordering: false,
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
  let seriedoc = $("#seriedoc");
  getCliente({ value: seriedoc.val(), column: "seriedoc" }, (data) => {
    if ("error" in data) {
      iziToast.error({
        title: "Error, ",
        message: data.error,
        position: "topCenter",
        displayMode: 1,
      });
    } else {
      iziToast.info({
        title: "El cliente ya está registrado",
        message: "",
        position: "topCenter",
        displayMode: 1,
      });
      seriedoc.val("");
      seriedoc.focus();
    }
  });
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
        const { id, seriedoc, nombres, email, telefono, direccion } = data.cliente;
        $("#id").val(id);
        $("#nombres").val(nombres);
        $("#email").val(email);
        $("#telefono").val(telefono);
        $("#seriedoc").val(seriedoc);
        $("#direccion").val(direccion);
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

// Eliminar cliente
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
        "cliente/delete",
        { id },
        function (data, textStatus, jqXHR) {
          if ("success" in data) {
            iziToast.success({
              title: "Éxito, ",
              message: data.success,
              position: "topCenter",
              displayMode: 1,
            });

            // Eliminar row del cliente
            $("#table_cliente").DataTable().row(row).remove().draw();
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

// Cambiar estado cliente
$(document).on("click", "button.estado", function () {
  let id = $(this).attr("id"),
    estado = $(this).attr("estado");

  $.post(
    "cliente/updateStatus",
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
