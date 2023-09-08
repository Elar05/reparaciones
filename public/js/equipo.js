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
});