<?php

class UsuarioModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAll()
  {
    try {
      $query = $this->query("SELECT u.*, ut.tipo FROM usuarios u JOIN usuario_tipos ut ON u.idtipo_usuario = ut.id;");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('UsuarioModel::getAll() -> ' . $e->getMessage());
      return false;
    }
  }

  public function get($id)
  {
    try {
      $query = $this->prepare("SELECT * FROM usuarios WHERE id = :id;");
      $query->bindParam(':id', $id, PDO::PARAM_INT);
      $query->execute();
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log('UsuarioModel::get() -> ' . $e->getMessage());
      return false;
    }
  }

  public function save($data)
  {
    try {
      $query = $this->prepare("INSERT INTO usuarios (idtipo_usuario, nombres, email, password, telefono, direccion) VALUES (:idtipo_usuario, :nombres, :email, :password, :telefono, :direccion); ");

      $query->bindParam(':idtipo_usuario', $data['tipo'], PDO::PARAM_STR);
      $query->bindParam(':nombres', $data['nombres'], PDO::PARAM_STR);
      $query->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $query->bindParam(':password', $data['password'], PDO::PARAM_STR);
      $query->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
      $query->bindParam(':direccion', $data['direccion'], PDO::PARAM_STR);

      return $query->execute();
    } catch (PDOException $e) {
      error_log('UsuarioModel::save() -> ' . $e->getMessage());
      return false;
    }
  }

  public function update($data, $id)
  {
    try {
      $sql = "UPDATE usuarios SET ";
      foreach ($data as $column => $value) {
        $sql .= "$column = '$value', ";
      }
      $sql = rtrim($sql, ', ');
      $sql .= " WHERE id = $id";

      $query = $this->query($sql);
      return $query->execute();
    } catch (PDOException $e) {
      error_log('UsuarioModel::update() -> ' . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM usuarios WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log('UsuarioModel::delete() -> ' . $e->getMessage());
      return false;
    }
  }
}
