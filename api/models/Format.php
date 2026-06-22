<?php
class Format
{
   public static function formatTextareaContent(string $content): string
   {
      $explodedContent = explode("<br />", nl2br($content));
      $formattedContent = "";
      foreach ($explodedContent as $key => $value) {
         if (empty(trim($value))) {
            unset($explodedContent[$key]);
         }
         $formattedContent .= !empty(trim($value)) ? "<p>$value</p>" : null;
      }
      return $formattedContent;
   }

   public static function formatDatetime(string $datetime, string $format)
   {
      switch ($format) {
         case "H:i":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("H:i");
            break;
         case "H:i:s":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("H:i:s");
            break;
         case "d-m-Y":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d-m-Y");
            break;
         case "d/m/Y":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d/m/Y");
            break;
         case "Y/m/d":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("Y/m/d");
            break;
         case "Y-m-d":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("Y-m-d");
            break;
         case "d/m/Y à H:i":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d/m/Y à H:i");
            break;
         case "d-m-Y à H:i":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d-m-Y à H:i");
            break;
         case "d/m/Y à H:i:s":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d/m/Y à H:i:s");
            break;
         case "d-m-Y à H:i:s":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d-m-Y à H:i:s");
            break;
         case "d/m/Y H:i:s":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d/m/Y H:i:s");
            break;
         case "d-m-Y H:i:s":
            $datetime = new Datetime($datetime);
            $datetime = $datetime->format("d-m-Y H:i:s");
            break;
         default:
            break;
      }
      return $datetime;
   }

   public static function addDaysAtDate(string $datetime, string $nbOfDays, string $format = "Y-m-d H:i:s")
   {
      $newDate = new Datetime($datetime);
      $newDate->add(new DateInterval("P" . $nbOfDays . "D"));
      return $newDate->format($format);
   }

   public static function formatFilename(string $filename)
   {
      $filename = trim($filename);
      $filename = mb_strtolower($filename);
      $filename = str_replace(" ", "-", $filename);
      if (preg_match('/[áàâäãå]/i', $filename) != false) {
         $aArray = ["á", "à", "â", "ä", "ã", "å"];
         $filename = str_replace($aArray, "a", $filename);
      }
      if (preg_match('/[ç]/i', $filename) != false) {
         $filename = str_replace("ç", "c", $filename);
      }

      if (preg_match('/[éèêë]/i', $filename) != false) {
         $eArray = ["é", "è", "ê", "ë"];
         $filename = str_replace($eArray, "e", $filename);
      }

      if (preg_match('/[íìîï]/i', $filename) != false) {
         $iArray = ["í", "ì", "î", "ï"];
         $filename = str_replace($iArray, "i", $filename);
      }

      if (preg_match('/[ñ]/i', $filename) != false) {
         $filename = str_replace("ñ", "n", $filename);
      }

      if (preg_match('/[óòôöõ]/i', $filename) != false) {
         $oArray = ["ó", "ò", "ô", "ö", "õ"];
         $filename = str_replace($oArray, "o", $filename);
      }

      if (preg_match('/[úùûü]/i', $filename) != false) {
         $uArray = ["ú", "ù", "û", "ü"];
         $filename = str_replace($uArray, "u", $filename);
      }

      if (preg_match('/[ýÿ]/i', $filename) != false) {
         $yArray = ["ý", "ÿ"];
         $filename = str_replace($yArray, "y", $filename);
      }

      if (preg_match('/[\,\;\#\@\^\'\~\(\)\{\}\[\]\|\`\$\!\?\:\/\.\*\+\"\²\=\¤\%\€]/i', $filename) != false) {
         $symbolsArray = [",", ";", "#", "@", "^", "'", "~", "(", ")", "{", "}", "[", "]", "|", "`", "$", "!", "?", ":", "/", ".", "*", "+", "\"", "²", "=", "¤", "%", "€"];
         $filename = str_replace($symbolsArray, "", $filename);
      }

      return $filename;
   }

   public static function changeEmailInPseudo(string $email)
   {
      $pseudo = mb_strtolower($email);
      $pseudo = preg_replace('/(@[\w\W]*)/i', "", $pseudo);
      $pseudo = str_replace(".", " ", $pseudo);
      $pseudo = str_replace("-", " ", $pseudo);
      $pseudo = str_replace("_", " ", $pseudo);
      $formatPseudo = explode(" ", $pseudo);
      foreach ($formatPseudo as $index => $pseudo_part) {
         $formatPseudo[$index] = ucfirst($pseudo_part);
      }
      $pseudo = implode("", $formatPseudo);
      return $pseudo;
   }

   public static function generateTemporaryPassword(int $length = 12)
   {
      if ($length >= 70) {
         $length = 70;
      } else if ($length <= 0) {
         $length = 12;
      }
      $combinations = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-._@?!:#";
      $shuffle_temporary_password = str_shuffle($combinations);
      $temporary_password = substr($shuffle_temporary_password, 0, $length);
      return $temporary_password;
   }
}
