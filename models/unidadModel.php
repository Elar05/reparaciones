<?php

class UnidadModel extends Model
{
  public $id;
  public $codigo;
  public $nombre;
  public $estado;

  public function __construct()
  {
    parent::__construct();
  }

  public function get($value, $column = 'id')
  {
    try {
      $query = $this->prepare("SELECT * FROM unidades WHERE $column = :value;");
      $query->bindValue(':value', $value, PDO::PARAM_STR);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("UnidadModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM unidades;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("UnidadModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function save()
  {
    try {
      $query = $this->prepare("INSERT INTO unidades (codigo, nombre) VALUES (:codigo, :nombre)");

      $query->bindValue(':codigo', $this->codigo, PDO::PARAM_STR);
      $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);

      return $query->execute();
    } catch (PDOException $e) {
      error_log('UnidadModel::save() -> ' . $e->getMessage());
      return false;
    }
  }


  public function update()
  {
    try {
      $query = $this->prepare("UPDATE unidades SET codigo = :codigo, nombre = :nombre WHERE id = :id;");
      $query->bindParam(':codigo', $this->codigo, PDO::PARAM_STR);
      $query->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
      $query->bindParam(':id', $this->id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('UnidadModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function updateStatus()
  {
    try {
      $query = $this->prepare("UPDATE unidades SET estado = :estado WHERE id = :id;");
      $query->bindParam(':estado', $this->estado, PDO::PARAM_STR);
      $query->bindParam(':id', $this->id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("UnidadModel::updateStatus() -> " . $e->getMessage());
      return false;
    }
  }

  public function exists()
  {
    try {
      $query = $this->prepare(
        "SELECT * FROM unidades WHERE codigo = :codigo AND nombre = :nombre;"
      );
      $query->execute(['codigo' => $this->codigo, 'nombre' => $this->nombre]);

      if ($query->rowCount() > 0) return true;

      return false;
    } catch (PDOException $e) {
      error_log("UnidadModel::exists() -> " . $e->getMessage());
      return false;
    }
  }
}
