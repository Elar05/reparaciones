<?php

class Main extends Session
{
  public $model;
  public $view;

  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render('main/index');
  }
}
