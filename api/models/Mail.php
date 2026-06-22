<?php
class Mail
{
   private static string $server_email = "developpeur@webdevoo.com";

   public static function getServerEmail(): string
   {
      return self::$server_email;
   }

   public static function setServerEmail(string $email)
   {
      self::$server_email = $email;
   }

   public static function sendMailSimple(string $from, string $to, string $subject, string $message)
   {
      // Clean passed values
      $from = Verify::cleanInputString($from);
      $to = Verify::cleanInputString($to);
      $subject = Verify::cleanInputString($subject);
      $message = trim($message);

      $htmlMessage = '
         <!DOCTYPE html>
         <html>
            <head>
            <title>
               Contact - Webdevoo
            </title>
            <style>
               *,
               *::before,
               *::after{
                  font-family:sans-serif;
                  line-height:1.5;
                  font-size:1.2em;
               }
               h1{
                  font-size:2em;
               }
               h2{
                  font-size:1.85em;
               }
               h3{
                  font-size:1.75em;
               }
               h4,h5,h6{
                  font-size:1.65em;
               }
               strong{
                  font-size:1.4em;
                  letter-spacing:0.05em;
               }
            </style>
            </head>
            <body>';
      $htmlMessage .= $message;
      $htmlMessage .= '</body>
         </html>
      ';

      $headers = [
         "From" => "<$from>",
         "MIME-Version" => "1.0",
         "Content-Type" => "text/html; charset=utf-8",
      ];

      return (bool) mail($to, $subject, $htmlMessage, $headers);
   }

   public static function sendMailWithAttachment(string $from, string $to, string $subject, string $message, $attachment, string $attachment_filename, $attachment_filetype)
   {
      // Clean passed values
      $from = Verify::cleanInputString($from);
      $to = Verify::cleanInputString($to);
      $subject = Verify::cleanInputString($subject);
      $message = Verify::cleanInputTextarea($message);

      //Verifie si le fournisseur prend en charge les r
      if (preg_match("#@(hotmail|live|msn).[a-z]{2,4}$#", $from)) {
         $passage_ligne = "\n";
      } else {
         $passage_ligne = "\r\n";
      }

      // Pour envoyer un email avec une pièce jointe, il faut une limite de contenu, définie dans $boundary (clé aléatoire).
      $boundary = md5(uniqid(microtime(), TRUE));

      $headers = "From: $from" . $passage_ligne;
      $headers .= "MIME-Version: 1.0" . $passage_ligne;
      $headers .= "Content-Type: multipart/mixed; boundary=" . $boundary . " " . $passage_ligne;
      // Help to avoid spam
      $headers .= "Message-ID: <" . date("Y-m-d H:i:s") . " e-petition@" . $_SERVER["SERVER_NAME"] . ">" . $passage_ligne;
      $headers .= "X-Mailer: PHP v" . phpversion() . $passage_ligne;

      // With message
      $newMessage = "--".$boundary.$passage_ligne;
      $newMessage .= "Content-Type: text/html; charset=utf-8" . $passage_ligne;
      $newMessage .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
      $newMessage .= $passage_ligne.$message.$passage_ligne;
      // $newMessage .= "--" . $boundary . "\n";

      // Ajout de la pièce jointe
      if (file_exists($attachment)) {
         $file_type = $attachment_filetype ?? "text/plain" ?? mime_content_type($attachment);

         $file = fopen($attachment, 'r') or die("Le fichier $attachment ne peut pas être ouvert.");
         $attachment_content = fread($file, filesize($attachment));
         $encoded_content = chunk_split(base64_encode($attachment_content));

         $newMessage .= $passage_ligne."--".$boundary.$passage_ligne;
         $newMessage .= "Content-Type: " . $file_type . ";name=\"".$attachment."\"".$passage_ligne;
         $newMessage .= "Content-Disposition: attachment; filename=\"". $attachment . "\"".$passage_ligne;
         $newMessage .= "Content-Transfer-Encoding: base64".$passage_ligne;
         $newMessage .= $passage_ligne;
         $newMessage .= $encoded_content.$passage_ligne;
         $newMessage .= $passage_ligne."--" . $boundary . "--".$passage_ligne;
         fclose($file);
      }

      // Fin du message
      $message = $newMessage;

      // var_dump($from);
      // echo "<hr/>";
      // var_dump($to);
      // echo "<hr/>";
      // var_dump($headers);
      // echo "<hr/>";
      // var_dump($message);
      // echo "<hr/>";
      // var_dump($attachment);
      // echo "<hr/>";

      return (bool) mail($to, $subject, $message, $headers);
   }
}
