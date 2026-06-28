<?php
class Route
{
  private $path;
  private $controller;
  private $action;
  private $method;
  private $params;
  private $manager;
  private $roles;

  public function __construct($route)
  {
    $this->path = $route->path;
    $this->controller = $route->controller;
    $this->action = $route->action;
    $this->method = $route->method;
    $this->params = $route->param ?? $route->params;
    $this->manager = $route->manager;
    $this->roles = $route->roles ?? [];
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getController()
  {
    return $this->controller;
  }

  public function getAction()
  {
    return $this->action;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function getManager()
  {
    return $this->manager;
  }

  public function getRoles()
  {
    return $this->roles;
  }

  public function run($httpRequest, $config)
  {
    if (!empty($this->roles)) {
      $user = $_SESSION['user'] ?? null;

      if (!$user) {
        JSON::response("Accès refusé : Connexion requise.", 401);
        exit();
      }

      if ($this->roles === ["ROLE_ADMIN"] && !$user->is_admin) {
        JSON::response("Accès interdit : Privilèges administrateur requis.", 403);
        exit();
    }

      $currentRole = UserRole::get($user);

      if (!in_array($currentRole->value, $this->roles)) {
        throw new Exception("Accès refusé : Droits insuffisants.");
      }
    }

    $controller = null;
    $controllerName = "{$this->controller}Controller";
    if (class_exists($controllerName)) {
      $controller = new $controllerName($httpRequest, $config);
      if (method_exists($controller, $this->action)) {
        $controller->{$this->action}(...$httpRequest->getParams());
      } else {
        throw new ActionNotFoundException();
      }
    } else {
      var_dump($controllerName);
      throw new ControllerNotFoundException();
    }
  }
}
