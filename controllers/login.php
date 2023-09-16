<?php

class Login extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render("login/index");
  }

  public function auth()
  {
    if (
      !isset($_POST['email']) || !isset($_POST['password']) ||
      empty($_POST['email']) || empty($_POST['password'])
    ) {
      $this->redirect("", ["error" => Errors::ERROR_LOGIN_AUTHENTICATE_EMPTY]);
    }

    $user = $this->model->login($_POST['email'], $_POST['password']);

    if ($user === 0) $this->redirect("", ["error" => Errors::ERROR_LOGIN_AUTHENTICATE_STATUS]);

    if ($user !== NULL) {
      $this->initialize($user);
    } else {
      $this->redirect("", ["error" => Errors::ERROR_LOGIN_AUTHENTICATE_DATA]);
    }
  }
}
