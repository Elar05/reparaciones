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
      $query = $this->query("SELECT r.*, u.nombres AS usuario, e.modelo, e.n_serie, e.idtipo_equipo, e.descripcion, et.tipo, c.documento, c.nombres AS cliente, c.email, c.telefono FROM reparaciones r JOIN usuarios u ON r.idusuario = u.id JOIN equipos e ON r.idequipo = e.id JOIN equipo_tipos et ON e.idtipo_equipo = et.id JOIN clientes c ON e.idcliente = c.id$sql;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ReparacionModel::getAll() -> " . $e->getMessage());
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
}
