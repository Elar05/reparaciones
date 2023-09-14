// Load table
function loadTable() {
  $("#table_reparacion").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "reparacion/list",
      data: {},
    },
    order: [[0, "desc"]],
  });
}
$(document).ready(function () {
  loadTable();
});

// Establecer la acción => create
$("#add_reparacion").click(function (e) {
  e.preventDefault();
  $("#action").val("create");
  $("#form_reparacion")[0].reset();

  $(".clean_equipo").val("");
  $(".clean_equipo").removeAttr("disabled");
  $(".inputs_disabled").removeAttr("disabled");

  $("#equipo").empty();
  $("#equipo").append(
    "<option value='' selected disabled>__ Seleccione __</option>"
  );

  $("#tab-cliente").addClass("active").removeClass("disabled");
  $("#tab-equipo").removeClass("active").addClass("disabled");
  $("#tab-reparacion").removeClass("active").addClass("disabled");

  $("#tab_cliente").addClass("active show");
  $("#tab_equipo").removeClass("active show");
  $("#tab_reparacion").removeClass("active show");

  $("#form_reparacion").removeClass("was-validated");
});

// Validar antes de pasar al siguiente tab => equipo
$("#next1").click(function (e) {
  e.preventDefault();
  if (
    $("#documento").val() === "" ||
    $("#nombres").val() === "" ||
    $("#email").val() === "" ||
    $("#telefono").val() === ""
  ) {
    $("#form_reparacion").addClass("was-validated");
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
  $("#tab-reparacion").removeClass("active").addClass("disabled");

  $("#tab_cliente").removeClass("active show");
  $("#tab_equipo").addClass("active show");
  $("#tab_reparacion").removeClass("active show");

  $("#form_reparacion").removeClass("was-validated");

  $.post(
    "equipo/getEquiposByCliente",
    {
      documento: $("#documento").val(),
    },
    function (data, textStatus, jqXHR) {
      if ("equipos" in data && data.equipos.length > 0) {
        data.equipos.forEach((equipo) => {
          $("#equipo").append(
            `<option value="${equipo.id}" tipo="${equipo.idtipo_equipo}" modelo="${equipo.modelo}" n_serie="${equipo.n_serie}" descripcion="${equipo.descripcion}">${equipo.tipo} - ${equipo.modelo} - ${equipo.n_serie}</option>`
          );
        });
      }
    },
    "json"
  );
});

// Validar antes de pasar al siguiente tab => reparacion
$("#next2").click(function (e) {
  e.preventDefault();
  if (
    $("#tipo").val() === "" ||
    $("#n_serio").val() === "" ||
    $("#descripcion").val() === "" ||
    $("#modelo").val() === ""
  ) {
    $("#form_reparacion").addClass("was-validated");
    iziToast.warning({
      title: "",
      message: "Completa el formulario",
      position: "topCenter",
      displayMode: 1,
    });
    return;
  }

  $("#tab-cliente").removeClass("active");
  $("#tab-equipo").removeClass("active");
  $("#tab-reparacion").addClass("active").removeClass("disabled");

  $("#tab_cliente").removeClass("active show");
  $("#tab_equipo").removeClass("active show");
  $("#tab_reparacion").addClass("active show");

  $("#form_reparacion").removeClass("was-validated");
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

// Rellenar el form de equpo si el cliente ya tiene registrados
$("#equipo").change(function (e) {
  e.preventDefault();
  $("#idequipo").val($("#equipo option:selected").val());
  $("#tipo").val($("#equipo option:selected").attr("tipo"));
  $("#modelo").val($("#equipo option:selected").attr("modelo"));
  $("#n_serie").val($("#equipo option:selected").attr("n_serie"));
  $("#descripcion").val($("#equipo option:selected").attr("descripcion"));
});

// Limipiar el form de equipo
$("#clean_equipo").click(function (e) {
  e.preventDefault();
  // $("#idequipo").val("");
  // $("#equipo").val("");
  // $("#tipo").val("");
  // $("#modelo").val("");
  // $("#n_serie").val("");
  // $("#descripcion").val("");
  $(".clean_equipo").val("");
});

// Enviar form
$("#form_reparacion").submit(function (e) {
  e.preventDefault();
  const form = $(this);

  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();

    $.post(
      `reparacion/${url}`,
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
          $("#modal_reparacion").modal("toggle");
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

// Llenar el form reparacion
$(document).on("click", "button.edit", function () {
  $("#form_reparacion")[0].reset();
  $(".input_hidden").val("");

  $("#equipo").empty();
  $("#equipo").append(
    "<option value='' selected disabled>__ Seleccione __</option>"
  );
  $("#modal_reparacion").modal("toggle");

  $("#action").val("edit");
  let id = $(this).attr("id");
  $.post(
    `reparacion/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("reparacion" in data) {
        $("#id").val(data.reparacion.id);
        $("#detalle").val(data.reparacion.detalle);
        $("#costo").val(data.reparacion.costo);
        $("#usuario").val(data.reparacion.idusuario);

        $("#documento")
          .val(data.reparacion.documento)
          .attr("disabled", "disabled");
        $("#nombres").val(data.reparacion.nombres).attr("disabled", "disabled");
        $("#email").val(data.reparacion.email).attr("disabled", "disabled");
        $("#telefono")
          .val(data.reparacion.telefono)
          .attr("disabled", "disabled");

        $("#tipo")
          .val(data.reparacion.idtipo_equipo)
          .attr("disabled", "disabled");
        $("#modelo").val(data.reparacion.modelo).attr("disabled", "disabled");
        $("#n_serie").val(data.reparacion.n_serie).attr("disabled", "disabled");
        $("#descripcion")
          .val(data.reparacion.descripcion)
          .attr("disabled", "disabled");

        $("#tab-cliente").removeClass("active disabled");
        $("#tab-equipo").removeClass("active disabled");
        $("#tab-reparacion").removeClass("disabled").addClass("active");

        $("#tab_cliente").removeClass("active show");
        $("#tab_equipo").removeClass("active show");
        $("#tab_reparacion").addClass("active show");
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

// Eliminar reparación
$(document).on("click", "button.delete", function () {
  let row = $(this).parent().parent();
  let id = $(this).attr("id");
  swal({
    title: "¿Seguro de querer eliminar?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.post(
        `reparacion/delete`,
        { id },
        function (data, textStatus, jqXHR) {
          if ("success" in data) {
            iziToast.success({
              title: "Éxito, ",
              message: data.success,
              position: "topCenter",
              displayMode: 1,
            });
            // Eliminar row del reparacion eliminado
            $("#table_reparacion").DataTable().row(row).remove().draw();
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

// Cambiar estado
$(document).on("click", "button.estado", function () {
  let id = $(this).attr("id"),
    estado = $(this).attr("estado");
  $.post(
    `reparacion/updateStatus`,
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
