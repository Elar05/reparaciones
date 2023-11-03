import {
  changeMaxDoc,
  getCliente,
  getDataSelect,
  saveTipoOrMarcaOrModelo,
} from "./exports.js";

// Load table
function loadTable(data = {}) {
  $("#table_reparacion").DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: {
      type: "post",
      url: "reparacion/list",
      data,
    },
    dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "pdf", "print"],
    ordering: false,
  });
}
$(document).ready(function () {
  loadTable();

  $("#fechas").daterangepicker({
    locale: {
      format: "YYYY-MM-DD", // Formato de fecha deseado
      cancelLabel: "Cancelar",
      applyLabel: "Filtrar",
    },
    drops: "down",
    opens: "right",
  });

  // $(".select2").select2({ dropdownParent: $(".modal") });
  $(".select2").select2();
  getDataSelect("tipo", "tipo/list", { data: 1 });
  getDataSelect("marca", "marca/list", { data: 1 });
});

$("#filtrarBtn").click(function () {
  let fechaInicio = $("#f_inicio").val();
  let fechaFin = $("#f_fin").val();

  if (fechaInicio != "" && fechaFin != "") {
    loadTable({ fechaInicio, fechaFin });
  } else {
    iziToast.info({
      title: "Ingrese un rango de fechas a filtrar",
      message: "",
      position: "topCenter",
      displayMode: 1,
    });
  }
});
$("#clean_filtro").click(function (e) {
  loadTable();
});

$("#fechas").on("apply.daterangepicker", function (ev, picker) {
  let fechaInicio = picker.startDate.format("YYYY-MM-DD");
  let fechaFin = picker.endDate.format("YYYY-MM-DD");
  loadTable({ fechaInicio, fechaFin });
});
$("#fechas").on("cancel.daterangepicker", function (ev, picker) {
  loadTable();
});

// Establecer la acción => create
$("#add_reparacion").click(function (e) {
  e.preventDefault();
  $("#action").val("create");
  $("#form_reparacion")[0].reset();
  $(".input_hidden").val("");

  // Limpiar select de equipos de cliente, si es que hay
  getDataSelect("equipo");

  $(".input_cliente").removeAttr("disabled");
  $(".input_equipo").removeAttr("disabled");

  $("#tipo").val("").trigger("change.select2");
  $("#marca").val("").trigger("change.select2");
  getDataSelect("modelo");

  $("#card_reparacion").addClass("show");

  $("#form_reparacion").removeClass("was-validated");
});
$("#cancel_reparacion").click(function (e) {
  e.preventDefault();
  $("#card_reparacion").removeClass("show");
});

// Buscar cliente
$("#search_cliente").click(function (e) {
  e.preventDefault();
  getCliente({ value: $("#seriedoc").val(), column: "seriedoc" }, (data) => {
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
      $("#direccion").val("");
    } else {
      $("#nombres").val(data.cliente.nombres);
      $("#email").val(data.cliente.email);
      $("#telefono").val(data.cliente.telefono);
      $("#direccion").val(data.cliente.direccion);
    }
  });

  $.post(
    "equipo/getEquiposByCliente",
    {
      seriedoc: $("#seriedoc").val(),
    },
    function (data, textStatus, jqXHR) {
      if ("equipos" in data && data.equipos.length > 0) {
        data.equipos.forEach((equipo) => {
          $("#equipo").append(
            `<option value="${equipo.id}" tipo="${equipo.idtipo}" modelo="${equipo.idmodelo}" marca="${equipo.idmarca}" n_serie="${equipo.n_serie}">${equipo.modelo} - ${equipo.n_serie} - ${equipo.tipo} - ${equipo.marca}</option>`
          );
        });
      }
    },
    "json"
  );
});

// Traer las modelos por marca y tipo
$("#tipo, #marca").change(function () {
  getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
    tipo: $("#tipo").val(),
    marca: $("#marca").val(),
  });
});

