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
function reLoadTable() {
  $("#table_reparacion").DataTable().ajax.reload(null, false);
}

function loadTableProductos() {
  $("#table_producto").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: "producto/listProductosLocal",
    },
  });
}

$(document).ready(function () {
  loadTable();
  loadTableProductos();

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
  $(".input_hidden").val("");
  $("#form_reparacion")[0].reset();
  $("#action").val("create");

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
    console.log(url);
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
          reLoadTable();
          $("#card_reparacion").removeClass("show");
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
  $("#card_reparacion").addClass("show");
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
        reLoadTable();
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

// Especificar el costo de la reparación con el precio del servicio
$("#servicio").change(function () {
  $("#costo").val($("option:selected", this).attr("precio"));
});

// Abrir modal para detalle de reparacion
$(document).on("click", "button.terminar", function () {
  let id = $(this).attr("id");

  $("#modal_detalle").modal("toggle");
  $("#id").val(id);
  $("#tbody_detalle").empty();

  $.post(
    "reparacion/getDetalleServicio",
    { id },
    function (data, textStatus, jqXHR) {
      if ("servicios" in data) {
        $("#doc_cliente").val(data.servicios.seriedoc);
        $("#cliente").val(data.servicios.cliente);
        $("#doc_cliente_hide").val(data.servicios.seriedoc);
        $("#cliente_hide").val(data.servicios.cliente);
        // Agregar servicio de la reparacion
        $("#tbody_detalle").append(`
          <tr data-idproducto='${data.servicios.iditem}'>
            <td>${data.servicios.nombre}</td>
            <td><input type=number min=1 value='${data.servicios.precio}' class='form-control form-control-sm precio' readonly></td>      
            <td><input type=number min=1 value='${data.servicios.cantidad}' max=1 class='form-control form-control-sm cantidad' readonly></td>
            <td><input type=number min=1 value='${data.servicios.subtotal}' class='form-control form-control-sm subtotal' readonly></td>
            <td></td>
          </tr>
        `);
        calcTotal();
      }
    },
    "json"
  );
});
// Cambiar boleta a factura
$("#comrpobante").change(function (e) {
  e.preventDefault();
  if ($(this).val() === "B") {
    $("#doc_cliente").val($("#doc_cliente_hide").val());
    $("#cliente").val($("#cliente_hide").val());
  } else {
    $("#doc_cliente").val("");
    $("#cliente").val("");
  }
});

// Agregar detalle
$(document).on("click", "button.producto", function () {
  let id = $(this).data("id");
  let precio = $(this).data("precio");
  let stock = $(this).data("stock");
  let modeloSerie = $(this).data("modeloserie");

  // Buscar si ya existe una fila con el mismo ID
  let existingRow = $("#tbody_detalle").find(`tr[data-idproducto='${id}']`);

  if (existingRow.length > 0) {
    // Si ya existe, aumentar la cantidad y recalcular el subtotal
    let cantidadInput = existingRow.find(".cantidad");
    let cantidad = parseInt(cantidadInput.val()) + 1;

    if (cantidad <= stock) {
      cantidadInput.val(cantidad);

      let precioInput = existingRow.find(".precio");
      let precio = parseInt(precioInput.val());

      let subtotalInput = existingRow.find(".subtotal");
      let subtotal = cantidad * precio;
      subtotalInput.val(subtotal);
    } else {
      iziToast.warning({
        title: "La cantidad excede el stock disponible",
        message: "",
        position: "topCenter",
        displayMode: 1,
      });
    }
  } else {
    $("#tbody_detalle").append(`
      <tr data-idproducto='${id}'>
        <td>${modeloSerie}</td>
        <td><input type=number min=${precio} value='${precio}' class='form-control form-control-sm precio'></td>      
        <td><input type=number min=1 value=1 max=${stock} class='form-control form-control-sm cantidad'></td>
        <td><input type=number min=${precio} value='${precio}' class='form-control form-control-sm subtotal' readonly></td>
        <td><button class='btn btn-sm btn-danger delete_producto'><i class='fas fa-times'></td>
      </tr>
    `);
  }

  calcTotal();
});

// Calcular el subtotal al cambiar el precio
$(document).on("input", ".precio", function () {
  let precio = parseInt($(this).val());
  let cantidad = parseInt($(this).closest("tr").find(".cantidad").val());
  let subtotal = precio * cantidad;

  // Actualizar el valor del subtotal
  $(this).closest("tr").find(".subtotal").val(subtotal);

  calcTotal();
});

// Calcular el subtotal al cambiar la cantidad
$(document).on("input", ".cantidad", function () {
  let stock = $(this).attr("max");
  let cantidad = parseInt($(this).val());
  if (cantidad <= stock) {
    let precio = parseInt($(this).closest("tr").find(".precio").val());
    let subtotal = cantidad * precio;

    // Actualizar el valor del subtotal
    $(this).closest("tr").find(".subtotal").val(subtotal);
  } else {
    iziToast.warning({
      title: "La cantidad excede el stock disponible",
      message: "",
      position: "topCenter",
      displayMode: 1,
    });
    $(this).val(stock);
  }
  calcTotal();
});

// Calcular el subtotal al eliminar un proudcto del resumen
$(document).on("click", ".delete_producto", function () {
  // Actualizar el valor del subtotal
  $(this).closest("tr").remove();
  calcTotal();
});

// Función para calcular y actualizar el total
function calcTotal() {
  let detalle = { id: $("#id").val(), productos: [], total: 0 };

  // Iterar sobre todas las filas de la tabla
  $("#tbody_detalle tr").each(function () {
    let idproducto = $(this).data("idproducto");
    let cantidad = parseInt($(this).find(".cantidad").val());
    let precio = parseFloat($(this).find(".precio").val()) || 0;
    let subtotal = cantidad * precio;
    $(this).find(".subtotal").val(subtotal);

    // Agregar el producto al array de productos en el detalle
    detalle.productos.push({ idproducto, cantidad, precio, subtotal });

    // Sumar el subtotal al total
    detalle.total += subtotal;
  });

  // Actualizar el valor del total
  let igv = detalle.total * 0.18;
  let subtotal = detalle.total - igv;

  $("#total").val(detalle.total.toFixed(2));
  $("#igv").val(igv.toFixed(2));
  $("#subtotal").val(subtotal.toFixed(2));
  $("#detalle_reparacion").val(JSON.stringify(detalle));
}

$("#terminar").click(function (e) {
  e.preventDefault();
  calcTotal();
  const detalle = JSON.parse($("#detalle_reparacion").val());
  $.post(
    "reparacion/terminar",
    {
      data: detalle,
      comprobante: $("#comrpobante").val(),
      descripcion: $("#descripcion").val(),
    },
    function (data, textStatus, jqXHR) {
      if ("success" in data) {
        iziToast.success({
          title: "Éxito, ",
          message: data.success,
          position: "topCenter",
          displayMode: 1,
        });
        $("#modal_detalle").modal("toggle");
        $("#tbody_detalle").empty();
        loadTableProductos();
        reLoadTable();
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
