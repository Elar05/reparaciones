<?php

class UsuarioTiposModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM usuario_tipos;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('UsuarioTiposModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function get($value, $column = "id")
  {
    try {
      $query = $this->prepare("SELECT * FROM usuario_tipos WHERE $column = ?;");
      $query->execute([$value]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('UsuarioTiposModel::get() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($tipo)
  {
    try {
      $query = $this->prepare("INSERT INTO usuario_tipos (tipo) VALUES (:tipo);");
      $query->bindParam(':tipo', $tipo, PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('UsuarioTiposModel::save() -> ' . $e->getMessage());
      return false;
    }
  }
}
