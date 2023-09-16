<?php

class LoginModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function login($email, $password)
  {
    try {
      $query = $this->prepare("SELECT * FROM usuarios WHERE email = :email;");
      $query->execute([":email" => $email]);

      if ($query->rowCount() == 1) {
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if ($user['estado'] == 1) {
          if (password_verify($password, $user['password'])) {
            return [
              "id" => $user['id'],
              "nombres" => $user['nombres'],
              "idtipo_usuario" => $user['idtipo_usuario']
            ];
          }
          return NULL;
        }
        return 0;
      }
    } catch (PDOException $e) {
      error_log('LoginModel::login() -> ' . $e->getMessage());
      return false;
    }
  }
}
