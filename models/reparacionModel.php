<?php

class ReparacionModel extends Model
{
  public function __construct()
  {
    parent::__construct();
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
