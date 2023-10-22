<?php

class EquipoModel extends Model
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

      $query = $this->query(
        "SELECT
          e.id,
          e.n_serie,
          e.f_registro,
          c.nombres AS cliente,
          m.nombre AS modelo,
          t.nombre AS tipo,
          ma.nombre AS marca
        FROM equipos e
          INNER JOIN clientes c ON e.idcliente = c.id
          INNER JOIN modelos m ON e.idmodelo = m.id
          INNER JOIN tipos t ON m.idtipo = t.id
          INNER JOIN marcas ma ON m.idmarca = ma.id
        $sql;"
      );
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
      $query = $this->prepare(
        "SELECT
          e.n_serie,
          m.nombre AS modelo,
          t.nombre AS tipo,
          ma.nombre AS marca,
          m.id AS idmodelo,
          m.idtipo,
          m.idmarca,
          c.*,
          e.id
        FROM equipos e
          INNER JOIN clientes c ON e.idcliente = c.id
          INNER JOIN modelos m ON e.idmodelo = m.id
          INNER JOIN tipos t ON m.idtipo = t.id
          INNER JOIN marcas ma ON m.idmarca = ma.id
        WHERE e.$column = ?;"
      );
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
      $query = $pdo->prepare("INSERT INTO equipos (idcliente, idmodelo, n_serie) VALUES (:idcliente, :idmodelo, :n_serie);");
      $query->bindParam(':idcliente', $data['idcliente'], PDO::PARAM_STR);
      $query->bindParam(':idmodelo', $data['idmodelo'], PDO::PARAM_STR);
      $query->bindParam(':n_serie', $data['n_serie'], PDO::PARAM_STR);
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
      // error_log($sql);
      $query = $this->query($sql);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("EquipoModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM equipos WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log("EquipoModel::delete() -> " . $e->getMessage());
      return false;
    }
  }

  public function getAllByCliente($seriedoc)
  {
    try {
      $query = $this->prepare(
        "SELECT
          e.id,
          e.n_serie,
          m.nombre AS modelo,
          t.nombre AS tipo,
          ma.nombre AS marca,
          m.id AS idmodelo,
          m.idtipo,
          m.idmarca
        FROM equipos e
          INNER JOIN clientes c ON e.idcliente = c.id
          INNER JOIN modelos m ON e.idmodelo = m.id
          INNER JOIN tipos t ON m.idtipo = t.id
          INNER JOIN marcas ma ON m.idmarca = ma.id
        WHERE c.seriedoc = ?;"
      );
      $query->execute([$seriedoc]);
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("EquipoModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }
}
