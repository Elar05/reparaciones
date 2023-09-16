<?php

class Cliente extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
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

  public function create()
  {
    if (empty($_POST['documento']) || empty($_POST['nombres']) || empty($_POST['email']) || empty($_POST['telefono'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    // Validar que existencia
    if ($this->model->get($_POST['documento'], "documento")) {
      $this->response(["error" => "Documento ya registrado"]);
    }

    if ($this->model->save([
      "documento" => $_POST['documento'],
      "nombres" => $_POST['nombres'],
      "email" => $_POST['email'],
      "telefono" => $_POST['telefono'],
    ])) {
      $this->response(["success" => "Cliente creado"]);
    } else {
      $this->response(["error" => "Error al crear Cliente"]);
    }
  }

  public function get()
  {
    if (empty($_POST['value'])) {
      $this->response(["error" => "El documento esta vacio"]);
    }

    $cliente = $this->model->get($_POST['value'], $_POST['column'] ?? "id");
    if (!empty($cliente)) {
      $this->response(["success" => "Cliente encontrado", "cliente" => $cliente]);
    } else {
      $this->response(["error" => "Cliente no encontrado"]);
    }
  }

  public function edit()
  {
    if (empty($_POST['id']) || empty($_POST['documento']) || empty($_POST['nombres']) || empty($_POST['email']) || empty($_POST['telefono'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->update([
      "documento" => $_POST['documento'],
      "nombres" => $_POST['nombres'],
      "email" => $_POST['email'],
      "telefono" => $_POST['telefono'],
    ], $_POST['id'])) {
      $this->response(["success" => "Cliente Actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar Cliente"]);
    }
  }

  public function delete()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->delete($_POST["id"])) {
      $this->response(["success" => "Cliente eliminado"]);
    } else {
      $this->response(["error" => "No se puedo eliminar Cliente"]);
    }
  }

  public function updateStatus()
  {
    if (empty($_POST['id']) || !isset($_POST['estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($_POST['estado'] == 1) ? 0 : 1;

    if ($this->model->update(["estado" => $estado], $_POST["id"])) {
      $this->response(["success" => "Estado actualizado"]);
    } else {
      $this->response(["error" => "No se puedo actualizar estado"]);
    }
  }
}
