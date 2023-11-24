<?php

class ServicioModel extends Model
{
  public $id;
  public $nombre;
  public $precio;
  public $estado;

  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM servicios;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ServicioModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function get($value, $column = 'id')
  {
    try {
      $query = $this->prepare("SELECT * FROM servicios WHERE $column = :value;");
      $query->bindValue(':value', $value, PDO::PARAM_STR);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ServicioModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function save()
  {
    try {
      $query = $this->prepare(
        "INSERT INTO servicios (nombre, precio) VALUES (:nombre, :precio);"
      );
      $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
      $query->bindValue(':precio', $this->precio, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ServicioModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update()
  {
    try {
      $query = $this->prepare("UPDATE servicios SET nombre = :nombre, precio = :precio WHERE id = :id;");
      $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
      $query->bindValue(':precio', $this->precio, PDO::PARAM_STR);
      $query->bindParam(':id', $this->id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('ServicioModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function updateStatus()
  {
    try {
      $query = $this->prepare("UPDATE servicios SET estado = :estado WHERE id = :id;");
      $query->bindParam(':estado', $this->estado, PDO::PARAM_STR);
      $query->bindParam(':id', $this->id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ServicioModel::updateStatus() -> " . $e->getMessage());
      return false;
    }
  }
}
