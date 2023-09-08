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
}
