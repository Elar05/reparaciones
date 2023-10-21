<?php

class ClienteModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get($value, $column = "id")
  {
    try {
      $query = $this->prepare("SELECT * FROM clientes WHERE $column = ?;");
      $query->execute([$value]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('ClienteModel::get() -> ' . $e->getMessage());
      return false;
    }
  }

  public function getAll($start, $length, $search, $column, $value)
  {
    try {
      $where = "";
      if ($column !== null && $value !== null)
        $where = "WHERE $column = '$value'";

      if ($search !== null)
        $where = "WHERE id LIKE '%$search%' OR seriedoc LIKE '%$search%' OR nombres LIKE '%$search%' OR email LIKE '%$search%' OR telefono LIKE '%$search%'";

      $query = $this->query(
        "SELECT *,
          CASE WHEN estado = 0 THEN 'Inacticvo-danger' 
          ELSE 'Activo-success' END AS status
        FROM clientes $where ORDER BY id DESC LIMIT $length OFFSET $start;"
      );
      $query->execute();
      $clientes = $query->fetchAll(PDO::FETCH_ASSOC);
      return [
        "clientes" => $clientes,
        "total" => $this->getTotal()
      ];
    } catch (PDOException $e) {
      error_log('ClienteModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function getTotal()
  {
    try {
      $query = $this->query("SELECT COUNT(*) AS total FROM clientes;");
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC)['total'];
    } catch (PDOException $e) {
      error_log('ClienteModel::getTotal() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($data)
  {
    try {
      $pdo = $this->connect();
      $query = $pdo->prepare("INSERT INTO clientes (iddoc, seriedoc, nombres, email, telefono, direccion) VALUES (:iddoc, :seriedoc, :nombres, :email, :telefono, :direccion)");

      $query->bindParam(':iddoc', $data['iddoc'], PDO::PARAM_INT);
      $query->bindParam(':seriedoc', $data['seriedoc'], PDO::PARAM_STR);
      $query->bindParam(':nombres', $data['nombres'], PDO::PARAM_STR);
      $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $query->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
      $query->bindParam(':direccion', $data['direccion'], PDO::PARAM_STR);

      $query->execute();
      return $pdo->lastInsertId();
    } catch (PDOException $e) {
      error_log('ClienteModel::save() -> ' . $e->getMessage());
      return false;
    }
  }

  public function update($data, $id)
  {
    try {
      $sql = "UPDATE clientes SET ";
      foreach ($data as $column => $value) {
        $sql .= "$column = '$value', ";
      }
      $sql = rtrim($sql, ', ');
      $sql .= " WHERE id = $id;";

      $query = $this->query($sql);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('ClienteModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM clientes WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log('ClienteModel::delete() -> ' . $e->getMessage());
      return false;
    }
  }
}
