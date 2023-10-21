<?php

class DocumentoModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get($id, $column = 'id')
  {
    try {
      $query = $this->prepare("SELECT * FROM documentos WHERE $column = ?;");
      $query->execute([$id]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("DocumentoModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM documentos;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("DocumentoModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function save($nombre)
  {
    try {
      $query = $this->prepare("INSERT INTO documentos (nombre) VALUES (:nombre);");
      $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("DocumentoModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update($nombre, $id)
  {
    try {
      $query = $this->prepare("UPDATE documentos SET nombre=:nombre WHERE id=:id;");
      $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
      $query->bindParam(':id', $id, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("DocumentoModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM documentos WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log("DocumentoModel::delete() -> " . $e->getMessage());
      return false;
    }
  }
}
