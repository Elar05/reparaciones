import { getDataSelect, saveTipoOrMarcaOrModelo } from "./exports.js";

// Load table
function loadTable() {
  $("#table_producto").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "producto/list",
      data: {},
    },
  });
}

$(document).ready(function () {
  loadTable();
  $(".select2").select2({ dropdownParent: $(".modal") });
  $(".select2").css("width", "74%");
  getDataSelect("tipo", "tipo/list", { data: 1 });
  getDataSelect("marca", "marca/list", { data: 1 });
  getDataSelect("unidad", "unidad/list", { data: 1 });
  $("#unidad").select2({ dropdownParent: $(".modal") });
});

// Establecer la acción al agregar producto -> create
$("#add_producto").click(function () {
  $("#form_producto")[0].reset();
  $("#action").val("create");
  $("#id").val("");
  $("#form_producto").removeClass("was-validated");
});

// Form producto => create / update
$("#form_producto").submit(function (e) {
  e.preventDefault();
  e.stopPropagation();

  var form = $(this);
  if (form[0].checkValidity()) {
    let data = new FormData(form[0]);
    let url = $("#action").val();
    $.ajax({
      type: "post",
      url: `producto/${url}`,
      data,
      contentType: false,
      processData: false,
      success: function (data) {
        data = JSON.parse(data);
        if ("success" in data) {
          iziToast.success({
            title: "Éxito, ",
            message: data.success,
            position: "topCenter",
            displayMode: 1,
          });
          loadTable();
          form[0].reset();
          $("#modal_producto").modal("toggle");
        } else {
          iziToast.error({
            title: "Error, ",
            message: data.error,
            position: "topCenter",
            displayMode: 1,
          });
        }
      },
    });
  }

  form.addClass("was-validated");
});

// Llenar el form producto
$(document).on("click", "button.edit", function () {
  $("#form_producto")[0].reset();
  $("#action").val("edit");
  $("#modal_producto").modal("toggle");
  let id = $(this).attr("id");
  $.post(
    `producto/get`,
    { id },
    function (data, textStatus, jqXHR) {
      if ("producto" in data) {
        $("#id").val(data.producto.id);
        $("#n_serie").val(data.producto.n_serie);
        $("#unidad").val(data.producto.idunidad).trigger("change.select2");
        $("#precio_c").val(data.producto.precio_c);
        $("#precio_v").val(data.producto.precio_v);
        $("#stock").val(data.producto.stock);
        $("#stock_min").val(data.producto.stock_min);
        $("#descripcion").val(data.producto.descripcion);
        $("#destino").val(data.producto.destino);
        $("#urlFoto").val(data.producto.foto);

        // Datos del equipo del cliente
        $("#tipo").val(data.producto.tipo).trigger("change.select2");
        $("#marca").val(data.producto.marca).trigger("change.select2");
        getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
          tipo: data.producto.tipo,
          marca: data.producto.marca,
        });
        setTimeout(() => {
          $("#modelo").val(data.producto.idmodelo).trigger("change.select2");
        }, 100);
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
    `producto/updateStatus`,
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

// Cambiar estado
$(document).on("click", "button.img", function () {
  let foto = $(this).attr("foto");
  console.log(foto);
  $("#modal_img").empty();
  $("#body_img").append(`<img src="${foto}" class='img-fluid'>`);
  $("#modal_img").modal("toggle");
});

// Traer las modelos por marca y tipo
$("#tipo, #marca").change(function () {
  getDataSelect("modelo", "modelo/getAllByMarcaAndTipo", {
    tipo: $("#tipo").val(),
    marca: $("#marca").val(),
  });
});
