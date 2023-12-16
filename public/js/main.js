"use strict";
$(function () {
  chart1();
  chart2();
  chart3();
  chart4();

  chart5();
  chart6();
  chart7();
});

function chart1() {
  $.post(
    "main/getIngresosByMonth",
    {},
    function (data, textStatus, jqXHR) {
      const { series, categories } = data;
      var options = {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "50%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        series,
        xaxis: {
          categories,
          labels: {
            style: {
              colors: "#000",
            },
          },
        },
        yaxis: {
          title: {
            text: "$ (thousands)",
          },
          labels: {
            style: {
              color: "#000",
            },
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands";
            },
          },
        },
      };

      var chart = new ApexCharts(document.querySelector("#chart1"), options);
      chart.render();
    },
    "json"
  );
}
function chart2() {
  $.post(
    "main/getIngresosByMonthAndUser",
    {},
    function (data, textStatus, jqXHR) {
      const { series, categories } = data;
      var options = {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "55%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        series,
        xaxis: {
          categories,
          labels: {
            style: {
              colors: "#9aa0ac",
            },
          },
        },
        yaxis: {
          title: {
            text: "$ (thousands)",
          },
          labels: {
            style: {
              color: "#9aa0ac",
            },
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands";
            },
          },
        },
      };

      var chart = new ApexCharts(document.querySelector("#chart2"), options);
      chart.render();
    },
    "json"
  );
}
function chart3() {
  $.post(
    "main/getRepairsByMonth",
    {},
    function (data, textStatus, jqXHR) {
      const { series, categories } = data;
      var options = {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "55%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        series,
        xaxis: {
          categories,
          labels: {
            style: {
              colors: "#9aa0ac",
            },
          },
        },
        yaxis: {
          title: {
            text: "# (Cantidad)",
          },
          labels: {
            style: {
              color: "#9aa0ac",
            },
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " repraciones";
            },
          },
        },
      };

      var chart = new ApexCharts(document.querySelector("#chart3"), options);
      chart.render();
    },
    "json"
  );
}
function chart4() {
  $.post(
    "main/getRepairsByMonthAndUser",
    {},
    function (data, textStatus, jqXHR) {
      const { series, categories } = data;
      var options = {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "55%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        series,
        xaxis: {
          categories,
          labels: {
            style: {
              colors: "#9aa0ac",
            },
          },
        },
        yaxis: {
          title: {
            text: "$ (thousands)",
          },
          labels: {
            style: {
              color: "#9aa0ac",
            },
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands";
            },
          },
        },
      };

      var chart = new ApexCharts(document.querySelector("#chart4"), options);
      chart.render();
    },
    "json"
  );
}

function chart5() {
  var options = {
    chart: {
      width: 400,
      type: "pie",
    },
    labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
    series: [44, 55, 13, 43, 22],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  };

  var chart = new ApexCharts(document.querySelector("#chart5"), options);
  chart.render();
}
function chart6() {
  var options = {
    chart: {
      width: 360,
      type: "pie",
    },
    labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
    series: [44, 55, 13, 43, 22],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  };

  var chart = new ApexCharts(document.querySelector("#chart6"), options);

  chart.render();
}
function chart7() {
  var options = {
    chart: {
      width: 360,
      type: "pie",
    },
    labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
    series: [44, 55, 13, 43, 22],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  };

  var chart = new ApexCharts(document.querySelector("#chart7"), options);

  chart.render();
}
