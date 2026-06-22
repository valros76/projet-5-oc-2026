<?php
class ZeroDividerException extends Exception
{
  public function __construct($message = "On ne peut pas diviser par 0 !")
  {
    parent::__construct($message, "0001");
  }

  function verifyDivisionException($divider, $divisor)
  {
    if ($divisor == 0) {
      throw new ZeroDividerException();
    }
    return $divider / $divisor;
  }
}
