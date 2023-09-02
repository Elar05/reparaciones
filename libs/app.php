<?php require_once 'controllers/errores.php';

class App
{
  public function __construct()
  {
    $url = $_GET['url'] ?? '';
    $url = rtrim($url, '/');
    $url = explode('/', $url);

    if (empty($url[0])) $url[0] = 'main';

    $fileController = 'controllers/' . $url[0] . '.php';

    if (file_exists($fileController)) {
      require_once $fileController;

      $controller = new $url[0];
      $controller->loadModel($url[0]);

      // si hay un metodo
      if (isset($url[1])) {
        // validar el metodo
        if (method_exists($controller, $url[1])) {
          // Si hay parametros en la url
          if (isset($url[2])) {
            $nparam = sizeof($url);

            $params = [];

            for ($i = 2; $i < $nparam; $i++) {
              array_push($params, $url[$i]);
            }

            $controller->{$url[1]}($params);
          } else {
            $reflection = new ReflectionMethod("{$url[0]}", "{$url[1]}");
            $parameters = $reflection->getParameters();

            if (count($parameters) > 0 && empty($url[2])) {
              $controller =  new Errores();
            } else {
              $controller->{$url[1]}();
            }
          }
        } else {
          $controller = new Errores();
        }
      } else {
        $controller->render();
      }
    } else {
      $controller = new Errores();
    }
  }
}
