<?php

class Usuario extends Session
{
  public $model;
  public $view;

  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('usuario/index', [
      "tipos" => $this->getTipos()
    ]);
  }

  public function list()
  {
    $data = [];
    $usuarios = $this->model->getAll();
    if (count($usuarios) > 0) {
      foreach ($usuarios as $usuario) {
        if ($usuario['idtipo_usuario'] === 1) continue;

        $botones = "<button class='btn btn-warning edit' id='{$usuario["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        $botones .= "<button class='btn btn-danger delete' id='{$usuario["id"]}'><i class='fas fa-times'></i></button>";

        $class = "success";
        $text = "Activo";
        if ($usuario["estado"] === '0') {
          $class = "danger";
          $text = "Inactivo";
        }
        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer' style='font-size:12px'>$text</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' id='{$usuario["id"]}' estado='{$usuario["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $usuario["id"],
          $usuario["nombres"],
          $usuario["email"],
          $usuario["telefono"],
          $usuario["direccion"],
          $usuario["tipo"],
          $estado,
          $botones
        ];
      }
    }

    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (empty($_POST['tipo']) || empty($_POST['nombres']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->save([
      "tipo" => $_POST['tipo'],
      "nombres" => $_POST['nombres'],
      "email" => $_POST['email'],
      "password" => password_hash($_POST['password'], PASSWORD_DEFAULT, ["cost" => 10]),
      "telefono" => $_POST['telefono'],
      "direccion" => $_POST['direccion'],
    ])) {
      $this->response(["success" => "Usuario creado"]);
    } else {
      $this->response(["error" => "Error al crear usuario"]);
    }
  }

  public function get()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $usuario = $this->model->get($_POST["id"]);
    if ($usuario) {
      unset($usuario["password"]);

      $this->response(["usuario" => $usuario]);
    } else {
      $this->response(["error" => "Usuario no encontrado"]);
    }
  }

  public function edit()
  {
    if (empty($_POST['id']) || empty($_POST['tipo']) || empty($_POST['nombres']) || empty($_POST['email']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->update([
      "idtipo_usuario" => $_POST['tipo'],
      "nombres" => $_POST['nombres'],
      "email" => $_POST['email'],
      "telefono" => $_POST['telefono'],
      "direccion" => $_POST['direccion'],
    ], $_POST['id'])) {
      if (!empty($_POST["password"]))
        $this->model->update(
          ["password" => password_hash($_POST['password'], PASSWORD_DEFAULT, ["cost" => 10])],
          $_POST["id"]
        );
      $this->response(["success" => "Usuario actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar usuario"]);
    }
  }

  public function delete()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->delete($_POST["id"])) {
      $this->response(["success" => "Usuario eliminado"]);
    } else {
      $this->response(["error" => "No se puedo eliminar usuario"]);
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

  public function getTipos()
  {
    require_once 'models/usuarioTiposModel.php';
    $tipos = new UsuarioTiposModel();
    return $tipos->getAll();
  }
}
