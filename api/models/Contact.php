<?php
class Contact{
   private static int $id;
   private static string $message_from;
   private static string $message_to;
   private static string $subject;
   private static string $content;
   private static string $creation_date;
   private static $bdd;

   private static $server_mail = "developpeur@webdevoo.com";
   // private static $server_mail = "webdevoo.pro@gmail.com";

   public function __construct($bdd = null)
   {
      if (!is_null($bdd)) {
         self::setBdd($bdd);
      }
   }

   public static function getId(): int{
      return self::$id;
   }

   public static function setId(int $id){
      self::$id = $id;
   }

   public static function getMessageFrom(): string{
      return self::$message_from;
   }

   public static function setMessageFrom(string $message_from){
      self::$message_from = $message_from;
   }

   public static function getMessageTo(): string{
      return self::$message_to;
   }

   public static function setMessageTo(string $message_to){
      self::$message_to = $message_to;
   }

   public static function getSubject(): string{
      return self::$subject;
   }

   public static function setSubject(string $subject){
      self::$subject = $subject;
   }

   public static function getContent(): string{
      return self::$content;
   }

   public static function setContent(string $content){
      self::$content = $content;
   }

   public static function getCreationDate(): string{
      return self::$creation_date;
   }

   public static function setCreationDate(string $creation_date){
      self::$creation_date = $creation_date;
   }

   public static function getServerMail(): string{
      return self::$server_mail;
   }

   public static function setServerMail(string $server_mail){
      self::$server_mail = $server_mail;
   }

   public static function add(string $message_from, string $message_to, string $subject, string $content){
      $req = self::$bdd->prepare("INSERT INTO sav(id, message_from, message_to, subject, content, creation_date) VALUES(:id, :message_from, :message_to, :subject, :content, NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":message_from", $message_from, PDO::PARAM_STR);
      $req->bindValue(":message_to", $message_to, PDO::PARAM_STR);
      $req->bindValue(":subject", $subject, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function deleteAll(){
      return self::$bdd->exec("DELETE FROM sav");
   }

   public static function deleteById(int $id){
      return self::$bdd->exec("DELETE FROM sav WHERE id=$id");
   }

   public static function getList(): ?object{
      $req = self::$bdd->prepare("SELECT id, message_from, message_to, subject, content, creation_date FROM sav");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getListByMessageFrom(string $message_from): ?object{
      $req = self::$bdd->prepare("SELECT id, message_from, message_to, subject, content, creation_date FROM sav WHERE message_from=:message_from");
      $req->bindValue(":message_from", $message_from, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getListByMessageTo(string $message_to): ?object{
      $req = self::$bdd->prepare("SELECT id, message_from, message_to, subject, content, creation_date FROM sav WHERE message_to=:message_to");
      $req->bindValue(":message_to", $message_to, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getListByCreationDate(string $creation_date): ?object{
      $req = self::$bdd->prepare("SELECT id, message_from, message_to, subject, content, creation_date FROM sav WHERE creation_date=:creation_date ORDER BY creation_date DESC");
      $req->bindValue(":creation_date", $creation_date, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getById(int $id): ?object{
      $req = self::$bdd->prepare("SELECT id, message_from, message_to, subject, content, creation_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getBySubject(int $subject): ?object{
      $req = self::$bdd->prepare("SELECT id, message_from, message_to, subject, content, creation_date WHERE subject=:subject");
      $req->bindValue(":subject", $subject, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function update(int $id, string $message_from, string $message_to, string $subject, string $content): bool{
      $req = self::$bdd->prepare("UPDATE sav SET message_from=:message_from, message_to=:message_to, subject=:subject, content=:content WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":message_from", $message_from, PDO::PARAM_STR);
      $req->bindValue(":message_to", $message_to, PDO::PARAM_STR);
      $req->bindValue(":subject", $subject, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateMessageFrom(int $id, string $message_from){
      $req = self::$bdd->prepare("UPDATE sav SET message_from=:message_from WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":message_from", $message_from, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateMessageTo(int $id, string $message_to){
      $req = self::$bdd->prepare("UPDATE sav SET message_to=:message_to WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":message_to", $message_to, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateSubject(int $id, string $subject){
      $req = self::$bdd->prepare("UPDATE sav SET subject=:subject WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":subject", $subject, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateContent(int $id, string $content){
      $req = self::$bdd->prepare("UPDATE sav SET content=:content WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateCreationDate(int $id, string $creation_date){
      $req = self::$bdd->prepare("UPDATE sav SET creation_date=:creation_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":creation_date", $creation_date, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function setBdd($bdd){
      self::$bdd = $bdd;
   }
}