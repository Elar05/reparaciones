<?php

class Controller
{
  public $model;
  public $view;

  public function __construct($data)
  {
    $this->view = new View($data);
  }

  public function loadModel($name)
  {
    $url = "models/{$name}Model.php";

    if (file_exists($url)) {
      require_once $url;
      $model = "{$name}Model";
      $this->model = new $model();
    }
  }

  public function redirect($url, $mensajes = [])
  {
    $data = [];
    $params = '';

    foreach ($mensajes as $key => $mensaje) {
      $data[] = $key . '=' . $mensaje;
    }
    $params = join('&', $data);

    if ($params !== '') {
      $params = "?$params";
    }

    header('Location: ' . URL . $url . $params);
    exit();
  }

  public function response($data)
  {
    echo json_encode($data);
    exit();
  }
}
