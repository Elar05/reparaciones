<?php

class Marca extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('marca/index');
  }

  public function list()
  {
    $data = [];
    $marcas = $this->model->getAll();

    if (isset($_POST['data'])) $this->response(["data" => $marcas]);

    if (count($marcas) > 0) {
      foreach ($marcas as $marca) {
        $botones = "<button class='btn btn-warning edit' id='{$marca["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        // $botones .= "<button class='ml-1 btn btn-danger delete' id='{$marca["id"]}'><i class='fas fa-times'></i></button>";

        $class = ($marca["estado"] === "1") ? "success" : "danger";
        $txt = ($marca["estado"] === "1") ? "Activo" : "Inactivo";

        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer'>$txt</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' data-id='{$marca["id"]}' data-estado='{$marca["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $marca["id"],
          $marca["nombre"],
          $estado,
          $botones,
        ];
      }
    }

    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (empty($_POST['nombre'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $marca = trim($_POST['nombre']);

    // Validar existencia
    if ($this->model->get($marca, 'nombre')) {
      $this->response(["error" => "Marca ya registrada"]);
    }

    if ($this->model->save($marca)) {
      $this->response(["success" => "marca registrado"]);
    } else {
      $this->response(["error" => "Error al registrar marca"]);
    }
  }

  public function get()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $marca = $this->model->get($_POST['id']);
    if ($marca) {
      $this->response(["marca" => $marca]);
    } else {
      $this->response(["error" => "Error al buscar marca"]);
    }
  }

  public function edit()
  {
    if (empty($_POST['id']) || empty($_POST['nombre'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $marca = trim($_POST['nombre']);

    // Validar existencia
    if ($this->model->get($marca, 'nombre')) {
      $this->response(["error" => "Marca ya registrada"]);
    }

    if ($this->model->update("nombre", $marca, $_POST['id'])) {
      $this->response(["success" => "marca actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar marca"]);
    }
  }

  public function updateStatus()
  {
    if (empty($_POST['id']) || !isset($_POST['estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($_POST['estado'] == 0) ? 1 : 0;

    if ($this->model->update("estado", $estado, $_POST['id'])) {
      $this->response(["success" => "Estado actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar estado"]);
    }
  }
}
