<?php

class Cliente extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function render()
  {
    $this->view->render("cliente/index");
  }

  public function list()
  {
    $data = [];
    $clientes = $this->model->getAll();
    if (count($clientes) > 0) {
      foreach ($clientes as $cliente) {
        $botones = "<button class='btn btn-warning edit' id='{$cliente["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        $botones .= "<button class='btn btn-danger delete' id='{$cliente["id"]}'><i class='fas fa-times'></i></button>";

        $class = "success";
        $text = "Activo";
        if ($cliente["estado"] === '0') {
          $class = "danger";
          $text = "Inactivo";
        }
        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer' style='font-size:12px'>$text</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' id='{$cliente["id"]}' estado='{$cliente["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $cliente["id"],
          $cliente["documento"],
          $cliente["nombres"],
          $cliente["email"],
          $cliente["telefono"],
          $estado,
          $botones
        ];
      }
    }

    echo json_encode(["data" => $data]);
  }
}
