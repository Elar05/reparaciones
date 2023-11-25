<?php

class DetallesModel extends Model
{
  public $id;
  public $tipo;
  public $iditem;
  public $tipo_item;
  public $precio;
  public $cantidad;
  public $subtotal;

  public function __construct()
  {
    parent::__construct();
  }

  public function getDetalleProductos()
  {
    try {
      $query = $this->prepare(
        "SELECT
          d.*,
          CONCAT(p.n_serie, ' - ', m.nombre) AS nombre
        FROM detalles d
          INNER JOIN productos p ON d.iditem = p.id
          INNER JOIN modelos m ON p.idmodelo = m.id
        WHERE
          d.id = :id
          AND d.tipo = :tipo
          AND d.tipo_item = 'producto';"
      );

      $query->bindValue(':id', $this->id, PDO::PARAM_INT);
      $query->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);

      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('DetallesModel::getDetalleProductos() -> ' . $e->getMessage());
      return false;
    }
  }

  public function getDetalleServicio()
  {
    try {
      $query = $this->prepare(
        "SELECT d.*, s.nombre
        FROM detalles d
        INNER JOIN servicios s ON d.iditem = s.id
        WHERE d.id = :id AND d.iditem = :iditem;"
      );

      $query->bindValue(':id', $this->id, PDO::PARAM_INT);
      $query->bindValue(':iditem', $this->iditem, PDO::PARAM_INT);

      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('DetallesModel::getDetalleServicios() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save()
  {
    try {
      $query = $this->prepare(
        "INSERT INTO detalles (id, tipo, iditem, tipo_item, precio, cantidad)
        VALUES (:id, :tipo, :iditem, :tipo_item, :precio, :cantidad)"
      );

      $query->bindValue(':id', $this->id, PDO::PARAM_INT);
      $query->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
      $query->bindValue(':iditem', $this->iditem, PDO::PARAM_INT);
      $query->bindValue(':tipo_item', $this->tipo_item, PDO::PARAM_STR);
      $query->bindValue(':precio', $this->precio, PDO::PARAM_STR);
      $query->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);

      return $query->execute();
    } catch (PDOException $e) {
      error_log('DetallesModel::save() -> ' . $e->getMessage());
      return false;
    }
  }
}
