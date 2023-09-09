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

  public function create()
  {
    if (
      empty($_POST['documento']) ||
      empty($_POST['nombres']) ||
      empty($_POST['email']) ||
      empty($_POST['telefono']) ||
      empty($_POST['modelo']) ||
      empty($_POST['n_serie']) ||
      empty($_POST['descripcion']) ||
      empty($_POST['tipo'])
    ) {
      $this->response(["error" => "Faltan parametros"]);
    }

    // Validar existencia del clietne
    $clienteModel = $this->clienteModel();
    $cliente = $clienteModel->get($_POST['documento'], 'documento');
    if (empty($cliente)) {
      $idcliente = $clienteModel->save([
        'documento' => $_POST['documento'],
        'nombres' => $_POST['nombres'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
      ]);
    }

    if ($this->model->save([
      'idcliente' => $cliente['id'] ?? $idcliente,
      'modelo' => $_POST['modelo'],
      'n_serie' => $_POST['n_serie'],
      'descripcion' => $_POST['descripcion'],
      'tipo' => $_POST['tipo'],
    ])) {
      $this->response(["success" => "Equipo registrado"]);
    } else {
      $this->response(["error" => "Error al registrar equipo"]);
    }
  }

  public function clienteModel()
  {
    require_once 'models/clienteModel.php';
    return new ClienteModel();
  }
}
