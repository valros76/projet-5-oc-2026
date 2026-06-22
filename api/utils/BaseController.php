<?php
class BaseController
{
  private $httpRequest;
  private $params;
  private $config;
  private $fileManager;

  public function __construct($httpRequest,$config)
  {
    $this->httpRequest = $httpRequest;
    $this->config = $config;
    $this->params = [];
    $this->addParam("httprequest", $this->httpRequest);
    $this->addParam("config", $this->config);
    $this->bindManager();
    $this->fileManager = new FileManager();
  }

  protected function view($filename)
  {
    if (file_exists("views/{$this->httpRequest->getRoute()->getController()}/css/{$filename}.css")) {
      $this->addCss("views/{$this->httpRequest->getRoute()->getController()}/css/{$filename}.css");
    }
    if (file_exists("views/{$this->httpRequest->getRoute()->getController()}/js/{$filename}.js")) {
      $this->addJs("views/{$this->httpRequest->getRoute()->getController()}/js/{$filename}.js");
    }
    if (!file_exists("views/{$this->httpRequest->getRoute()->getController()}/{$filename}.php")) {
      throw new FileNotFoundException();
    }
    ob_start();
    extract($this->params);
    include_once "views/{$this->httpRequest->getRoute()->getController()}/{$filename}.php";
    $mainContent = ob_get_clean();
    include_once "templates/global_template.php";
  }

  protected function bindManager()
  {
    foreach ($this->httpRequest->getRoute()->getManager() as $manager) {
      $this->$manager = new $manager($this->config->database);
    }
  }

  public function addParam(string $name, $value)
  {
    $this->params[$name] = $value;
  }

  public function addCss($file)
  {
    $this->fileManager->addCss($file);
  }

  public function addJs($file)
  {
    $this->fileManager->addJs($file);
  }
}
