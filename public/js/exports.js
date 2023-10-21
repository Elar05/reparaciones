export function getCliente(data, callback) {
  $.ajax({
    type: "post",
    url: "cliente/get",
    data,
    dataType: "json",
    success: function (response) {
      callback(response);
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX: " + error);
    },
  });
}