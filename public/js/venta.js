import { URL_BASE, getCliente } from "./exports.js";

function loadTable() {
  $("#table_venta").DataTable({
    destroy: true,
    ajax: {
      url: "venta/list",
      type: "post",
    },
  });
}

function loadTableProductos() {
  $("#table_producto").DataTable({
    destroy: true,
    ajax: {
      type: "post",
      url: `${URL_BASE}/producto/listProductosLocal`,
      data: { destino: 1 },
    },
  });
}

$(document).ready(function () {
  loadTable();
  loadTableProductos();
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

// Agregar producto al carrito
$(document).on("click", "button.producto", function (e) {
  e.preventDefault();
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
  let productos = [];
  let total = 0;

  // Iterar sobre todas las filas de la tabla
  $("#tbody_detalle tr").each(function () {
    let idproducto = $(this).data("idproducto");
    let cantidad = parseInt($(this).find(".cantidad").val());
    let precio = parseFloat($(this).find(".precio").val()) || 0;
    let subtotal = cantidad * precio;
    $(this).find(".subtotal").val(subtotal);

    // Agregar el producto al array de productos
    productos.push({ idproducto, cantidad, precio, subtotal });

    // Sumar el subtotal al total
    total += subtotal;
  });

  // Actualizar el valor del total
  let igv = total * 0.18;
  let subtotal = total - igv;

  $("#total").val(total.toFixed(2));
  $("#igv").val(igv.toFixed(2));
  $("#subtotal").val(subtotal.toFixed(2));
  $("#detalle_venta").val(JSON.stringify(productos));
}

// Enviar venta
$("#form_venta").submit(function (e) {
  e.preventDefault();
  let form = $(this);
  if (form[0].checkValidity()) {
    let data = form.serialize();
    $.post(
      `${URL_BASE}/venta/save`,
      data,
      function (data, textStatus, jqXHR) {
        if ("success" in data) {
          iziToast.success({
            title: "Éxito, ",
            message: data.success,
            position: "topCenter",
            displayMode: 1,
          });
          setTimeout(() => {
            window.location.href = URL_BASE + "/venta";
          }, 1500);
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
