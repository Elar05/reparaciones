// Mostrar los permisos / vistas
$(document).on("click", "button.permisos", function () {
  $(".vista").prop("checked", false);
  let id = $(this).data("id");
  $("#tipo").val(id);
  $.post(
    "permiso/get",
    { id },
    function (data, textStatus, jqXHR) {
      if ("permisos" in data) {
        const { permisos } = data;
        if (permisos.length > 0) {
          let vistas = $(".vista");
          for (let i = 0; i < permisos.length; i++) {
            const checboxValue = Number(vistas[i].value);
            if (permisos.includes(checboxValue)) {
              vistas[i].checked = true;
            }
          }
        }
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

$(document).on("click", "input.vista", function () {
  let vista = $(this).val(),
    tipo = $("#tipo").val();

  $.post(
    "permiso/store",
    { vista, tipo },
    function (data, textStatus, jqXHR) {
      if ("success" in data) {
        iziToast.success({
          title: "Éxito, ",
          message: data.success,
          position: "topCenter",
          displayMode: 2,
        });
      } else {
        iziToast.error({
          title: "Error, ",
          message: data.error,
          position: "topCenter",
          displayMode: 2,
        });
      }
    },
    "json"
  );
});
