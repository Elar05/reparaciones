<?php

class Permiso extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->redirect("");
  }

  public function get()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $data = [];
    $permisos = $this->model->getAll($_POST['id']);

    if (count($permisos) > 0) {
      foreach ($permisos as $permiso) {
        $data[] = $permiso['idvista'];
      }
    }

    $this->response(["permisos" => $data]);
  }

  public function store()
  {
    if (empty($_POST['vista']) || empty($_POST['tipo'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $permiso = $this->model->get($_POST['vista'], $_POST['tipo']);

    if ($permiso) {
      if ($this->model->delete($_POST['vista'], $_POST['tipo'])) {
        $this->response(["success" => "Permiso eliminado"]);
      } else {
        $this->response(["error" => "Error al eliminar permiso"]);
      }
    } else {
      if ($this->model->save($_POST['vista'], $_POST['tipo'])) {
        $this->response(["success" => "Permiso añadido"]);
      } else {
        $this->response(["error" => "Error al guardar permiso"]);
      }
    }
  }
}
