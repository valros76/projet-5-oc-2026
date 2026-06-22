<?php
class HttpRequest
{
  private $url;
  private $method;
  private $params;
  private $route;

  public function __construct($url = null, $method = null)
  {
    $this->url = (is_null($url)) ? $_SERVER['REQUEST_URI'] : $url;
    $this->method = (is_null($method)) ? $_SERVER['REQUEST_METHOD'] : $method;
    $this->params = [];
  }

  public function getUrl()
  {
    return $this->url;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function addParam($value)
  {
    $this->params[] = $value;
  }

  public function getRoute()
  {
    return $this->route;
  }

  public function setRoute($route)
  {
    $this->route = $route;
  }

  public function bindParam()
  {
    switch ($this->method) {
      case "GET":
        // if(preg_match("#" . $this->route->path . "#",$this->url,$matches))
        // {
        // 	for($i=1;$i<count($matches)-1;$i++)
        // 	{
        // 		$this->params[] = $matches[$i];	
        // 	}
        // }
        foreach ($this->route->getParams() as $param) {
          if (isset($_GET[$param])) {
            $this->params[] = $_GET[$param];
          }
        }
        break;
      case "POST":
      case "PUT":
        case "DELETE":
        foreach($this->route->getParams() as $param)
        {
          $this->params[] = file_get_contents("php://input");
          // if(isset($_POST[$param]))
          // {
          //   $this->params[] = $_POST[$param];
          // }
        }
        // foreach($this->route->getParams() as $param)
        // {
        // 	$this->params[] = $param;
        // }
        break;
    }
  }

  public function run($config)
  {
    $this->bindParam();
    $this->route->run($this, $config);
  }
}
