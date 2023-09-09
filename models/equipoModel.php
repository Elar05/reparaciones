<?php

class EquipoModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      // $query = $this->query("SELECT e.*, et.tipo FROM equipos e JOIN equipo_tipos et ON e.idtipo_equipo = et.id;");
      $query = $this->query("SELECT e.*, c.nombres AS cliente FROM equipos e JOIN clientes c ON e.idcliente = c.id;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('EquipoModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($data)
  {
    try {
      $pdo = $this->connect();
      $query = $pdo->prepare("INSERT INTO equipos (idcliente, idtipo_equipo, modelo, n_serie, descripcion) VALUES (:idcliente, :idtipo_equipo, :modelo, :n_serie, :descripcion);");
      $query->bindParam(':idcliente', $data['idcliente'], PDO::PARAM_STR);
      $query->bindParam(':idtipo_equipo', $data['tipo'], PDO::PARAM_STR);
      $query->bindParam(':modelo', $data['modelo'], PDO::PARAM_STR);
      $query->bindParam(':n_serie', $data['n_serie'], PDO::PARAM_STR);
      $query->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
      $query->execute();
      return $pdo->lastInsertId();
    } catch (PDOException $e) {
      error_log('EquipoModel::save() -> ' . $e->getMessage());
      return false;
    }
  }
}
