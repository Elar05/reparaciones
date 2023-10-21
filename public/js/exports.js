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

export function changeMaxDoc() {
  $("#seriedoc").val("").focus();
  if ($("#iddoc").val() == 1) {
    $("#seriedoc").attr("maxlength", 8);
  } else {
    $("#seriedoc").attr("maxlength", 11);
  }
}

export function getDataSelect(select, url = "", data = "") {
  $(`#${select}`).empty();
  $(`#${select}`).append(
    `<option value="" selected disabled>__ Seleccione __</option>`
  );

  if (url != "" && data != "") {
    $.ajax({
      type: "post",
      url,
      data,
      dataType: "json",
      success: function (response) {
        if ("data" in response) {
          response.data.forEach((item) => {
            $(`#${select}`).append(
              `<option value="${item.id}">${item.nombre}</option>`
            );
          });
        }
      },
      error: function (error) {
        console.error("Error en la solicitud AJAX: " + error);
      },
    });
  }
}

export function saveTipoOrMarcaOrModelo(url, data) {
  $.ajax({
    type: "post",
    url,
    data,
    dataType: "json",
    success: function (response) {
      if ("success" in response) {
        iziToast.success({
          title: "Éxito, ",
          message: response.success,
          position: "topCenter",
          displayMode: 1,
        });
      } else {
        iziToast.error({
          title: "Error, ",
          message: response.error,
          position: "topCenter",
          displayMode: 1,
        });
      }
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX: " + error);
    },
  });
}