<?php

class EquipoTiposModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM equipo_tipos");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('EquipoTiposModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function get($value, $column = "id")
  {
    try {
      $query = $this->prepare("SELECT * FROM equipo_tipos WHERE $column = :value;");
      $query->bindValue(':value', $value, PDO::PARAM_STR);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('EquipoTiposModel::get() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($tipo)
  {
    try {
      $query = $this->prepare("INSERT INTO equipo_tipos (tipo) VALUES (:tipo);");
      $query->bindValue(':tipo', $tipo, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('EquipoTiposModel::save() -> ' . $e->getMessage());
      return false;
    }
  }

  public function update($tipo, $id)
  {
    try {
      $query = $this->prepare("UPDATE equipo_tipos SET tipo = :tipo WHERE id = :id;");
      $query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
      $query->bindParam(':id', $id, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('EquipoTiposModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM equipo_tipos WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log('EquipoTiposModel::delete() -> ' . $e->getMessage());
      return false;
    }
  }
}
