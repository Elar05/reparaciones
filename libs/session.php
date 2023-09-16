<?php

class Session extends Controller
{
  public $sites;
  public $defaultSite;
  public $user;
  public $userId;
  public $userType;
  public $url;

  public function __construct($url)
  {
    // error_log("Session::__construct");
    if (session_status() == PHP_SESSION_NONE) session_start();

    $this->userType = $_SESSION["userType"] ?? 0;
    $this->userId = $_SESSION["userId"] ?? "";
    $this->user = $_SESSION["user"] ?? "";

    $this->url = $url;

    $this->defaultSite = "main";

    $this->sites = $this->sites();

    $this->validateSession();

    parent::__construct();
  }

  public function sites()
  {
    return [
      "0" => ['login'],
      "1" => ['main', 'logout', 'usuario', 'usuariotipos', 'cliente', 'equipo', 'equipotipos', 'reparacion'],
      "2" => ['main', 'logout', 'cliente', 'equipo', 'equipotipos', 'reparacion'],
      "3" => ['main', 'logout', 'equipo', 'equipotipos', 'reparacion']
    ];
  }

  public function validateSession()
  {
    // error_log("Session::validateSession()");
    if ($this->existsSession()) {
      // error_log("Session::existsSession()");
      if ($this->isAuthorized($this->url, $this->userType)) {
      } else {
        $this->redirect($this->defaultSite); # Redirigir a una pagina por defecto si no tiene el permiso para acceder
      }
    } else {
      if ($this->isAuthorized($this->url, $this->userType)) {
      } else {
        // error_log("Session::no existsSession() {$this->url} -> {$this->userType}");
        new Errores;
      }
    }
  }

  public function existsSession()
  {
    return isset($_SESSION["userId"]);
  }

  public function isAuthorized($view, $userType)
  {
    return in_array($view, $this->sites[$userType]);
  }

  public function initialize($user)
  {
    $_SESSION["userId"] = $user["id"];
    $_SESSION["userType"] = $user["idtipo_usuario"];
    $_SESSION["user"] = $user["nombres"];

    $this->redirect($this->defaultSite);
  }

  public function logout()
  {
    session_unset();
    session_destroy();
  }
}
