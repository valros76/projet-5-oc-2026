<?php

class Server
{
   public static function getInfos()
   {
      foreach ($_SERVER as $value => $param) {
         echo "<p>$value : $param</p>";
      }
   }
}
