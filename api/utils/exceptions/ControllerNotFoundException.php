<?php
class ControllerNotFoundException extends Exception{
  public function __construct($message = "Le contrôleur demandée n'a pas été trouvée.")
  {
    parent::__construct($message, "0006");
  }
}