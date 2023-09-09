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

  public function getAll()
  {
    try {
      $query = $this->query("SELECT * FROM clientes;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('ClienteModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($data)
  {
    try {
      $pdo = $this->connect();
      $query = $pdo->prepare("INSERT INTO clientes (documento, nombres, email, telefono) VALUES (:documento, :nombres, :email, :telefono)");

      $query->bindParam(':documento', $data['documento'], PDO::PARAM_STR);
      $query->bindParam(':nombres', $data['nombres'], PDO::PARAM_STR);
      $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $query->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);

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
