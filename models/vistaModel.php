<?php

class VistaModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM vistas;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("VistasModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function get($value, $column = 'id')
  {
    try {
      $query = $this->prepare("SELECT * FROM vistas WHERE $column = ?;");
      $query->execute([$value]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("VistasModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function save($vista)
  {
    try {
      $query = $this->prepare("INSERT INTO vistas (vista) VALUES (:vista);");
      $query->bindParam(':vista', $vista, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("VistasModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update($vista, $id)
  {
    try {
      $query = $this->prepare("UPDATE vistas SET vista = :vista WHERE id = :id;");
      $query->bindParam(':vista', $vista, PDO::PARAM_STR);
      $query->bindParam(':id', $id, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("VistasModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM vistas WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log("VistasModel::delete() -> " . $e->getMessage());
      return false;
    }
  }
}
