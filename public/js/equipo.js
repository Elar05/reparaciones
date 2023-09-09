// Loadtable
function loadTable() {
  $("#table_equipo").DataTable({
    destroy: true,
    ajax: {
      type: "POST",
      url: "equipo/list",
    },
    order: [[0, "desc"]],
  });
}
$(document).ready(function () {
  loadTable();
});

// Establecer la acción => create
$("#add_equipo").click(function (e) {
  e.preventDefault();
  $("#action").val("create");
  $("#form_equipo")[0].reset();

  $("#tab-cliente").addClass("active").removeClass("disabled");
  $("#tab-equipo").removeClass("active").addClass("disabled");

  $("#tab_cliente").addClass("active show");
  $("#tab_equipo").removeClass("active show");

  $("#form_equipo").removeClass("was-validated");
});

// Validar antes de pasar al siguiente tab
$("#next").click(function (e) {
  e.preventDefault();
  if (
    $("#documento").val() === "" ||
    $("#nombres").val() === "" ||
    $("#email").val() === "" ||
    $("#telefono").val() === ""
  ) {
    $("#form_equipo").addClass("was-validated");
    iziToast.warning({
      title: "",
      message: "Completa el formulario",
      position: "topCenter",
      displayMode: 1,
    });
    return;
  }

  $("#tab-cliente").removeClass("active");
  $("#tab-equipo").addClass("active").removeClass("disabled");

  $("#tab_cliente").removeClass("active show");
  $("#tab_equipo").addClass("active show");

  $("#form_equipo").removeClass("was-validated");
});

// Form equipo => create / edit
$("#form_equipo").submit(function (e) {
  e.preventDefault();
  const form = $(this);

  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();

    $.post(
      `equipo/${url}`,
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
          $("#modal_equipo").modal("toggle");
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

// Buscar cliente
$("#search_cliente").click(function (e) {
  e.preventDefault();
  $.post(
    "cliente/get",
    { value: $("#documento").val(), column: "documento" },
    function (data, textStatus, jqXHR) {
      if ("error" in data) {
        iziToast.error({
          title: "Error, ",
          message: data.error,
          position: "topCenter",
          displayMode: 1,
        });
        $("#nombres").val("");
        $("#email").val("");
        $("#telefono").val("");
      } else {
        $("#nombres").val(data.cliente.nombres);
        $("#email").val(data.cliente.email);
        $("#telefono").val(data.cliente.telefono);
      }
    },
    "json"
  );
});