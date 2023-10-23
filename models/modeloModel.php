<?php

class ModeloModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function get($value, $column = 'id', $idtipo = null, $idmarca = null)
  {
    try {
      $sql = "";
      if ($idtipo !== null && $idmarca !== null)
        $sql = "AND idtipo = $idtipo AND idmarca = $idmarca";

      $query = $this->prepare("SELECT * FROM modelos WHERE $column = :value $sql;");
      $query->execute(['value' => $value]);
      return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ModeloModel::get() -> " . $e->getMessage());
      return false;
    }
  }

  public function getAll()
  {
    try {
      $query = $this->query(
        "SELECT
          mo.*,
          t.nombre AS tipo,
          ma.nombre AS marca,
          CASE WHEN mo.estado = 0 THEN 'Inacticvo-danger' 
          ELSE 'Activo-success' END AS status
        FROM modelos mo
          INNER JOIN tipos t ON mo.idtipo = t.id
          INNER JOIN marcas ma ON mo.idmarca = ma.id;"
      );
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ModeloModel::getAll() -> " . $e->getMessage());
      return false;
    }
  }

  public function save($data)
  {
    try {
      $query = $this->prepare("INSERT INTO modelos (idtipo, idmarca, nombre) VALUES (:idtipo, :idmarca, :nombre);");
      $query->bindValue(':idtipo', $data['idtipo'], PDO::PARAM_INT);
      $query->bindValue(':idmarca', $data['idmarca'], PDO::PARAM_INT);
      $query->bindValue(':nombre', $data['nombre'], PDO::PARAM_STR);

      return $query->execute();
    } catch (PDOException $e) {
      error_log("ModeloModel::save() -> " . $e->getMessage());
      return false;
    }
  }

  public function update($datos, $id)
  {
    try {
      $sql = "UPDATE modelos SET ";
      foreach ($datos as $columna => $valor) {
        $sql .= "$columna = '$valor', ";
      }

      $sql = rtrim($sql, ', '); // elimina la última coma y el espacio
      $sql .= " WHERE id = $id;";
      $query = $this->query($sql);
      return $query->execute();
    } catch (PDOException $e) {
      error_log("ModeloModel::update() -> " . $e->getMessage());
      return false;
    }
  }

  public function delete($id)
  {
    try {
      $query = $this->prepare("DELETE FROM modelos WHERE id = ?;");
      return $query->execute([$id]);
    } catch (PDOException $e) {
      error_log("ModeloModel::delete() -> " . $e->getMessage());
      return false;
    }
  }

  /**
   * *`Obtiene todas los modelos por marca de equipo`*
   *
   * @param int $idmarca
   * @return array|false
   */
  public function getAllByMarcaAndTipo($idtipo, $idmarca)
  {
    try {
      $query = $this->prepare("SELECT * FROM modelos WHERE idtipo = :idtipo AND idmarca = :idmarca ORDER BY nombre ASC");
      $query->bindValue(':idtipo', $idtipo, PDO::PARAM_INT);
      $query->bindValue(':idmarca', $idmarca, PDO::PARAM_INT);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("ModeloModel::getModelosByMarca() -> " . $e->getMessage());
      return false;
    }
  }
}
