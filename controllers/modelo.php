<?php

class Modelo extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('modelo/index');
  }

  public function list()
  {
    $data = [];
    $modelos = $this->model->getAll();
    if (count($modelos) > 0) {
      foreach ($modelos as $modelo) {
        $botones = "<button class='btn btn-warning edit' id='{$modelo["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        // $botones .= "<button class='ml-1 btn btn-danger delete' id='{$modelo["id"]}'><i class='fas fa-times'></i></button>";

        $class = "success";
        $txt = "Activo";
        if ($modelo["estado"] === "0") {
          $class = "danger";
          $txt = "Inactivo";
        }

        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer' id='{$modelo["id"]}'>$txt</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' data-id='{$modelo["id"]}' data-estado='{$modelo["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $modelo["id"],
          $modelo["nombre"],
          $modelo["marca"],
          $modelo["tipo"],
          $estado,
          $botones,
        ];
      }
    }

    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (empty($_POST['tipo']) || empty($_POST['marca']) || empty($_POST['nombre'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $modelo = trim($_POST['nombre']);

    // Validar existencia
    if ($this->model->get($modelo, 'nombre')) {
      $this->response(["error" => "modelo ya registrada"]);
    }

    if ($this->model->save([
      'idtipo' => $_POST['tipo'],
      'idmarca' => $_POST['marca'],
      'nombre' => $modelo
    ])) {
      $this->response(["success" => "modelo registrado"]);
    } else {
      $this->response(["error" => "Error al registrar modelo"]);
    }
  }

  public function get()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $modelo = $this->model->get($_POST['id']);
    if ($modelo) {
      $this->response(["modelo" => $modelo]);
    } else {
      $this->response(["error" => "Error al buscar modelo"]);
    }
  }

  public function edit()
  {
    if (
      empty($_POST['id']) || empty($_POST['tipo']) ||
      empty($_POST['marca']) || empty($_POST['nombre'])
    ) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $modelo = trim($_POST['nombre']);

    // Validar existencia
    if ($this->model->get($modelo, 'nombre')) {
      $this->response(["error" => "modelo ya registrada"]);
    }

    if ($this->model->update([
      'idtipo' => $_POST['tipo'],
      'idmarca' => $_POST['marca'],
      'nombre' => $modelo
    ], $_POST['id'])) {
      $this->response(["success" => "modelo actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar modelo"]);
    }
  }

  public function delete()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->delete($_POST['id'])) {
      $this->response(["success" => "modelo eliminado"]);
    } else {
      $this->response(["error" => "Error al eliminar modelo"]);
    }
  }

  public function updateStatus()
  {
    if (empty($_POST['id']) || !isset($_POST['estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($_POST['estado'] == 0) ? 1 : 0;

    if ($this->model->update(["estado" => $estado], $_POST['id'])) {
      $this->response(["success" => "Estado actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar estado"]);
    }
  }

  //* Retorna los modelos filtrados por marca
  public function getAllByMarcaAndTipo()
  {
    if (empty($_POST['tipo']) && empty($_POST['marca'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $modelos = $this->model->getAllByMarcaAndTipo($_POST['tipo'], $_POST['marca']);
    if ($modelos) {
      $this->response(["data" => $modelos]);
    } else {
      $this->response(["error" => "Error al buscar modelos"]);
    }
  }
}
