<?php

class Producto extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('producto/index');
  }

  public function list()
  {
    $data = [];
    $productos = $this->model->getAll();

    if ($this->existPOST(['data'])) $this->response(["data" => $productos]);

    if (count($productos) > 0) {
      foreach ($productos as $producto) {
        $botones = "<button class='btn btn-warning edit mr-2' id='{$producto["id"]}'><i class='fas fa-pencil-alt'></i></button>";
        $botones .= "<button class='btn btn-info img' foto='{$producto["foto"]}'><i class='fas fa-link'></i></button>";

        $class = ($producto["estado"] === "1") ? "success" : "danger";
        $txt = ($producto["estado"] === "1") ? "Activo" : "Inactivo";

        $estado = "<span class='badge badge-$class text-uppercase font-weight-bold cursor-pointer'>$txt</span>";
        $estado .= "<button class='ml-1 btn btn-info estado' data-id='{$producto["id"]}' data-estado='{$producto["estado"]}'><i class='fas fa-sync'></i></button>";

        $data[] = [
          $producto["id"],
          "$producto[modelo] - $producto[n_serie]",
          $producto["unidad"],
          $producto["precio_c"],
          $producto["precio_v"],
          $producto["stock"],
          $producto["stock_min"],
          $estado,
          $botones,
        ];
      }
    }
    $this->response(["data" => $data]);
  }

  public function create()
  {
    if (!$this->existPOST(['modelo', 'unidad', 'n_serie', 'precio_c', 'precio_v', 'stock', 'stock_min', 'destino'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $urlFoto = "";
    if (!empty($_FILES["foto"]['name'])) {
      $foto = $_FILES["foto"];

      $types = ["jpg", "png", "webp", "jpeg"];
      $type = pathinfo($foto["name"], PATHINFO_EXTENSION);

      if (!in_array($type, $types))
        $this->response(["error" => "The file type is not valid."]);

      $folder = "public/img/productos/";
      if (!file_exists($folder)) mkdir($folder, 0777, true);

      $urlFoto = $folder . str_replace(" -", "_", $foto['name']);
      move_uploaded_file($foto['tmp_name'], $urlFoto);
    }

    $this->model = new ProductoModel;
    $this->model->idmodelo = $this->getPost('modelo');
    $this->model->idunidad = $this->getPost('unidad');
    $this->model->n_serie = $this->getPost('n_serie');
    $this->model->precio_c = $this->getPost('precio_c');
    $this->model->precio_v = $this->getPost('precio_v');
    $this->model->stock = $this->getPost('stock');
    $this->model->stock_min = $this->getPost('stock_min');
    $this->model->foto = $urlFoto;
    $this->model->descripcion = $this->getPost('descripcion');
    $this->model->destino = $this->getPost('destino');

    // if ($this->model->exists()) {
    //   $this->response(["error" => "Ya existe la producto"]);
    // }

    if ($this->model->save()) {
      $this->response(["success" => "producto registrado"]);
    }
    $this->response(["error" => "Error al registrar producto"]);
  }

  public function get()
  {
    if (!$this->existPOST(['id'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    if ($producto = $this->model->get($this->getPost('id'))) {
      $this->response(["producto" => $producto]);
    }

    $this->response(["error" => "Error al buscar producto"]);
  }

  public function edit()
  {
    if (!$this->existPOST(['id', 'modelo', 'unidad', 'n_serie', 'precio_c', 'precio_v', 'stock', 'stock_min', 'destino'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $urlFoto = $this->getPost('urlFoto');
    if (!empty($_FILES["foto"]['name'])) {
      $foto = $_FILES["foto"];

      $types = ["jpg", "png", "webp", "jpeg"];
      $type = pathinfo($foto["name"], PATHINFO_EXTENSION);

      if (!in_array($type, $types))
        $this->response(["error" => "The file type is not valid."]);

      $folder = "public/img/productos/";
      if (!file_exists($folder)) mkdir($folder, 0777, true);

      $urlFoto = $folder . str_replace(" -", "_", $foto['name']);
      move_uploaded_file($foto['tmp_name'], $urlFoto);
    }

    $this->model = new ProductoModel;
    $this->model->id = $this->getPost('id');
    $this->model->idmodelo = $this->getPost('modelo');
    $this->model->idunidad = $this->getPost('unidad');
    $this->model->n_serie = $this->getPost('n_serie');
    $this->model->precio_c = $this->getPost('precio_c');
    $this->model->precio_v = $this->getPost('precio_v');
    $this->model->stock = $this->getPost('stock');
    $this->model->stock_min = $this->getPost('stock_min');
    $this->model->foto = $urlFoto;
    $this->model->descripcion = $this->getPost('descripcion');
    $this->model->destino = $this->getPost('destino');

    // Actualizar
    if ($this->model->update()) {
      $this->response(["success" => "producto actualizada"]);
    }

    $this->response(["error" => "Error al registrar producto"]);
  }

  public function updateStatus()
  {
    if (!$this->existPOST(['id', 'estado'])) {
      $this->response(["error" => "Faltan parametros"]);
    }

    $estado = ($this->getPost('estado') == 0) ? 1 : 0;

    $this->model = new ProductoModel();
    $this->model->id = $this->getPost('id');
    $this->model->estado = $estado;

    if ($this->model->updateStatus()) {
      $this->response(["success" => "Estado actualizado"]);
    }

    $this->response(["error" => "Error al actualizar estado"]);
  }

  public function listProductosLocal()
  {
    $data = [];
    $this->model->destino = 2;
    $productos = $this->model->getAll();
    if (count($productos) > 0) {
      foreach ($productos as $producto) {
        $modeloSerie = "$producto[modelo] - $producto[n_serie]";
        $botones = "<button class='btn btn-success btn-sm producto' data-id='{$producto['id']}' data-modeloserie='$modeloSerie' data-precio='{$producto['precio_v']}' data-stock='{$producto['stock']}'><i class='fas fa-arrow-right'></i></button>";

        $data[] = [
          $modeloSerie,
          $producto["precio_v"],
          $producto["stock"],
          $botones,
        ];
      }
    }
    $this->response(["data" => $data]);
  }
}
