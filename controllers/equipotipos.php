<?php

class EquipoTipos extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function render()
  {
    $this->view->render('equipotipos/index', [
      "tipos" => $this->model->getAll()
    ]);
  }

  public function create()
  {
    $this->view->render('equipotipos/form', [
      "action" => "save"
    ]);
  }

  public function save()
  {
    if (empty($_POST['tipo'])) {
      $this->redirect('equipotipos/create', [
        "error" => Errors::ERROR_EQUIPOTIPOS_SAVE_EMPTY
      ]);
    }

    // Valida existencia
    $tipo = $_POST['tipo'];

    if ($this->model->get($tipo, 'tipo')) {
      $this->redirect('equipotipos/create', [
        "error" => Errors::ERROR_EQUIPOTIPOS_SAVE_EXISTS
      ]);
    }

    // Guardamos
    if ($this->model->save($tipo)) {
      $this->redirect('equipotipos/create', [
        "success" => Success::SUCCESS_EQUIPOTIPOS_SAVE
      ]);
    } else {
      $this->redirect('equipotipos/create', [
        "error" => Errors::ERROR_EQUIPOTIPOS_SAVE
      ]);
    }
  }

  public function edit($params)
  {
    if (!isset($params)) {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_UPDATE_EMPTY
      ]);
    }

    $id = $params[0];

    $tipo = $this->model->get($id);

    if (empty($tipo)) {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_UPDATE_EXISTS
      ]);
    }

    $this->view->render('equipotipos/form', ["action" => "update", "tipo" => $tipo]);
  }

  public function update()
  {
    if (empty($_POST['tipo']) || empty($_POST['id'])) {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_UPDATE_EMPTY
      ]);
    }

    // Valida existencia
    $tipo = $_POST['tipo'];
    if ($this->model->get($tipo, 'tipo')) {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_UPDATE_EXISTS
      ]);
    }

    // Guardamos
    if ($this->model->update($tipo, $_POST['id'])) {
      $this->redirect('equipotipos', [
        "success" => Success::SUCCESS_EQUIPOTIPOS_UPDATE
      ]);
    } else {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_UPDATE
      ]);
    }
  }

  public function delete()
  {
    if (empty($_GET['id'])) {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_DELETE_EMPTY
      ]);
    }

    if ($this->model->delete($_GET['id'])) {
      $this->redirect('equipotipos', [
        "success" => Success::SUCCESS_EQUIPOTIPOS_DELETE
      ]);
    } else {
      $this->redirect('equipotipos', [
        "error" => Errors::ERROR_EQUIPOTIPOS_DELETE
      ]);
    }
  }
}
