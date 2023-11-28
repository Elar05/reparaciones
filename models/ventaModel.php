<?php

class VentaModel extends Model
{
  public $id;
  public $idcliente;
  public $idusuario;
  public $comprobante;
  public $serie;
  public $correlativo;
  public $descripcion;
  public $subtotal;
  public $igv;
  public $total;
  public $fecha;
  public $estado;
  public $origen;

  public function __construct()
  {
    parent::__construct();
  }

  public function get($id, $column = "id")
  {
    try {
      $query = $this->prepare(
        "SELECT *
        FROM ventas
        WHERE $column = ?;"
      );
      $query->execute([$id]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ReparacionModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function save()
  {
    try {
      $this->correlativo = $this->getLastCorrelativo($this->comprobante) + 1;

      $pdo = $this->connect();
      $query = $pdo->prepare("INSERT INTO ventas (idcliente, idusuario, comprobante, serie, correlativo, descripcion, subtotal, igv, total, origen) VALUES (:idcliente, :idusuario, :comprobante, :serie, :correlativo, :descripcion, :subtotal, :igv, :total, :origen);");

      $query->bindValue(':idcliente', $this->idcliente, PDO::PARAM_INT);
      $query->bindValue(':idusuario', $this->idusuario, PDO::PARAM_INT);
      $query->bindValue(':comprobante', $this->comprobante, PDO::PARAM_STR);
      $query->bindValue(':serie', $this->serie, PDO::PARAM_STR);
      $query->bindValue(':correlativo', $this->correlativo, PDO::PARAM_STR);
      $query->bindValue(':descripcion', $this->descripcion, PDO::PARAM_STR);
      $query->bindValue(':subtotal', $this->subtotal, PDO::PARAM_STR);
      $query->bindValue(':igv', $this->igv, PDO::PARAM_STR);
      $query->bindValue(':total', $this->total, PDO::PARAM_STR);
      $query->bindValue(':origen', $this->origen, PDO::PARAM_STR);

      $query->execute();
      $this->id = $pdo->lastInsertId();

      return true;
    } catch (PDOException $e) {
      error_log('VentaModel::save() -> ' . $e->getMessage());
      return false;
    }
  }

  public function getLastCorrelativo($comprobante)
  {
    try {
      $query = $this->prepare("SELECT correlativo FROM ventas WHERE comprobante = ? ORDER BY id DESC LIMIT 1;");
      $query->execute([$comprobante]);
      return $query->fetch(PDO::FETCH_ASSOC)['correlativo'] ?? 0;
    } catch (PDOException $e) {
      error_log('VentaModel::getLastCorrelativo() -> ' . $e->getMessage());
      return false;
    }
  }
}