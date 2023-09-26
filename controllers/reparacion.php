<?php

class Reparacion extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render("reparacion/index", [
      "usuarios" => $this->getUsuarios(),
      "tipos" => $this->getTipos()
    ]);
  }

  public function list()
  {
    $column = null;
    $value = null;

    if ($this->userType === 3) {
      $column = "r.idusuario";
      $value = $this->userId;
    }

    $data = [];
    $reparaciones = $this->model->getAll($column, $value);
    if (count($reparaciones) > 0) {
      foreach ($reparaciones as $reparacion) {
        $botones = "<button class='btn btn-warning edit' id='{$reparacion["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        $botones .= "<button class='btn btn-danger delete' id='{$reparacion["id"]}'><i class='fas fa-times'></i></button>";

        $arrEstado = [
          "0" => ["class" => "info", "text" => "En espera"],
          "1" => ["class" => "warning", "text" => "En proceso"],
          "2" => ["class" => "success", "text" => "Terminado"],
        ];
        $estado = $reparacion["estado"];
        $class = $arrEstado[$estado]["class"];
        $txt = $arrEstado[$estado]["text"];

        $estado = "<span class='badge badge-$class text-uppercase mr-2'>$txt</span>";
        $estado .= "<div class='btn-group dropleft'>
          <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class='fas fa-cogs'></i>
          </button>
          <div class='dropdown-menu dropleft'>
            <button class='dropdown-item estado' id='{$reparacion["id"]}' estado='0'><i class='fas fa-pause text-info'></i> En espera</button>
            <button class='dropdown-item estado' id='{$reparacion["id"]}' estado='1'><i class='fas fa-spinner text-warning'></i> En proceso</button>
            <button class='dropdown-item estado' id='{$reparacion["id"]}' estado='2'><i class='fas fa-check text-success'></i> Terminado</button>
          </div>
        </div>";

        $data[] = [
          $reparacion["id"],
          $reparacion["usuario"],
          $reparacion["cliente"],
          $reparacion["modelo"] . " - " . $reparacion["n_serie"],
          $reparacion["costo"],
          $reparacion["f_inicio"],
          $reparacion["f_fin"],
          $estado,
          $botones
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

    $reparacion = $this->model->get($_POST['id']);
    if ($reparacion) {
      $this->response(["reparacion" => $reparacion]);
    } else {
      $this->response(["error" => "Error al buscar info"]);
    }
  }

  public function create()
  {
    if (
      empty($_POST['documento']) || empty($_POST['nombres']) ||
      empty($_POST['email']) || empty($_POST['telefono']) ||
      empty($_POST['modelo']) || empty($_POST['n_serie']) ||
      empty($_POST['descripcion']) || empty($_POST['tipo']) ||
      empty($_POST['detalle']) || empty($_POST['costo']) ||
      empty($_POST['usuario'])
    ) {
      $this->response(["error" => "Faltan parametros"]);
    }

    // Validar existencia del clietne
    $clienteModel = $this->clienteModel();
    $cliente = $clienteModel->get($_POST['documento'], 'documento');
    if (empty($cliente)) {
      $idc = $clienteModel->save([
        'documento' => $_POST['documento'],
        'nombres' => $_POST['nombres'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
      ]);
    }
    $idcliente = $idc ?? $cliente['id'];

    // Validar existencia del clietne
    $equipoModel = $this->equipoModel();
    if (empty($_POST['idequipo'])) {
      $ide = $equipoModel->save([
        'idcliente' => $idcliente,
        'modelo' => $_POST['modelo'],
        'n_serie' => $_POST['n_serie'],
        'descripcion' => $_POST['descripcion'],
        'tipo' => $_POST['tipo'],
      ]);
    } else {
      $equipo = $equipoModel->get($_POST['idequipo']);
      if (empty($equipo)) {
        $this->response(["error" => "Equipo no valido"]);
      }
    }
    $idequipo = $ide ?? $equipo['id'];

    if ($this->model->save([
      "idequipo" => $idequipo,
      "detalle" => $_POST['detalle'],
      "costo" => $_POST['costo'],
      "idusuario" => $_POST['usuario'],
    ])) {
      $this->response(["success" => "Reparación registrada"]);
    } else {
      $this->response(["error" => "Error al registrar repación"]);
    }
  }

  public function edit()
  {
    if (
      empty($_POST['id']) || empty($_POST['detalle']) ||
      empty($_POST['costo']) || empty($_POST['usuario'])
    ) {
      $this->response(['error' => "Faltan parametros"]);
    }

    if ($this->model->update([
      'detalle' => $_POST['detalle'],
      'costo' => $_POST['costo'],
      'idusuario' => $_POST['usuario']
    ], $_POST['id'])) {
      $this->response(["success" => "Edición con éxito"]);
    } else {
      $this->response(["error" => "Error al editar reparación"]);
    }
  }

  public function delete()
  {
    if (empty($_POST['id'])) {
      $this->response(['error' => "Faltan parametros"]);
    }

    if ($this->model->delete($_POST['id'])) {
      $this->response(['success' => "Eliminado"]);
    } else {
      $this->response(['error' => "Error al eliminar"]);
    }
  }

  public function updateStatus()
  {
    if (
      !isset($_POST['id']) || empty($_POST['id']) ||
      !isset($_POST['estado']) || $_POST['id'] == ""
    ) {
      $this->response(['error' => "Faltan parametros"]);
    }

    if ($this->model->update([
      "estado" => $_POST["estado"],
      "f_fin" => date("Y-m-d H:i:s")
    ], $_POST["id"])) {
      $this->response(["success" => "Estado actualizado"]);
    } else {
      $this->response(['error' => "Error al actualizar estado"]);
    }
  }

  // obtener los tipos de equipos
  public function getTipos()
  {
    require_once 'models/equipoTiposModel.php';
    $tipos = new EquipoTiposModel();
    return $tipos->getAll();
  }

  // obtener usuarios técnicos
  public function getUsuarios()
  {
    require_once 'models/usuarioModel.php';
    $usuarios = new UsuarioModel();
    return $usuarios->getAll("ut.tipo", "Técnico");
  }

  public function clienteModel()
  {
    require_once 'models/clienteModel.php';
    return new ClienteModel();
  }

  public function equipoModel()
  {
    require_once 'models/equipoModel.php';
    return new EquipoModel();
  }
}
