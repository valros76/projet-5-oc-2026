<?php
class MultipleRoutesFoundException extends Exception{
  public function __construct($message = "Multiples routes trouvées.")
  {
    parent::__construct($message, "0002");
  }
}