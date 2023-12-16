<?php

class Main extends Session
{
  public $year;

  public function __construct($url)
  {
    parent::__construct($url);
    $this->year = date("Y");
  }

  public function render()
  {
    $this->view->render('main/index');
  }

  public function reparacionModel()
  {
    require_once 'models/reparacionModel.php';
    return new ReparacionModel;
  }

  public function getIngresosByMonth()
  {
    $repracion = $this->reparacionModel();
    $totales = $repracion->getIngresosByMonth($this->year);
    $categories = [];
    $data = [];

    foreach ($totales as $total) {
      $data[] = intval($total['total_por_mes']);
      $categories[] = $this->meses()[$total['mes']];
    }

    $series = [[
      "name" => "Total de ingresos",
      "data" => $data,
    ]];
    $this->response(["series" => $series, "categories" => $categories]);
  }

  public function getIngresosByMonthAndUser()
  {
    $reparacionModel = $this->reparacionModel();
    $totales = $reparacionModel->getIngresosByMonthAndUser($this->year);
    $meses = [];
    $data = [];

    foreach ($totales as $total) {
      $idUsuario = $total['idusuario'];
      $totalPorMes = floatval($total['total_por_mes']);

      if (!isset($data[$idUsuario])) {
        $data[$idUsuario] = [
          'nombres' => $total['nombres'],
          'total' => [],
        ];
      }

      if (!in_array($this->meses()[$total['mes']], $meses)) {
        $meses[] = $this->meses()[$total['mes']];
      }

      $data[$idUsuario]['total'][] = $totalPorMes;
    }

    $series = [];
    foreach ($data as $item) {
      $series[] = ["name" => $item['nombres'], "data" => $item['total']];
    }

    $this->response(["series" => $series, "categories" => $meses]);
  }

  public function getRepairsByMonth()
  {
    $reparacionModel = $this->reparacionModel();
    $totales = $reparacionModel->getRepairsByMonth($this->year);
    $meses = [];
    $data = [];

    foreach ($totales as $total) {
      $data[] = intval($total['total']);
      $meses[] = $this->meses()[$total['mes']];
    }

    $series = [[
      "name" => "Total de reparaciones por mes",
      "data" => $data
    ]];
    $this->response(["series" => $series, "categories" => $meses]);
  }

  public function getRepairsByMonthAndUser()
  {
    $reparacionModel = $this->reparacionModel();
    $totales = $reparacionModel->getRepairsByMonthAndUser($this->year);
    $meses = [];
    $data = [];

    foreach ($totales as $total) {
      $idUsuario = $total['idusuario'];
      $totalPorMes = floatval($total['total']);

      if (!isset($data[$idUsuario])) {
        $data[$idUsuario] = [
          'nombres' => $total['nombres'],
          'total' => [],
        ];
      }

      if (!in_array($this->meses()[$total['mes']], $meses)) {
        $meses[] = $this->meses()[$total['mes']];
      }

      $data[$idUsuario]['total'][] = $totalPorMes;
    }

    $series = [];
    foreach ($data as $item) {
      $series[] = ["name" => $item['nombres'], "data" => $item['total']];
    }

    $this->response(["series" => $series, "categories" => $meses]);
  }
}
