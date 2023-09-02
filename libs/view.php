<?php

class View
{
  public $d;

  public function render($name, $data = [])
  {
    $this->d = $data;
    $this->handleMessages();
    require_once "views/{$name}.php";
  }

  public function handleMessages()
  {
    if (isset($_GET['success']) && isset($_GET['error'])) {
      // No se hace nada
    } else if (isset($_GET['success'])) {
      $this->handleSuccess();
    } else if (isset($_GET['error'])) {
      $this->handleError();
    }
  }

  public function handleSuccess()
  {
    if (isset($_GET['success'])) {
      $hash = $_GET['success'];
      $success = new Success();

      if ($success->existsKey($hash)) {
        $this->d['success'] = $success->get($hash);
      } else {
        $this->d['success'] = null;
      }
    }
  }

  public function handleError()
  {
    if (isset($_GET['error'])) {
      $hash = $_GET['error'];
      $error = new Errors();

      if ($error->existsKey($hash)) {
        $this->d['error'] = $error->get($hash);
      } else {
        $this->d['error'] = null;
        // unset($this->d['error']);
      }
    }
  }

  public function showMessages()
  {
    $this->showSuccess();
    $this->showError();
  }

  public function showSuccess()
  {
    if (array_key_exists('success', $this->d)) {
      echo "<div class='alert alert-success'>{$this->d['success']}</div>";
    }
  }

  public function showError()
  {
    if (array_key_exists('error', $this->d)) {
      echo "<div class='alert alert-danger'>{$this->d['error']}</div>";
    }
  }
}
