<?php

class Success
{
  // Success_controller_method - operation

  const SUCCESS_USUARIOTIPOS_SAVE = "alasdf98a9sdf78";
  const SUCCESS_USUARIOTIPOS_UPDATE = "alasd43dsf98a9sdf";
  const SUCCESS_USUARIOTIPOS_DELETE = "sd78sd78sd787ds";

  private $successList = [];

  public function __construct()
  {
    $this->successList = [
      Success::SUCCESS_USUARIOTIPOS_SAVE => "Tipo de usuario creado correctamente",
      Success::SUCCESS_USUARIOTIPOS_UPDATE => "Tipo de usuario editado correctamente",
      Success::SUCCESS_USUARIOTIPOS_DELETE => "Tipo de usuario eliminado correctamente",
    ];
  }

  function get($hash)
  {
    return $this->successList[$hash];
  }

  function existsKey($key)
  {
    return array_key_exists($key, $this->successList);
  }
}
