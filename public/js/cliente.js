// Loadtable
function loadTable() {
  $("#table_cliente").DataTable({
    destroy: true,
    ajax: {
      type: "POST",
      url: "cliente/list",
    },
    order: [[0, "desc"]],
  });
}
$(document).ready(function () {
  loadTable();
});