// Rellenar el form de equpo si el cliente ya tiene registrados
$("#equipo").change(function (e) {
  e.preventDefault();
  $("#idequipo").val($("#equipo option:selected").val());
  $("#tipo")
    .val($("#equipo option:selected").attr("tipo"))
    .trigger("change.select2");
  $("#marca")
    .val($("#equipo option:selected").attr("marca"))
    .trigger("change.select2");

  getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
    tipo: $("#tipo").val(),
    marca: $("#marca").val(),
  });

  setTimeout(() => {
    $("#modelo")
      .val($("#equipo option:selected").attr("modelo"))
      .trigger("change.select2");
  }, 100);

  $("#n_serie").val($("#equipo option:selected").attr("n_serie"));
});

// Limipiar el form de equipo
$("#clean_equipo").click(function (e) {
  e.preventDefault();
  $(".input_equipo").val("");
  $("#equipo").val("").trigger("change.select2");
  $("#tipo").val("").trigger("change.select2");
  $("#marca").val("").trigger("change.select2");
  getDataSelect("modelo");
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
  getDataSelect("equipo");
  $("#modal_reparacion").modal("toggle");
  $("#action").val("edit");
  let id = $(this).attr("id");
  $.post(
    `reparacion/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("reparacion" in data) {
        // Datos de la reparacion
        $("#id").val(data.reparacion.id);
        $("#detalle").val(data.reparacion.detalle);
        $("#costo").val(data.reparacion.costo);
        $("#usuario").val(data.reparacion.idusuario);

        // Datos del cliente
        $("#iddoc").val(data.reparacion.iddoc);
        $("#seriedoc").val(data.reparacion.seriedoc);
        $("#nombres").val(data.reparacion.nombres);
        $("#email").val(data.reparacion.email);
        $("#telefono").val(data.reparacion.telefono);
        $("#direccion").val(data.reparacion.direccion);
        $(".input_cliente").attr("disabled", true);

        // Datos del equipo del cliente
        $("#tipo").val(data.reparacion.tipo).trigger("change.select2");
        $("#marca").val(data.reparacion.marca).trigger("change.select2");
        getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
          tipo: data.reparacion.tipo,
          marca: data.reparacion.marca,
        });
        setTimeout(() => {
          $("#modelo").val(data.reparacion.modelo).trigger("change.select2");
        }, 100);
        $("#n_serie").val(data.reparacion.n_serie);
        $(".input_equipo").attr("disabled", true);

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

// Cancel
$(".cancel_add_tipo").click(function (e) {
  e.preventDefault();
  $(".group_tipo").toggleClass("d-none");
  $("#new_tipo").val("");
});
$(".cancel_add_marca").click(function (e) {
  e.preventDefault();
  $(".group_marca").toggleClass("d-none");
  $("#new_marca").val("");
});
$(".cancel_add_modelo").click(function (e) {
  e.preventDefault();
  $(".group_modelo").toggleClass("d-none");
  $("#new_tipo").val("");
});

// Guardar nuevo tipo
$("#save_new_tipo").click(function (e) {
  e.preventDefault();
  $(".group_tipo").toggleClass("d-none");

  saveTipoOrMarcaOrModelo("tipo/create", { nombre: $("#new_tipo").val() });
  getDataSelect("tipo", "tipo/list", { data: 1 });
});
// Guardar nuevo marca
$("#save_new_marca").click(function (e) {
  e.preventDefault();
  $(".group_marca").toggleClass("d-none");

  saveTipoOrMarcaOrModelo("marca/create", { nombre: $("#new_marca").val() });

  getDataSelect("marca", "marca/list", { data: 1 });
  getDataSelect("modelo");
});
// Guardar nuevo modelo
$("#save_new_modelo").click(function (e) {
  e.preventDefault();
  $(".group_modelo").toggleClass("d-none");

  saveTipoOrMarcaOrModelo("modelo/create", {
    tipo: $("#tipo").val(),
    marca: $("#marca").val(),
    nombre: $("#new_modelo").val(),
  });

  getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
    tipo: $("#tipo").val(),
    marca: $("#marca").val(),
  });
});

// Agregar detalle a la reparacion
$(document).on("click", "button.terminar", function () {
  let id = $(this).attr("id"),
    estado = $(this).attr("estado");

  $("#modal_detalle").modal("toggle");
});
