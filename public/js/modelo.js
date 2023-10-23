import { getDataSelect, saveTipoOrMarcaOrModelo } from "./exports.js";

// Load table
function loadTable() {
  $("#table_modelo").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "modelo/list",
      data: {},
    },
  });
}

$(document).ready(function () {
  loadTable();
  $(".select2").select2({ dropdownParent: $(".modal") });
  getDataSelect("tipo", "tipo/list", { data: 1 });
  getDataSelect("marca", "marca/list", { data: 1 });
});

// Establecer la acción al agregar modelo -> create
$("#add_modelo").click(function () {
  $("#action").val("create");
  reset();
});

// Form modelo => create / update
$("#form_modelo").submit(function (e) {
  e.preventDefault();
  e.stopPropagation();

  var form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    let url = $("#action").val();
    $.post(
      `modelo/${url}`,
      data,
      function (data, textStatus, jqXHR) {
        if ("success" in data) {
          iziToast.success({
            title: "Éxito, ",
            message: data.success,
            position: "topCenter",
            displayMode: 1,
          });
          form[0].reset();
          loadTable();
          $("#modal_modelo").modal("toggle");
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

// Llenar el form modelo
$(document).on("click", "button.edit", function () {
  $("#modal_modelo").modal("toggle");
  reset();
  $("#action").val("edit");
  let id = $(this).attr("id");
  $.post(
    `modelo/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("modelo" in data) {
        const { id, idtipo, idmarca, nombre } = data.modelo;
        $("#id").val(id);
        $("#tipo").val(idtipo).trigger("change.select2");
        $("#marca").val(idmarca).trigger("change.select2");
        $("#nombre").val(nombre);
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
    `modelo/updateStatus`,
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

function reset() {
  $("#form_modelo")[0].reset();
  $("#form_modelo").removeClass("was-validated");
  $("#id").val("");
  $("#tipo").val("").trigger("change.select2");
  $("#marca").val("").trigger("change.select2");
}

// Agregar o cancelar
$(".cancel_add_tipo").click(function (e) {
  e.preventDefault();
  $(".group_tipo").toggleClass("d-none");
});
$(".cancel_add_marca").click(function (e) {
  e.preventDefault();
  $(".group_marca").toggleClass("d-none");
});

// Guardar nuevo tipo
$("#save_new_tipo").click(function (e) {
  e.preventDefault();
  if ($("#new_tipo").val() == "") {
    iziToast.warning({
      title: "Ingrese tipo",
      message: "",
      position: "topCenter",
      displayMode: 1,
    });
  } else {
    $(".group_tipo").toggleClass("d-none");
    saveTipoOrMarcaOrModelo("tipo/create", { nombre: $("#new_tipo").val() });
    getDataSelect("tipo", "tipo/list", { data: 1 });
  }
});
// Guardar nuevo marca
$("#save_new_marca").click(function (e) {
  e.preventDefault();
  if ($("#new_marca").val() == "") {
    iziToast.warning({
      title: "Ingrese marca",
      message: "",
      position: "topCenter",
      displayMode: 1,
    });
  } else {
    $(".group_marca").toggleClass("d-none");
    saveTipoOrMarcaOrModelo("marca/create", { nombre: $("#new_marca").val() });
    getDataSelect("marca", "marca/list", { data: 1 });
  }
});
