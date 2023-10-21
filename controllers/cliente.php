<?php

class Cliente extends Session
{
  public $documentoModel;

  public function __construct($url)
  {
    parent::__construct($url);

    require_once 'models/documentoModel.php';
    $this->documentoModel = new DocumentoModel;
  }

  public function render()
  {
    $this->view->render("cliente/index", [
      "documentos" => $this->documentoModel->getAll()
    ]);
  }

  public function list()
  {
    $search = $_POST['search']['value'] ?? null;
    $start = $_POST['start'] ?? 0;
    $length = $_POST['length'] ?? 10;

    $data = [];
    $dataClientes = $this->model->getAll($start, $length, $search, null, null);

    $clientes = $dataClientes['clientes'];
    if (count($clientes) > 0) {
      foreach ($clientes as $cliente) {
        $botones = "";
        if ($this->userType != 3) {
          $botones = "<button class='btn btn-warning edit' id='{$cliente["id"]}'><i class='fas fa-pencil-alt'></i></button>";
          // $botones .= "<button class='btn btn-danger delete' id='{$cliente["id"]}'><i class='fas fa-times'></i></button>";
        }

        $status = explode("-", $cliente['status']);
        $text = $status[0];
        $class = $status[1];
        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer' style='font-size:12px'>$text</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' id='{$cliente["id"]}' estado='{$cliente["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $cliente["id"],
          $cliente["seriedoc"],
          $cliente["nombres"],
          $cliente["email"],
          $cliente["telefono"],
          $estado,
          $botones
        ];
      }
    }

    $recordsTotal = $dataClientes['total'];

    $this->response([
      "draw" => $_POST['draw'],
      "recordsTotal" => $recordsTotal,
      "recordsFiltered" => $recordsTotal,
      "data" => $data
    ]);
  }

  public function create()
  {
    if (
      empty($_POST['iddoc']) || empty($_POST['seriedoc']) ||
      empty($_POST['nombres']) || empty($_POST['telefono'])
    ) {
      $this->response(["error" => "Faltan parametros"]);
    }

    // Validar que existencia
    if ($this->model->get($_POST['seriedoc'], 'seriedoc')) {
      $this->response(["error" => "Documento ya registrado"]);
    }

    if ($this->model->save([
      'iddoc' => $_POST['iddoc'],
      'seriedoc' => $_POST['seriedoc'],
      "nombres" => $_POST['nombres'],
      "email" => $_POST['email'],
      "telefono" => $_POST['telefono'],
      "direccion" => $_POST['direccion'],
    ])) {
      $this->response(["success" => "Cliente creado"]);
    } else {
      $this->response(["error" => "Error al crear Cliente"]);
    }
  }

  public function get()
  {
    if (empty($_POST['value'])) {
      $this->response(["error" => "El documento esta vacio"]);
    }

    $cliente = $this->model->get($_POST['value'], $_POST['column'] ?? "id");
    if (!empty($cliente)) {
      $this->response(["success" => "Cliente encontrado", "cliente" => $cliente]);
    } else {
      $this->response(["error" => "Cliente no encontrado"]);
    }
  }

  public function edit()
  {
    if (
      empty($_POST['id']) || empty($_POST['iddoc']) || empty($_POST['seriedoc']) ||
      empty($_POST['nombres']) || empty($_POST['telefono'])
    ) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->update([
      'iddoc' => $_POST['iddoc'],
      'seriedoc' => $_POST['seriedoc'],
      "nombres" => $_POST['nombres'],
      "email" => $_POST['email'],
      "telefono" => $_POST['telefono'],
      "direccion" => $_POST['direccion'],
    ], $_POST['id'])) {
      $this->response(["success" => "Cliente Actualizado"]);
    } else {
      $this->response(["error" => "Error al actualizar Cliente"]);
    }
  }

  public function delete()
  {
    if (empty($_POST['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($this->model->delete($_POST["id"])) {
      $this->response(["success" => "Cliente eliminado"]);
    } else {
      $this->response(["error" => "No se puedo eliminar Cliente"]);
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
}
