<?php

class ReparacionModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll($filtros)
  {
    try {
      $limit = "LIMIT $filtros[length] OFFSET $filtros[start]";

      $where = "";
      // Filtro por usuario tecnico o por admin / secretaria
      if ($filtros['column'] !== null && $filtros['value'] !== null) {
        $where = "WHERE $filtros[column] = '$filtros[value]'";
      }

      // Filtro de la busqueda del datatable
      if ($filtros['search'] !== null) {
        $where = "WHERE r.costo LIKE '%$filtros[search]%' OR u.nombres LIKE '%$filtros[search]%' OR c.nombres LIKE '%$filtros[search]%' OR e.n_serie LIKE '%$filtros[search]%' OR m.nombre LIKE '%$filtros[search]%'";
      }

      // Filtro de fechas
      if ($filtros['fechaInicio'] !== null && $filtros['fechaFin'] !== null) {
        $fechaFin = date('Y-m-d', strtotime($filtros['fechaFin'] . ' + 1 day'));
        $where = "WHERE r.f_inicio BETWEEN '$filtros[fechaInicio]' AND  '$fechaFin'";
      }

      $sql = "SELECT
        r.*,
        u.nombres AS usuario,
        c.nombres AS cliente,
        e.n_serie,
        m.nombre AS modelo
      FROM reparaciones r
        INNER JOIN usuarios u ON r.idusuario = u.id
        INNER JOIN equipos e ON r.idequipo = e.id
        INNER JOIN clientes c ON e.idcliente = c.id
        INNER JOIN modelos m ON e.idmodelo = m.id 
      $where ORDER BY r.id DESC $limit;";

      $query = $this->query($sql);
      $query->execute();
      $reparaciones = $query->fetchAll(PDO::FETCH_ASSOC);

      return [
        "reparaciones" => $reparaciones,
        "total" => $this->getTotal()
      ];
    } catch (PDOException $e) {
      error_log("ReparacionModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function getTotal()
  {
    try {
      $query = $this->query("SELECT COUNT(*) AS total FROM reparaciones;");
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC)['total'];
    } catch (PDOException $e) {
      error_log('ReparacionModel::getTotal() -> ' . $e->getMessage());
      return false;
    }
  }

  public function get($id, $column = "id")
  {
    try {
      $query = $this->prepare(
        "SELECT
          r.*,
          u.nombres AS usuario,
          m.id AS modelo,
          m.idtipo AS tipo,
          m.idmarca AS marca,
          e.idcliente,
          e.n_serie,
          c.iddoc,
          c.seriedoc,
          c.nombres,
          c.email,
          c.telefono,
          c.direccion
        FROM reparaciones r
          INNER JOIN usuarios u ON r.idusuario = u.id
          INNER JOIN equipos e ON r.idequipo = e.id
          INNER JOIN clientes c ON e.idcliente = c.id
          INNER JOIN modelos m ON e.idmodelo = m.id
        WHERE r.$column = ?;"
      );
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
      $pdo = $this->connect();

      $query = $pdo->prepare("INSERT INTO reparaciones (idequipo, detalle, costo, idusuario, idservicio) VALUES (:idequipo, :detalle, :costo, :idusuario, :idservicio);");
      $query->bindParam(':idequipo', $data['idequipo'], PDO::PARAM_STR);
      $query->bindParam(':detalle', $data['detalle'], PDO::PARAM_STR);
      $query->bindParam(':costo', $data['costo'], PDO::PARAM_STR);
      $query->bindParam(':idusuario', $data['idusuario'], PDO::PARAM_STR);
      $query->bindParam(':idservicio', $data['idservicio'], PDO::PARAM_STR);

      $query->execute();
      return $pdo->lastInsertId();
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
