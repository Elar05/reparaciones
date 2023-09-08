<?php

class Equipo extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function render()
  {
    $this->view->render('equipo/index');
  }

  public function list()
  {
    $data = [];
    $equipos = $this->model->getAll();
    if (count($equipos) > 0) {
      foreach ($equipos as $equipo) {
        $botones = "<button class='btn btn-warning edit' id='{$equipo["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        $botones .= "<button class='btn btn-danger delete' id='{$equipo["id"]}'><i class='fas fa-times'></i></button>";

        $data[] = [
          $equipo["id"],
          $equipo["cliente"],
          $equipo["modelo"],
          $equipo["n_serie"],
          $equipo["idtipo_equipo"],
          $equipo["descripcion"],
          $botones
        ];
      }
    }

    $this->response(["data" => $data]);
  }
}
