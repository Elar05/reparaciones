<?php

class Logout extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->logout();
    $this->redirect("");
  }
}
