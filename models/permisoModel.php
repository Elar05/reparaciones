<?php

class PermisoModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll($id)
  {
    try {
      $query = $this->prepare("SELECT p.*, v.vista FROM permisos p JOIN vistas v ON p.idvista = v.id WHERE p.idtipo_usuario = ?;");
      $query->execute([$id]);
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("PermisoModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function get($vista, $tipo)
  {
    try {
      $query = $this->prepare("SELECT * FROM permisos WHERE idvista = ? AND idtipo_usuario = ?;");
      $query->execute([$vista, $tipo]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("PermisoModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function save($vista, $tipo)
  {
    try {
      $query = $this->prepare("INSERT INTO permisos (idvista, idtipo_usuario) VALUES (?, ?);");
      return $query->execute([$vista, $tipo]);
    } catch (PDOException $e) {
      error_log("PermisoModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($vista, $tipo)
  {
    try {
      $query = $this->prepare("DELETE FROM permisos WHERE idvista = ? AND idtipo_usuario = ?;");
      return $query->execute([$vista, $tipo]);
    } catch (PDOException $e) {
      error_log("PermisoModel::delete() -> " . $e->getMessage());
      return false;
    }
  }

  public function getPermisosByType($tipo)
  {
    try {
      $permisos = ['login'];
      if ($tipo === 0) return $permisos;

      $query = $this->prepare("SELECT v.vista FROM permisos p JOIN vistas v ON p.idvista = v.id WHERE p.idtipo_usuario = :tipo");
      $query->execute([":tipo" => $tipo]);
      $data = $query->fetchAll(PDO::FETCH_ASSOC);
      $permisos = [];
      foreach ($data as $item) {
        $permisos[] = $item['vista'];
      }
      return $permisos;
    } catch (PDOException $e) {
      error_log('PermisoModel::getPermisosByType() -> ' . $e->getMessage());
      return false;
    }
  }
}
