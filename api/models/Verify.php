<?php

class Verify
{

   public static function cleanString(string $string): string
   {
      $string = trim($string);
      $string = preg_replace('/\t+/', ' ', $string);
      $string = preg_replace('/[^A-Za-z0-9\/\'\-\.\_\@\%\?\!\:\à\é\è\É\À\È\Ê\Ç\ê\â\ô\û\ê\î\ä\ö\ü\ï\ù\s\ç]/', '', $string); // Removes special chars, but not "." && "-"

      return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
   }

   public static function cleanInputString(string $string, bool $with_hyphens = false): string
   {
      $string = trim($string);
      $string = preg_replace('/[^A-Za-z0-9\/\'\-\.\_\@\%\?\!\:\à\é\è\É\À\È\Ê\Ç\ê\â\ô\û\ê\î\ä\ö\ü\ï\ù\s\ç]/i', '', $string); // Removes special chars, but not "." && "-" && "_" && "@" && "?" && "!" && ":".
      if($with_hyphens === false){
         $string = str_replace(' ', ' ', $string);
         return $string;
      }
      $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
      return preg_replace('/-+/i', '-', $string); // Replaces multiple hyphens with single one.
   }

   public static function cleanInputTextarea(string $textarea): string
   {
      $textarea = trim($textarea);
      $textarea = preg_replace('/[^A-Za-z0-9\/\'\-\.\_\@\%\?\!\:\s\r\n\à\é\è\É\À\È\Ê\Ç\ê\â\ô\û\ê\î\ä\ö\ü\ï\ç]/i', '', $textarea); // Removes special chars, but not "." && "-" && "_" && "@" && "?" && "!" && ":".

      return preg_replace('/-+/i', '-', $textarea); // Replaces multiple hyphens with single one.
   }

   public static function cleanHtmlMailMessage(string $message){
      $message = trim($message);
      $message = htmlentities($message);
      return $message;
   }

   public static function cleanInputNumeric(string|int $value): int
   {
      $value = trim($value);
      $value = preg_replace('/[^0-9]/i', '', $value);
      return intval($value, 10);
   }

   public static function cleanPassword(string $password): ?string
   {
      $password = trim($password);
      $password = preg_replace('/[^A-Za-z0-9\-\.\_\@\?\!\:\#\ç]/i', '', $password);

      return $password;
   }

   public static function cleanEmail(string $email): string
   {
      $email = trim($email);
      $email = preg_replace('/[^A-Za-z0-9\-\.\_\@]/i', '', $email);
      return $email;
   }

   public static function validateEmail(string $email): bool
   {
      /**
       * Can use this regex too : /[a-zA-Z0-9\.]+[@][a-zA-Z0-9]+[\.][a-zA-Z]+/
       */
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return false;
      }
      return true;
   }

   public static function validateUrl(string $url): bool
   {
      if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
         return false;
      }
      return true;
   }

   public static function showAutorizedSymbols(): string
   {
      return "- . _ @ ? ! : # (caractères spéciaux autorisés)";
   }
}
