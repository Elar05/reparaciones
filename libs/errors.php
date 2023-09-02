<?php

class Errors
{
  // ERROR_controller_method - operation

  const ERROR_USUARIOTIPOS_SAVE = "8as98fsadfasd6";
  const ERROR_USUARIOTIPOS_SAVE_EMPTY = "7sd87s45d6ds76";
  const ERROR_USUARIOTIPOS_SAVE_EXISTS = "7sd87s45d6ds76";

  private $errorList = [];

  public function __construct()
  {
    $this->errorList = [
      Errors::ERROR_USUARIOTIPOS_SAVE => "Error al guardar tipo de usuario",
      Errors::ERROR_USUARIOTIPOS_SAVE_EMPTY => "Complete el formulario",
      Errors::ERROR_USUARIOTIPOS_SAVE_EXISTS => "El tipo de usuario ya esta registrado",
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
