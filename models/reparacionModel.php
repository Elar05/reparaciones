<?php

class ReparacionModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll($column = null, $value = null)
  {
    try {
      $sql = "";
      if ($column !== null && $value !== null) $sql = " WHERE $column = '$value'";
      $q = "SELECT r.*, u.nombres AS usuario, e.modelo, e.n_serie, e.idtipo_equipo, et.tipo, c.documento, c.nombres AS cliente, c.email, c.telefono FROM reparaciones r JOIN usuarios u ON r.idusuario = u.id JOIN equipos e ON r.idequipo = e.id JOIN equipo_tipos et ON e.idtipo_equipo = et.id JOIN clientes c ON e.idcliente = c.id$sql;";
      $query = $this->query($q);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ReparacionModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function get($id, $column = "id")
  {
    try {
      $query = $this->prepare("SELECT r.*, u.nombres AS usuario, e.modelo, e.n_serie, e.idtipo_equipo, et.tipo, c.documento, c.nombres AS cliente, c.email, c.telefono FROM reparaciones r JOIN usuarios u ON r.idusuario = u.id JOIN equipos e ON r.idequipo = e.id JOIN equipo_tipos et ON e.idtipo_equipo = et.id JOIN clientes c ON e.idcliente = c.id WHERE r.$column = ?;");
      $query->execute([$id]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ReparacionModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function save($data)
  {
    try {
      $query = $this->prepare("INSERT INTO reparaciones (idequipo, detalle, costo, idusuario) VALUES (:idequipo, :detalle, :costo, :idusuario);");
      $query->bindParam(':idequipo', $data['idequipo'], PDO::PARAM_STR);
      $query->bindParam(':detalle', $data['detalle'], PDO::PARAM_STR);
      $query->bindParam(':costo', $data['costo'], PDO::PARAM_STR);
      $query->bindParam(':idusuario', $data['idusuario'], PDO::PARAM_STR);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ReparacionModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update($datos, $id)
  {
    try {
      $sql = "UPDATE reparaciones SET ";
      foreach ($datos as $columna => $valor) {
        $sql .= "$columna = '$valor', ";
      }

      $sql = rtrim($sql, ', '); // elimina la última coma y el espacio
      $sql .= " WHERE id = $id;";
      $query = $this->query($sql);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ReparacionModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM reparaciones WHERE id = :id;");
      $query->bindValue(':id', $id, PDO::PARAM_INT);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('ReparacionModel::delete() -> ' . $e->getMessage());
      return false;
    }
  }
}
