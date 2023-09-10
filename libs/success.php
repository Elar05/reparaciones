<?php

class Success
{
  // Success_controller_method - operation

  const SUCCESS_USUARIOTIPOS_SAVE     = "alasdf98a9sdf78";
  const SUCCESS_USUARIOTIPOS_UPDATE   = "alasd43dsf98a9sdf";
  const SUCCESS_USUARIOTIPOS_DELETE   = "sd78sd78sd787ds";

  const SUCCESS_EQUIPOTIPOS_SAVE      = "bcs767f45dfsd24ta";
  const SUCCESS_EQUIPOTIPOS_UPDATE    = "bcv87s87sd98gk2lk";
  const SUCCESS_EQUIPOTIPOS_DELETE    = "9sd3487ds87eesdu7";

  private $successList = [];

  public function __construct()
  {
    $this->successList = [
      Success::SUCCESS_USUARIOTIPOS_SAVE    => "Tipo de usuario creado correctamente",
      Success::SUCCESS_USUARIOTIPOS_UPDATE  => "Tipo de usuario editado correctamente",
      Success::SUCCESS_USUARIOTIPOS_DELETE  => "Tipo de usuario eliminado correctamente",

      Success::SUCCESS_EQUIPOTIPOS_SAVE     => "Tipo de equipo creado correctamente",
      Success::SUCCESS_EQUIPOTIPOS_UPDATE   => "Tipo de equipo actualizado correctamente",
      Success::SUCCESS_EQUIPOTIPOS_DELETE   => "Tipo de equipo eliminado correctamente",
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
