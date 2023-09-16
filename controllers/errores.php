<?php

class Errores extends Controller
{
  public $view;

  public function __construct()
  {
    parent::__construct();
    $this->view->render('errores/index');
    exit;
  }
}
