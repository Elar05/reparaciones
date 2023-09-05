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
      return;
    }

    $tipo = trim($_POST['tipo']);

    // Validar que existencia
    if ($this->model->get($tipo, "tipo")) {
      $this->redirect('usuariotipos/create', [
        "error" => Errors::ERROR_USUARIOTIPOS_SAVE_EXISTS
      ]);
      return;
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

  public function edit($params)
  {
    if (!isset($params)) {
      $this->redirect('usuariotipos', [
        "error" => Errors::ERROR_USUARIOTIPOS_UPDATE_EMPTY
      ]);
    }

    $id = $params[0];

    $tipo = $this->model->get($id);

    if (empty($tipo)) {
      $this->redirect('usuariotipos', [
        "error" => Errors::ERROR_USUARIOTIPOS_UPDATE_EXISTS
      ]);
    }

    $this->view->render('usuariotipos/edit', ["tipo" => $tipo]);
  }

  public function update()
  {
    if (empty($_POST['id']) || empty($_POST['tipo'])) {
      $this->redirect('usuariotipos', [
        "error" => Errors::ERROR_USUARIOTIPOS_UPDATE_EMPTY
      ]);
      return;
    }

    if ($this->model->update($_POST['id'], $_POST['tipo'])) {
      $this->redirect('usuariotipos', [
        "success" => Success::SUCCESS_USUARIOTIPOS_UPDATE
      ]);
    } else {
      $this->redirect('usuariotipos', [
        "error" => Errors::ERROR_USUARIOTIPOS_UPDATE
      ]);
    }
  }

  public function delete()
  {
    if (empty($_GET['id'])) {
      $this->redirect('usuariotipos', [
        "error" => Errors::ERROR_USUARIOTIPOS_DELETE_EMPTY
      ]);
      return;
    }

    if ($this->model->delete($_GET['id'])) {
      $this->redirect('usuariotipos', [
        "success" => Success::SUCCESS_USUARIOTIPOS_DELETE
      ]);
    } else {
      $this->redirect('usuariotipos', [
        "error" => Errors::ERROR_USUARIOTIPOS_DELETE
      ]);
    }
  }
}
