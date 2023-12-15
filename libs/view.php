<?php

class View
{
  public $d;
  public $data;

  public function __construct($data = [])
  {
    $this->data = $data;
  }

  public function render($name, $data = [])
  {
    $this->d = $data;
    $this->handleMessages();
    require_once "views/{$name}.php";
  }

  public function handleMessages()
  {
    if (isset($_GET['success']) && isset($_GET['error'])) {
      // no se muestra nada porque no puede haber un error y success al mismo tiempo
    } elseif (isset($_GET['success'])) {
      $this->handleSuccess();
    } elseif (isset($_GET['error'])) {
      $this->handleError();
    } elseif (isset($_GET['message'])) {
      $this->handleMessage();
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

  public function handleMessage()
  {
    if (isset($_GET['message'])) {
      $this->d['message'] = $_GET['message'];
    }
  }

  public function showMessages()
  {
    $this->showSuccess();
    $this->showError();
    $this->showMessage();
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

  public function showMessage()
  {
    if (array_key_exists('message', $this->d)) {
      echo "<div class='alert alert-info alert-dismissible show fade'>
        <div class='alert-body'>
          <button class='close' data-dismiss='alert'>
            <span>&times;</span>
          </button>
          {$this->decrypt($this->d['message'])}
        </div>
      </div>";
    }
  }

  public function decrypt($value)
  {
    return base64_decode($value);
  }
}
