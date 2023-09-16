<?php

class Errors
{
  // ERROR_controller_method - operation
  const ERROR_LOGIN_AUTHENTICATE_DATA     = "87sd87ds78ds";
  const ERROR_LOGIN_AUTHENTICATE_EMPTY    = "sd8f43h238798ds8998";
  const ERROR_LOGIN_AUTHENTICATE_STATUS   = "sd8f43h238798ds8998";

  const ERROR_USUARIOTIPOS_SAVE           = "8as98fsadfasd6";
  const ERROR_USUARIOTIPOS_SAVE_EMPTY     = "7sd87s45d6ds76";
  const ERROR_USUARIOTIPOS_SAVE_EXISTS    = "7sd87554dffds76";
  const ERROR_USUARIOTIPOS_UPDATE_EMPTY   = "sd87sd87sd87sd78";
  const ERROR_USUARIOTIPOS_UPDATE_EXISTS  = "7sd8sd5s43dfs76";
  const ERROR_USUARIOTIPOS_UPDATE         = "as87a9s8df79as8d7f9";
  const ERROR_USUARIOTIPOS_DELETE_EMPTY   = "sd87sd87sd87sd78ds78";
  const ERROR_USUARIOTIPOS_DELETE         = "sd87er7sd76ds";

  const ERROR_EQUIPOTIPOS_SAVE            = "bcasd35gf68d456df";
  const ERROR_EQUIPOTIPOS_SAVE_EXISTS     = "bas9df8as98f97asd";
  const ERROR_EQUIPOTIPOS_SAVE_EMPTY      = "89s89ds98s8sd98ds";
  const ERROR_EQUIPOTIPOS_UPDATE          = "sd8ds8d8sd8sd8sd8";
  const ERROR_EQUIPOTIPOS_UPDATE_EMPTY    = "jf834jks87dskj48d";
  const ERROR_EQUIPOTIPOS_UPDATE_EXISTS   = "8sdkj4398sdkj29ds";
  const ERROR_EQUIPOTIPOS_DELETE          = "398fkj239dsjksd98";
  const ERROR_EQUIPOTIPOS_DELETE_EMPTY    = "alkf9898ads9adsf9";

  const ERROR_VISTA_SAVE                  = "s99fd9du34jk34kj3";
  const ERROR_VISTA_SAVE_EXISTS           = "d0d0347r75nd7md84";
  const ERROR_VISTA_SAVE_EMPTY            = "72hd54m0cn6sn73n1";
  const ERROR_VISTA_UPDATE                = "qwert7o5i5u5y6t7r";
  const ERROR_VISTA_UPDATE_EMPTY          = "0a9e87y6b5ji4u3gf";
  const ERROR_VISTA_UPDATE_EXISTS         = "jk78gh56fg43fd23a";
  const ERROR_VISTA_DELETE                = "0o9i8u7y6t65re4e3";
  const ERROR_VISTA_DELETE_EMPTY          = "0o9i0o9i0o9i0o9i0";

  const ERROR_VISTA_DATA_INCORRECT        = "7sd87ds87ds87ds78d";

  private $errorList = [];

  public function __construct()
  {
    $this->errorList = [
      Errors::ERROR_LOGIN_AUTHENTICATE_DATA     => "Credenciales incorrectas",
      Errors::ERROR_LOGIN_AUTHENTICATE_EMPTY    => "Rellene el formulario",
      Errors::ERROR_LOGIN_AUTHENTICATE_STATUS   => "El usuario no esta activo",

      Errors::ERROR_USUARIOTIPOS_SAVE           => "Error al guardar tipo de usuario",
      Errors::ERROR_USUARIOTIPOS_SAVE_EMPTY     => "Complete el formulario",
      Errors::ERROR_USUARIOTIPOS_SAVE_EXISTS    => "El tipo de usuario ya esta registrado",
      Errors::ERROR_USUARIOTIPOS_UPDATE_EMPTY   => "No hay parametros",
      Errors::ERROR_USUARIOTIPOS_UPDATE_EXISTS  => "No existe el tipo de usuario",
      Errors::ERROR_USUARIOTIPOS_UPDATE         => "Error al editar tipo de usuario",
      Errors::ERROR_USUARIOTIPOS_DELETE_EMPTY   => "No hay parametros",
      Errors::ERROR_USUARIOTIPOS_DELETE         => "Error al eliminar tipo de usuario",

      Errors::ERROR_EQUIPOTIPOS_SAVE            => 'Error al guardar tipo de equipo',
      Errors::ERROR_EQUIPOTIPOS_SAVE_EXISTS     => 'El tipo de equipo ya existe',
      Errors::ERROR_EQUIPOTIPOS_SAVE_EMPTY      => 'No se puede agregar un tipo de equipo vacio',
      Errors::ERROR_EQUIPOTIPOS_UPDATE          => 'Error al actualizar tipo de equipo',
      Errors::ERROR_EQUIPOTIPOS_UPDATE_EMPTY    => 'No se puede actualizar un tipo de equipo vacio',
      Errors::ERROR_EQUIPOTIPOS_UPDATE_EXISTS   => 'El tipo de equipo ya existe',
      Errors::ERROR_EQUIPOTIPOS_DELETE          => 'Error al eliminar tipo de equipo',
      Errors::ERROR_EQUIPOTIPOS_DELETE_EMPTY    => 'No se puede eliminar un tipo de equipo que no existe',

      Errors::ERROR_VISTA_SAVE                  => 'Error al guardar vista',
      Errors::ERROR_VISTA_SAVE_EXISTS           => 'La vista ya existe',
      Errors::ERROR_VISTA_SAVE_EMPTY            => 'No se puede agregar un vista vacia',
      Errors::ERROR_VISTA_UPDATE                => 'Error al actualizar vista',
      Errors::ERROR_VISTA_UPDATE_EMPTY          => 'No se puede actualizar un vista vacia',
      Errors::ERROR_VISTA_UPDATE_EXISTS         => 'La vista no existe',
      Errors::ERROR_VISTA_DELETE                => 'Error al eliminar vista',
      Errors::ERROR_VISTA_DELETE_EMPTY          => 'No se puede eliminar un vista que no existe',

      Errors::ERROR_VISTA_DATA_INCORRECT        => 'Los valores son incorrectas',
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
