// Establecer la acción => create
$("#add_reparacion").click(function (e) {
  e.preventDefault();
  $("#action").val("create");
  $("#form_reparacion")[0].reset();

  $(".clean_equipo").val("");

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
          // loadTable();
          form[0].reset();
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
