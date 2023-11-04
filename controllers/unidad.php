<?php

class Unidad extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('unidad/index');
  }

  public function list()
  {
    $data = [];
    $unidads = $this->model->getAll();

    if (isset($_POST['data'])) $this->response(["data" => $unidads]);

    if (count($unidads) > 0) {
      foreach ($unidads as $unidad) {
        $botones = "<button class='btn btn-warning edit' id='{$unidad["id"]}'><i class='fas fa-pencil-alt'></i></button>";

        $class = ($unidad["estado"] === "1") ? "success" : "danger";
        $txt = ($unidad["estado"] === "1") ? "Activo" : "Inactivo";

        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer'>$txt</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' data-id='{$unidad["id"]}' data-estado='{$unidad["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $unidad["id"],
          $unidad["codigo"],
          $unidad["nombre"],
          $estado,
          $botones,
        ];
      }
    }
    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (!$this->existPOST(['codigo', 'nombre'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $this->model->codigo = $this->getPost('codigo');
    $this->model->nombre = $this->getPost('nombre');

    if ($this->model->exists()) {
      $this->response(["error" => "Ya existe la unidad"]);
    }

    if ($this->model->save()) {
      $this->response(["success" => "unidad registrada"]);
    }
    $this->response(["error" => "Error al registrar unidad"]);
  }

  public function get()
  {
    if (!$this->existPOST(['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($unidad = $this->model->get($this->getPost('id'))) {
      $this->response(["unidad" => $unidad]);
    }

    $this->response(["error" => "Error al buscar unidad"]);
  }

  public function edit()
  {
    if (!$this->existPOST(['id', 'nombre', 'codigo'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $this->model->id = $this->getPost('id');
    $this->model->codigo = $this->getPost('codigo');
    $this->model->nombre = $this->getPost('nombre');

    // Validamos existencia
    if ($this->model->exists()) {
      $this->response(["error" => "Ya existe la unidad"]);
    }

    // Actualizar
    if ($this->model->update()) {
      $this->response(["success" => "Unidad actualizada"]);
    }

    $this->response(["error" => "Error al registrar unidad"]);
  }

  public function updateStatus()
  {
    if (!$this->existPOST(['id', 'estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($this->getPost('estado') == 0) ? 1 : 0;

    $this->model->id = $this->getPost('id');
    $this->model->estado = $estado;

    if ($this->model->updateStatus()) {
      $this->response(["success" => "Estado actualizado"]);
    }

    $this->response(["error" => "Error al actualizar estado"]);
  }
}
