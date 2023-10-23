import {
  changeMaxDoc,
  getCliente,
  getDataSelect,
  saveTipoOrMarcaOrModelo,
} from "./exports.js";

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
  $(".select2").select2({ dropdownParent: $(".modal") });
  getDataSelect("tipo", "tipo/list", { data: 1 });
  getDataSelect("marca", "marca/list", { data: 1 });
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

  $(".input_cliente").removeAttr("disabled");
  $("#tipo").val("").trigger("change.select2");
  $("#marca").val("").trigger("change.select2");
  getDataSelect("modelo");

  $("#form_equipo").removeClass("was-validated");
});

// Validar antes de pasar al siguiente tab
$("#next").click(function (e) {
  e.preventDefault();
  if (
    $("#seriedoc").val() === "" ||
    $("#nombres").val() === "" ||
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

  form.addClass("was-validated");
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
});

// Mostrar los datos del equipo en el modal
$(document).on("click", "button.edit", function () {
  $("#form_equipo")[0].reset();
  $("#modal_equipo").modal("toggle");
  $("#action").val("edit");
  let id = $(this).attr("id");
  $.post(
    `equipo/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("equipo" in data) {
        $("#id").val(data.equipo.id);

        $("#iddoc").val(data.equipo.iddoc).attr("disabled", "disabled");
        $("#seriedoc").val(data.equipo.seriedoc).attr("disabled", "disabled");
        $("#nombres").val(data.equipo.nombres).attr("disabled", "disabled");
        $("#email").val(data.equipo.email).attr("disabled", "disabled");
        $("#telefono").val(data.equipo.telefono).attr("disabled", "disabled");
        $("#direccion").val(data.equipo.direccion).attr("disabled", "disabled");

        $("#tipo").val(data.equipo.idtipo).trigger("change.select2");
        $("#marca").val(data.equipo.idmarca).trigger("change.select2");
        // Cargar el select de modelo
        getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
          tipo: $("#tipo").val(),
          marca: $("#marca").val(),
        });
        setTimeout(() => {
          $("#modelo").val(data.equipo.idmodelo).trigger("change.select2");
        }, 100);
        $("#n_serie").val(data.equipo.n_serie);

        $("#tab-cliente").removeClass("active");
        $("#tab-equipo").removeClass("disabled").addClass("active");
        $("#tab_equipo").addClass("active show");
        $("#tab_cliente").removeClass("active show");
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

// Eliminar equipo
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
        "equipo/delete",
        { id },
        function (data, textStatus, jqXHR) {
          if ("success" in data) {
            iziToast.success({
              title: "Éxito, ",
              message: data.success,
              position: "topCenter",
              displayMode: 1,
            });
            // Eliminar row del equipo
            $("#table_equipo").DataTable().row(row).remove().draw();
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

// Traer las modelos por marca y tipo
$("#tipo, #marca").change(function () {
  getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
    tipo: $("#tipo").val(),
    marca: $("#marca").val(),
  });
});

// Agregar o cancelar
$(".cancel_add_tipo").click(function (e) {
  e.preventDefault();
  $(".group_tipo").toggleClass("d-none");
});
$(".cancel_add_marca").click(function (e) {
  e.preventDefault();
  $(".group_marca").toggleClass("d-none");
});
$(".cancel_add_modelo").click(function (e) {
  e.preventDefault();
  $(".group_modelo").toggleClass("d-none");
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
    getDataSelect("modelo");
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
    getDataSelect("modelo");
  }
});
// Guardar nuevo modelo
$("#save_new_modelo").click(function (e) {
  e.preventDefault();
  if (
    $("#tipo").val() == "" ||
    $("#marca").val() == "" ||
    $("#new_modelo").val() == ""
  ) {
    iziToast.warning({
      title: "Ingrese datos",
      message: "",
      position: "topCenter",
      displayMode: 1,
    });
  } else {
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
  }
});

$("#iddoc").change(function () {
  changeMaxDoc();
});
