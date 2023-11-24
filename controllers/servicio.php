<?php

class Servicio extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('servicio/index');
  }

  public function list()
  {
    $data = [];
    $this->model = new ServicioModel();
    $servicios = $this->model->getAll();

    if (count($servicios) > 0) {
      foreach ($servicios as $servicio) {
        $botones = "<button class='btn btn-warning edit' id='{$servicio["id"]}'><i class='fas fa-pencil-alt'></i></button>";

        $class = ($servicio["estado"] === "1") ? "success" : "danger";
        $txt = ($servicio["estado"] === "1") ? "Activo" : "Inactivo";

        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer'>$txt</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' data-id='{$servicio["id"]}' data-estado='{$servicio["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $servicio["id"],
          $servicio["nombre"],
          $servicio["precio"],
          $estado,
          $botones,
        ];
      }
    }
    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (!$this->existPOST(['nombre', 'precio'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->get($this->getPost('nombre'), "nombre")) {
      $this->response(["error" => "Ya existe la servicio"]);
    }

    $this->model = new ServicioModel;
    $this->model->nombre = $this->getPost('nombre');
    $this->model->precio = $this->getPost('precio');

    if ($this->model->save()) {
      $this->response(["success" => "servicio registrado"]);
    }

    $this->response(["error" => "Error al registrar servicio"]);
  }

  public function get()
  {
    if (!$this->existPOST(['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($servicio = $this->model->get($this->getPost('id'))) {
      $this->response(["servicio" => $servicio]);
    }

    $this->response(["error" => "Error al buscar servicio"]);
  }

  public function edit()
  {
    if (!$this->existPOST(['id', 'nombre', 'precio'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->get($this->getPost('nombre'), "nombre")) {
      $this->response(["error" => "Ya existe la servicio"]);
    }

    $this->model = new ServicioModel;
    $this->model->id = $this->getPost('id');
    $this->model->nombre = $this->getPost('nombre');
    $this->model->precio = $this->getPost('precio');

    // Actualizar
    if ($this->model->update()) {
      $this->response(["success" => "servicio actualizada"]);
    }

    $this->response(["error" => "Error al registrar servicio"]);
  }

  public function updateStatus()
  {
    if (!$this->existPOST(['id', 'estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($this->getPost('estado') == 0) ? 1 : 0;

    $this->model = new ServicioModel;
    $this->model->id = $this->getPost('id');
    $this->model->estado = $estado;

    if ($this->model->updateStatus()) {
      $this->response(["success" => "Estado actualizado"]);
    }

    $this->response(["error" => "Error al actualizar estado"]);
  }
}
