<?php
class FileNotFoundException extends Exception{
  public function __construct($message = "Le fichier demandé n'a pas été trouvé.")
  {
    parent::__construct($message, "0003");
  }
}