<?php

class Equipo extends Session
{
  public $documentoModel;

  public function __construct($url)
  {
    parent::__construct($url);

    require_once 'models/documentoModel.php';
    $this->documentoModel = new DocumentoModel;
  }

  public function render()
  {
    $this->view->render('equipo/index', [
      "documentos" => $this->documentoModel->getAll(),
    ]);
  }

  public function list()
  {
    $data = [];
    $equipos = $this->model->getAll();
    if (count($equipos) > 0) {
      foreach ($equipos as $equipo) {
        $botones = "<button class='btn btn-warning edit' id='{$equipo["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        // $botones .= "<button class='btn btn-danger delete' id='{$equipo["id"]}'><i class='fas fa-times'></i></button>";

        $data[] = [
          $equipo["id"],
          $equipo["cliente"],
          $equipo["modelo"],
          $equipo["n_serie"],
          $equipo["marca"],
          $equipo["tipo"],
          $equipo["f_registro"],
          $botones
        ];
      }
    }

    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (
      empty($_POST['iddoc']) || empty($_POST['seriedoc']) ||
      empty($_POST['nombres']) || empty($_POST['telefono']) ||
      empty($_POST['tipo']) || empty($_POST['marca']) ||
      empty($_POST['modelo']) || empty($_POST['n_serie'])
    ) {
      $this->response(["error" => "Faltan parametros"]);
    }

    // Validar existencia del clietne
    $clienteModel = $this->clienteModel();
    $cliente = $clienteModel->get($_POST['seriedoc'], 'seriedoc');
    if (empty($cliente)) {
      $idcliente = $clienteModel->save([
        'iddoc' => $_POST['iddoc'],
        'seriedoc' => $_POST['seriedoc'],
        'nombres' => $_POST['nombres'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
      ]);
    }

    if ($this->model->save([
      'idcliente' => $cliente['id'] ?? $idcliente,
      'idmodelo' => $_POST['modelo'],
      'n_serie' => $_POST['n_serie'],
    ])) {
      $this->response(["success" => "Equipo registrado"]);
    } else {
      $this->response(["error" => "Error al registrar equipo"]);
    }
  }

  public function get()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $equipo = $this->model->get($_POST['id']);
    if (!empty($equipo)) {
      $this->response(["equipo" => $equipo]);
    } else {
      $this->response(["error" => "No se encontro el registro"]);
    }
  }

  public function edit()
  {
    if (empty($_POST['id']) || empty($_POST['modelo']) || empty($_POST['n_serie'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->update([
      'idmodelo' => $_POST['modelo'],
      'n_serie' => $_POST['n_serie'],
    ], $_POST['id'])) {
      $this->response(["success" => "Equipo actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar equipo"]);
    }
  }

  public function delete()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->delete($_POST['id'])) {
      $this->response(["success" => "equipo eliminado"]);
    } else {
      $this->response(["error" => "Error al eliminar equipo"]);
    }
  }

  public function clienteModel()
  {
    require_once 'models/clienteModel.php';
    return new ClienteModel();
  }

  public function getEquiposByCliente()
  {
    if (empty($_POST['seriedoc'])) $this->response(["error" => "Faltan parametros"]);

    $equipos = $this->model->getAllByCliente($_POST['seriedoc']);

    $this->response(["equipos" => $equipos]);
  }
}
