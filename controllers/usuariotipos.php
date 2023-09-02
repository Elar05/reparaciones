<?php

class UsuarioTipos extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function render()
  {
    $this->view->render('usuariotipos/index', [
      "tipos" => $this->model->getAll()
    ]);
  }

  public function create()
  {
    $this->view->render('usuariotipos/create');
  }

  public function save()
  {
    // Validar que no este vacio
    if (empty($_POST['tipo'])) {
      $this->redirect('usuariotipos/create', [
        "error" => Errors::ERROR_USUARIOTIPOS_SAVE_EMPTY
      ]);
    }

    $tipo = trim($_POST['tipo']);

    // Validar que existencia
    if ($this->model->get($tipo, "tipo")) {
      $this->redirect('usuariotipos/create', [
        "error" => Errors::ERROR_USUARIOTIPOS_SAVE_EMPTY
      ]);
    }

    // Guardar
    if ($this->model->save($tipo)) {
      $this->redirect('usuariotipos/create', [
        "success" => Success::SUCCESS_USUARIOTIPOS_SAVE
      ]);
    } else {
      $this->redirect('usuariotipos/create', [
        "error" => Errors::ERROR_USUARIOTIPOS_SAVE
      ]);
    }
  }
}
