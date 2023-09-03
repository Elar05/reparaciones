<?php

class Errors
{
  // ERROR_controller_method - operation

  const ERROR_USUARIOTIPOS_SAVE = "8as98fsadfasd6";
  const ERROR_USUARIOTIPOS_SAVE_EMPTY = "7sd87s45d6ds76";
  const ERROR_USUARIOTIPOS_SAVE_EXISTS = "7sd87554dffds76";

  const ERROR_USUARIOTIPOS_UPDATE_EMPTY = "sd87sd87sd87sd78";
  const ERROR_USUARIOTIPOS_UPDATE_EXISTS = "7sd8sd5s43dfs76";
  const ERROR_USUARIOTIPOS_UPDATE = "as87a9s8df79as8d7f9";

  const ERROR_USUARIOTIPOS_DELETE_EMPTY = "sd87sd87sd87sd78ds78";
  const ERROR_USUARIOTIPOS_DELETE = "sd87er7sd76ds";

  private $errorList = [];

  public function __construct()
  {
    $this->errorList = [
      Errors::ERROR_USUARIOTIPOS_SAVE => "Error al guardar tipo de usuario",
      Errors::ERROR_USUARIOTIPOS_SAVE_EMPTY => "Complete el formulario",
      Errors::ERROR_USUARIOTIPOS_SAVE_EXISTS => "El tipo de usuario ya esta registrado",

      Errors::ERROR_USUARIOTIPOS_UPDATE_EMPTY => "No hay parametros",
      Errors::ERROR_USUARIOTIPOS_UPDATE_EXISTS => "No existe el tipo de usuario",
      Errors::ERROR_USUARIOTIPOS_UPDATE => "Error al editar tipo de usuario",

      Errors::ERROR_USUARIOTIPOS_DELETE_EMPTY => "No hay parametros",
      Errors::ERROR_USUARIOTIPOS_DELETE => "Error al eliminar tipo de usuario",
    ];
  }

  function get($hash)
  {
    return $this->errorList[$hash];
  }

  function existsKey($key)
  {
    return array_key_exists($key, $this->errorList);
  }
}
