<?php

class Reparacion extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    require_once 'models/documentoModel.php';
    require_once 'models/servicioModel.php';

    $documentos = new DocumentoModel();
    $servicios = new ServicioModel();

    $this->view->render("reparacion/index", [
      "usuarios" => $this->getUsuarios(),
      "tipos" => $this->getTipos(),
      "documentos" => $documentos->getAll(),
      "servicios" => $servicios->getAll()
    ]);
  }

  public function list()
  {
    $search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
    $start = $_POST['start'] ?? 0;
    $length = $_POST['length'] ?? 10;

    $fechaInicio = $_POST['fechaInicio'] ?? null;
    $fechaFin = $_POST['fechaFin'] ?? null;

    $column = null;
    $value = null;
    if ($this->userType === 3) {
      $column = "r.idusuario";
      $value = $this->userId;
    }

    $filtros = [
      "start" => $start,
      "length" => $length,
      "search" => $search,
      "column" => $column,
      "value" => $value,
      "fechaInicio" => $fechaInicio,
      "fechaFin" => $fechaFin,
    ];

    $data = [];
    $dataReparaciones = $this->model->getAll($filtros);

    $reparaciones = $dataReparaciones['reparaciones'];
    if (count($reparaciones) > 0) {
      foreach ($reparaciones as $reparacion) {
        $botones = "";
        if ($reparacion['estado'] < 2) {
          $botones = "<button class='btn btn-warning edit' id='{$reparacion["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        }

        $arrEstado = [
          "0" => [
            "class" => "info", "text" => "En espera",
            "acciones" => "
              <button class='dropdown-item estado' id='{$reparacion["id"]}' estado='1'><i class='fas fa-spinner text-warning'></i> En proceso</button>
              <button class='dropdown-item estado' id='{$reparacion["id"]}' estado='3'><i class='fas fa-times text-danger'></i> Cancelar</button>
            "
          ],
          "1" => [
            "class" => "warning", "text" => "En proceso",
            "acciones" => "
              <button class='dropdown-item terminar' id='{$reparacion["id"]}'><i class='fas fa-check text-success'></i> Terminado</button>
              <button class='dropdown-item estado' id='{$reparacion["id"]}' estado='3'><i class='fas fa-times text-danger'></i> Cancelar</button>
            "
          ],
          "2" => ["class" => "success", "text" => "Terminado", "acciones" => "<button class='dropdown-item informacion' id='{$reparacion["id"]}'><i class='fas fa-info text-info'></i> Información</button>"],
          "3" => ["class" => "danger", "text" => "Cancelado", "acciones" => ""],
        ];
        $estado = $reparacion["estado"];
        $class = $arrEstado[$estado]["class"];
        $txt = $arrEstado[$estado]["text"];
        $acciones = $arrEstado[$estado]["acciones"];

        $estado = "<div class='btn-group dropleft'>
          <button type='button' class='btn btn-$class dropdown-toggle font-14' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$txt</button>
          <div class='dropdown-menu dropleft'>
            $acciones
          </div>
        </div>";

        $fInicio = date("d / m / Y", strtotime($reparacion["f_inicio"]));
        $fFin = $reparacion["f_fin"] ? date("d / m / Y", strtotime($reparacion["f_fin"])) : '';

        $data[] = [
          $reparacion["id"],
          $reparacion["usuario"],
          $reparacion["cliente"],
          $reparacion["modelo"] . " - " . $reparacion["n_serie"],
          $reparacion["costo"],
          $fInicio,
          $fFin,
          $estado,
          $botones
        ];
      }
    }

    $this->response([
      "draw" => $_POST['draw'],
      "recordsTotal" => $dataReparaciones['total'],
      "recordsFiltered" => $dataReparaciones['total'],
      "data" => $data
    ]);
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
    if (!$this->existPOST([
      'iddoc', 'nombres', 'modelo', 'marca', 'detalle', 'seriedoc', 'telefono', 'n_serie', 'tipo', 'costo', 'usuario', 'servicio'
    ])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    // Validar existencia del clietne
    $clienteModel = $this->clienteModel();
    $cliente = $clienteModel->get($_POST['seriedoc'], 'seriedoc');
    if (empty($cliente)) {
      $idc = $clienteModel->save([
        'iddoc' => $_POST['iddoc'],
        'seriedoc' => $_POST['seriedoc'],
        'nombres' => $_POST['nombres'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'direccion' => $_POST['direccion'],
      ]);
    }
    $idcliente = $idc ?? $cliente['id'];

    // Validar existencia del clietne
    $equipoModel = $this->equipoModel();
    if (empty($_POST['idequipo'])) {
      $ide = $equipoModel->save([
        'idcliente' => $idcliente,
        'idmodelo' => $_POST['modelo'],
        'n_serie' => $_POST['n_serie'],
      ]);
    } else {
      $equipo = $equipoModel->get($_POST['idequipo']);
      if (empty($equipo)) {
        $this->response(["error" => "Equipo no valido"]);
      }
    }
    $idequipo = $ide ?? $equipo['id'];

    if ($newId = $this->model->save([
      "idequipo" => $idequipo,
      "detalle" => $this->getPost('detalle'),
      "costo" => $this->getPost('costo'),
      "idusuario" => $this->getPost('usuario'),
      'idservicio' => $this->getPost('servicio'),
    ])) {
      require_once 'models/detallesModel.php';

      $detalle = new DetallesModel();
      $detalle->id = $newId;
      $detalle->tipo = 'reparacion';
      $detalle->iditem = $this->getPost('servicio');
      $detalle->tipo_item = 'servicio';
      $detalle->precio = $this->getPost('costo');
      $detalle->cantidad = 1;
      $detalle->save();

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
    require_once 'models/tipoModel.php';
    $tipos = new TipoModel();
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

  public function getDetalleServicio()
  {
    if (!$this->existPOST(['id'])) {
      $this->response(['error' => 'Faltan parametros']);
    }

    $reparacion = $this->model->get($this->getPost('id'));

    require_once 'models/detallesModel.php';
    $detalle = new DetallesModel();
    $detalle->id = $reparacion['id'];
    $detalle->iditem = $reparacion['idservicio'];

    $servicios = $detalle->getDetalleServicio();
    $servicios['cliente'] = $reparacion['nombres'];
    $servicios['seriedoc'] = $reparacion['seriedoc'];

    $this->response(['servicios' => $servicios]);
  }

  public function terminar()
  {
    if (!$this->existPOST(['data', 'comprobante'])) {
      $this->response(['error' => 'Faltan parametros']);
    }

    $data = $this->getPost('data');

    if (empty($data['id']) || empty($data['productos']) || empty($data['total'])) {
      $this->response(['error' => 'Faltan parametros']);
    }

    $reparacion = $this->model->get($data['id']);

    require_once 'models/detallesModel.php';
    require_once 'models/productoModel.php';
    require_once 'models/ventaModel.php';

    $detalle = new DetallesModel();
    $detalle->id = $reparacion['id'];
    $detalle->tipo = 'reparacion';

    $productoM = new ProductoModel();
    foreach ($data['productos'] as $producto) {
      if ($producto['idproducto'] != $reparacion['idservicio']) {
        $detalle->tipo_item = 'producto';
        $detalle->iditem = $producto['idproducto'];
        $detalle->precio = $producto['precio'];
        $detalle->cantidad = $producto['cantidad'];

        if ($detalle->save()) {
          $product = $productoM->get($producto['idproducto']);
          $productoM->id = $product['id'];
          $productoM->stock = $product['stock'] - $producto['cantidad'];
          $productoM->updateStock();
        }
      }
    }

    $venta = new VentaModel();
    $venta->idcliente = $reparacion['idcliente'];
    $venta->idusuario = $this->userId;
    $venta->comprobante = $this->getPost('comprobante');
    $venta->serie = ($this->getPost('comprobante') == "B") ? "B001" : "F001";
    $venta->descripcion = $this->getPost('descripcion');

    $venta->total = $data['total'];
    $venta->igv = $venta->total * 0.18;
    $venta->subtotal = $venta->total - $venta->igv;
    $venta->origen = "2"; # 1 => tienda / 2 => local
    $venta->save();

    $this->model->update([
      'f_fin' => date('Y-m-d H:i:s'), 'estado' => 2,
      'idventa' => $venta->id
    ], $reparacion['id']);

    $this->response(['success' => 'Reparacion terminada']);
    // hacer var_dump de productos
  }
}
