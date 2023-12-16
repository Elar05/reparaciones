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

  public function existPOST($params)
  {
    foreach ($params as $param) {
      if (!isset($_POST[$param])) {
        return false;
      }
    }
    return true;
  }

  public function existGET($params)
  {
    foreach ($params as $param) {
      if (!isset($_GET[$param])) {
        return false;
      }
    }
    return true;
  }

  public function getGet($name)
  {
    return $_GET[$name];
  }

  public function getPost($name)
  {
    return $_POST[$name];
  }

  public function response($data)
  {
    echo json_encode($data);
    exit();
  }

  public function redirectEncode($url, $mensajes = [])
  {
    $data = [];
    $params = '';

    foreach ($mensajes as $key => $value) {
      $data[] = $key . '=' . $this->encrypt($value);
    }

    $params = join('&', $data);

    if ($params != '') $params = '?' . $params;

    header('Location: ' . URL . "$url$params");
    exit();
  }

  public function encrypt($value)
  {
    return base64_encode($value);
  }

  public function meses()
  {
    return [
      "01" => "Enero",
      "02" => "Febrero",
      "03" => "Marzo",
      "04" => "Abril",
      "05" => "Mayo",
      "06" => "Junio",
      "07" => "Julio",
      "08" => "Agosto",
      "09" => "Septiembre",
      "10" => "Octubre",
      "11" => "Noviembre",
      "12" => "Diciembre",
    ];
  }
}
