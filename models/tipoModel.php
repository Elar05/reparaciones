<?php

class TipoModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM tipos");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('TipoModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function get($value, $column = "id")
  {
    try {
      $query = $this->prepare("SELECT * FROM tipos WHERE $column = :value;");
      $query->bindValue(':value', $value, PDO::PARAM_STR);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('TipoModel::get() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($nombre)
  {
    try {
      $query = $this->prepare("INSERT INTO tipos (nombre) VALUES (:nombre);");
      $query->bindValue(':nombre', $nombre, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('TipoModel::save() -> ' . $e->getMessage());
      return false;
    }
  }

  public function update($column, $value, $id)
  {
    try {
      $query = $this->prepare("UPDATE tipos SET $column = :value WHERE id = :id;");
      $query->bindParam(':value', $value, PDO::PARAM_STR);
      $query->bindParam(':id', $id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('TipoModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM tipos WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log('TipoModel::delete() -> ' . $e->getMessage());
      return false;
    }
  }
}
