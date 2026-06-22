<?php
class ActionNotFoundException extends Exception{
  public function __construct($message = "L'action demandée n'a pas été trouvée.")
  {
    parent::__construct($message, "0005");
  }
}