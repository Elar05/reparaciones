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
      $query = $this->query("SELECT e.*, et.tipo FROM equipos e JOIN equipo_tipos et ON e.idtipo_equipo = et.id;");
      $query = $this->query("SELECT e.*, c.nombres AS cliente, et.tipo FROM equipos e JOIN clientes c ON e.idcliente = c.id JOIN equipo_tipos et ON e.idtipo_equipo = et.id;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('EquipoModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function get($id, $column = "id")
  {
    try {
      $query = $this->prepare("SELECT e.*, c.documento, c.nombres, c.email, c.telefono FROM equipos e JOIN clientes c ON e.idcliente = c.id WHERE e.$column = ?;");
      $query->execute([$id]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('EquipoModel::get() -> ' . $e->getMessage());
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

  public function update($datos, $id)
  {
    try {
      $sql = "UPDATE equipos SET ";
      foreach ($datos as $columna => $valor) {
        $sql .= "$columna = '$valor', ";
      }

      $sql = rtrim($sql, ', '); // elimina la última coma y el espacio
      $sql .= " WHERE id = $id;";
      $query = $this->query($sql);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("EquipoModel::update() -> " . $e->getMessage());
      return false;
    }
  }
}
