<?php
class NoRouteFoundException extends Exception
{
  private $httpRequest;

  public function __construct($httpRequest, $message = "Aucune route n'a été trouvée.")
  {
			$this->httpRequest = $httpRequest;
    parent::__construct($message, "0003");
  }
		
  public function getMoreDetail()
  {
    return "La route '{$this->httpRequest->getUrl()}' n'a pas été trouvée avec une méthode '{$this->httpRequest->getMethod()}'.";
  }
}
