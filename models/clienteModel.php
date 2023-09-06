<?php

class ClienteModel extends Model
{
  public function __construct()
  {
    parent::__construct();
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
}
