<?php

class ProductoModel extends Model
{
  public $id;
  public $idmodelo;
  public $idunidad;
  public $n_serie;
  public $precio_c;
  public $precio_v;
  public $stock;
  public $stock_min;
  public $foto;
  public $descripcion;
  public $f_registro;
  public $estado;
  public $destino;

  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query(
        "SELECT
          p.*,
          m.nombre AS modelo,
          u.nombre AS unidad
        FROM productos p
          INNER JOIN modelos m ON p.idmodelo = m.id
          INNER JOIN unidades u ON p.idunidad = u.id;"
      );
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ProductoModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function get($value, $column = 'p.id')
  {
    try {
      $query = $this->prepare(
        "SELECT
          p.*,
          m.idtipo AS tipo,
          m.idmarca AS marca
        FROM productos p
          INNER JOIN modelos m ON p.idmodelo = m.id
        WHERE $column = :value;"
      );
      $query->bindValue(':value', $value, PDO::PARAM_STR);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ProductoModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function save()
  {
    try {
      $query = $this->prepare(
        "INSERT INTO productos (idmodelo, idunidad, n_serie, precio_c, precio_v, stock, stock_min, foto, descripcion, destino) VALUES (:idmodelo, :idunidad, :n_serie, :precio_c, :precio_v, :stock, :stock_min, :foto, :descripcion, :destino);"
      );
      $query->bindValue(':idmodelo', $this->idmodelo, PDO::PARAM_INT);
      $query->bindValue(':idunidad', $this->idunidad, PDO::PARAM_INT);
      $query->bindValue(':n_serie', $this->n_serie, PDO::PARAM_STR);
      $query->bindValue(':precio_c', $this->precio_c, PDO::PARAM_STR);
      $query->bindValue(':precio_v', $this->precio_v, PDO::PARAM_STR);
      $query->bindValue(':stock', $this->stock, PDO::PARAM_INT);
      $query->bindValue(':stock_min', $this->stock_min, PDO::PARAM_INT);
      $query->bindValue(':foto', $this->foto, PDO::PARAM_STR);
      $query->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
      $query->bindValue(':destino', $this->destino, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ProductoModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update()
  {
    try {
      $query = $this->prepare("UPDATE productos SET idmodelo = :idmodelo, idunidad = :idunidad, n_serie = :n_serie, precio_c = :precio_c, precio_v = :precio_v, stock = :stock, stock_min = :stock_min, foto = :foto, descripcion = :descripcion, destino = :destino WHERE id = :id;");
      $query->bindValue(':idmodelo', $this->idmodelo, PDO::PARAM_INT);
      $query->bindValue(':idunidad', $this->idunidad, PDO::PARAM_INT);
      $query->bindValue(':n_serie', $this->n_serie, PDO::PARAM_STR);
      $query->bindValue(':precio_c', $this->precio_c, PDO::PARAM_STR);
      $query->bindValue(':precio_v', $this->precio_v, PDO::PARAM_STR);
      $query->bindValue(':stock', $this->stock, PDO::PARAM_INT);
      $query->bindValue(':stock_min', $this->stock_min, PDO::PARAM_INT);
      $query->bindValue(':foto', $this->foto, PDO::PARAM_STR);
      $query->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
      $query->bindValue(':destino', $this->destino, PDO::PARAM_STR);
      $query->bindParam(':id', $this->id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('ProductoModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function updateStatus()
  {
    try {
      $query = $this->prepare("UPDATE productos SET estado = :estado WHERE id = :id;");
      $query->bindParam(':estado', $this->estado, PDO::PARAM_STR);
      $query->bindParam(':id', $this->id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ProductoModel::updateStatus() -> " . $e->getMessage());
      return false;
    }
  }
}
