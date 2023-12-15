<?php

class Venta extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('venta/index');
  }

  public function nueva()
  {
    require_once 'models/documentoModel.php';
    $documentos = new DocumentoModel();

    $this->view->render('venta/nueva', [
      "documentos" => $documentos->getAll()
    ]);
  }

  public function save()
  {
    if (!$this->existPOST(['iddoc', 'seriedoc', 'nombres', 'telefono', 'comprobante', 'subtotal', 'igv', 'total', 'detalle_venta'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $productos = json_decode($_POST['detalle_venta'], true);
    if (empty($productos)) {
      $this->response(["error" => "No hay prodcutos"]);
    }

    require_once 'models/clienteModel.php';
    require_once 'models/detallesModel.php';
    require_once 'models/productoModel.php';

    // Validar cliente
    $clienteModel = new ClienteModel();
    $cliente = $clienteModel->get($this->getPost('seriedoc'), 'seriedoc');

    if (empty($cliente)) {
      $idc = $clienteModel->save([
        'iddoc' => trim($_POST['iddoc']),
        'seriedoc' => trim($_POST['seriedoc']),
        'nombres' => trim($_POST['nombres']),
        'email' => trim($_POST['email']) ?? "",
        'telefono' => trim($_POST['telefono']),
        'direccion' => trim($_POST['direccion']) ?? "",
      ]);
    }
    $idcliente = $cliente['id'] ?? $idc;

    // Crear venta
    $venta = new VentaModel();
    $venta->idcliente = $idcliente;
    $venta->idusuario = $this->userId;
    $venta->comprobante = $_POST['comprobante'];
    $venta->serie = ($_POST['comprobante'] === "B") ? "B001" : "F001";
    $venta->descripcion = $_POST['descripcion'] ?? "";
    $venta->total = $_POST['total'];
    $venta->igv = $_POST['igv'];
    $venta->subtotal = $_POST['subtotal'];
    $venta->origen = "1"; # 1 => tienda / 2 => local
    $venta->save();

    // Instanciar detalle a guardar
    $detalle = new DetallesModel();
    $detalle->id = $venta->id;
    $detalle->tipo = 'venta';

    // Instanciar el modelo para actualizar el stock
    $productoM = new ProductoModel();

    // Agregar los productos al detalle
    foreach ($productos as $producto) {
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

    $this->response(['success' => 'Venta registrada']);
  }

  public function list()
  {
    $data = [];
    $ventas = $this->model->getAll();
    if (count($ventas) > 0) {
      foreach ($ventas as $venta) {
        $botones = "<button class='btn btn-info detalle' id='{$venta["id"]}'><i class='fas fa-info'></i></button>";
        $botones .= "<a href='" . URL . "venta/pdf?id={$venta["id"]}' target='_blank' class='ml-1 btn btn-danger pdf' id='{$venta["id"]}'><i class='fas fa-file-pdf'></i></a>";

        $data[] = [
          $venta["id"],
          $venta["usuario"],
          $venta["cliente"],
          "$venta[serie]-$venta[correlativo]",
          $venta["subtotal"],
          $venta["igv"],
          $venta["total"],
          $venta["fecha"],
          $botones,
        ];
      }
    }

    $this->response(["data" => $data]);
  }

  public function get()
  {
    if (!$this->existPOST(['id'])) {
      $this->response(['error' => 'Faltan parametros']);
    }

    $venta = new VentaModel();
    $venta = $venta->get($_POST['id']);

    require_once 'models/detallesModel.php';
    $detalle = new DetallesModel();
    $detalle->id = $venta['id'];
    $detalle->tipo = 'venta';

    $productos = $detalle->getDetalleProductos();
    $venta['detalle'] = $productos;

    $this->response(['venta' => $venta]);
  }

  public function pdf()
  {
    if (!$this->existGET(['id'])) {
      $this->redirectEncode("venta", ["message" => "Algo salio mal"]);
    }

    if (empty($_GET['id'])) {
      $this->redirectEncode("venta", ["message" => "Algo salio mal"]);
    }

    $venta = new VentaModel();
    $venta = $venta->get($_GET['id']);

    require_once 'models/detallesModel.php';
    $detalle = new DetallesModel();
    $detalle->id = $venta['id'];
    $detalle->tipo = 'venta';

    $productos = $detalle->getDetalleProductos();
    $venta['detalle'] = $productos;

    $this->view->render('venta/pdf', ['venta' => $venta]);
  }
}
