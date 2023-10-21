<?php

class Tipo extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('tipo/index');
  }

  public function list()
  {
    $data = [];
    $tipos = $this->model->getAll();

    if (isset($_POST['data'])) $this->response(["data" => $tipos]);

    if (count($tipos) > 0) {
      foreach ($tipos as $tipo) {
        $botones = "<button class='btn btn-warning edit' id='{$tipo["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        // $botones .= "<button class='ml-1 btn btn-danger delete' id='{$tipo["id"]}'><i class='fas fa-times'></i></button>";
        $class = ($tipo["estado"] === "0") ? "success" : "danger";
        $txt = ($tipo["estado"] === "0") ? "Activo" : "Inactivo";

        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer' id='{$tipo["id"]}'>$txt</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' data-id='{$tipo["id"]}' data-estado='{$tipo["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $tipo["id"],
          $tipo["nombre"],
          $estado,
          $botones,
        ];
      }
    }
    $this->response(["data" => $data]);
  }

  public function get()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $tipo = $this->model->get($_POST['id']);
    if ($tipo) {
      $this->response(["tipo" => $tipo]);
    } else {
      $this->response(["error" => "Error al buscar tipo"]);
    }
  }

  public function create()
  {
    if (empty($_POST['nombre'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $tipo = trim($_POST['nombre']);

    // Validar existencia
    if ($this->model->get($tipo, 'nombre')) {
      $this->response(["error" => "tipo ya registrada"]);
    }

    if ($this->model->save($tipo)) {
      $this->response(["success" => "tipo registrado"]);
    } else {
      $this->response(["error" => "Error al registrar tipo"]);
    }
  }

  public function edit()
  {
    if (empty($_POST['id']) || empty($_POST['nombre'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $tipo = trim($_POST['nombre']);

    // Validar existencia
    if ($this->model->get($tipo, 'nombre')) {
      $this->response(["error" => "tipo ya registrada"]);
    }

    if ($this->model->update($tipo, $_POST['id'])) {
      $this->response(["success" => "tipo actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar tipo"]);
    }
  }

  public function updateStatus()
  {
    if (empty($_POST['id']) || !isset($_POST['estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($_POST['estado'] == 0) ? 1 : 0;

    if ($this->model->updateStatus($estado, $_POST['id'])) {
      $this->response(["success" => "Estado actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar estado"]);
    }
  }

  public function delete()
  {
    if (empty($_GET['id'])) {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_DELETE_EMPTY
      ]);
    }

    if ($this->model->delete($_GET['id'])) {
      $this->redirect('equipotipos', [
        "success" => Success::SUCCESS_EQUIPOTIPOS_DELETE
      ]);
    } else {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_DELETE
      ]);
    }
  }
}
