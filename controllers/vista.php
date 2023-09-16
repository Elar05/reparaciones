<?php

class Vista extends Session
{
  public function __construct($url)
  {
    parent::__construct($url);
  }

  public function render()
  {
    $this->view->render("vista/index", ["vistas" => $this->model->getAll()]);
  }

  public function create()
  {
    $this->view->render("vista/form", ["action" => "save"]);
  }

  public function save()
  {
    if (!isset($_POST['vista']) || empty($_POST['vista'])) {
      $this->redirect('vista/create', [
        "error" => Errors::ERROR_VISTA_SAVE_EMPTY
      ]);
    }

    $vista = $_POST['vista'];

    if ($this->model->get($vista, 'vista')) {
      $this->redirect('vista/create', [
        "error" => Errors::ERROR_VISTA_SAVE_EXISTS
      ]);
    }

    if ($this->model->save($vista)) {
      $this->redirect('vista/create', [
        "success" => Success::SUCCESS_VISTA_SAVE
      ]);
    } else {
      $this->redirect('vista/create', [
        "error" => Errors::ERROR_VISTA_SAVE
      ]);
    }
  }

  public function edit($params)
  {
    if (!isset($params)) {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_UPDATE_EMPTY
      ]);
    }

    $id = $params[0];

    $vista = $this->model->get($id);

    if (empty($vista)) {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_UPDATE_EXISTS
      ]);
    }

    $this->view->render(
      "vista/form",
      ["action" => "update", "vista" => $vista]
    );
  }

  public function update()
  {
    if (
      !preg_match("/^[a-zA-Z]+$/", $_POST['vista']) ||
      !preg_match("/^[0-9]+$/", $_POST['id'])
    ) {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_DATA_INCORRECT
      ]);
    }

    if (empty($_POST['id']) || empty($_POST['vista'])) {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_UPDATE_EMPTY
      ]);
    }

    if ($this->model->update(trim($_POST['vista']), $_POST['id'])) {
      $this->redirect('vista', [
        "success" => Success::SUCCESS_VISTA_UPDATE
      ]);
    } else {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_UPDATE
      ]);
    }
  }

  public function delete()
  {
    if (empty($_GET['id'])) {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_DELETE_EMPTY
      ]);
    }

    if ($this->model->delete($_GET['id'])) {
      $this->redirect('vista', [
        "success" => Success::SUCCESS_VISTA_DELETE
      ]);
    } else {
      $this->redirect('vista', [
        "error" => Errors::ERROR_VISTA_DELETE
      ]);
    }
  }
}
