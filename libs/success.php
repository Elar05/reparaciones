<?php

class Success
{
  // Success_controller_method - operation

  const SUCCESS_USUARIOTIPOS_SAVE = "alasdf98a9sdf78";

  private $successList = [];

  public function __construct()
  {
    $this->successList = [
      Success::SUCCESS_USUARIOTIPOS_SAVE => "Tipo de usuario creado correctamente",
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
