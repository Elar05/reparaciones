<?php

class MarcaModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get($id, $column = 'id')
  {
    try {
      $query = $this->prepare("SELECT * FROM marcas WHERE $column = ?;");
      $query->execute([$id]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("MarcaModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM marcas;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("MarcaModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function save($nombre)
  {
    try {
      $query = $this->prepare("INSERT INTO marcas (nombre) VALUES (:nombre);");
      $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("MarcaModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update($nombre, $id)
  {
    try {
      $query = $this->prepare("UPDATE marcas SET nombre=:nombre WHERE id=:id;");
      $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
      $query->bindParam(':id', $id, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("MarcaModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function updateStatus($estado, $id)
  {
    try {
      $query = $this->prepare("UPDATE marcas SET estado=:estado WHERE id=:id;");
      $query->bindParam(':estado', $estado, PDO::PARAM_STR);
      $query->bindParam(':id', $id, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("MarcaModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM marcas WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log("MarcaModel::delete() -> " . $e->getMessage());
      return false;
    }
  }
}
