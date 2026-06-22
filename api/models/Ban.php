<?php
class Ban{
   private static int $id;
   private static string $email;
   private static string $ban_date;
   private static $bdd;

   public function __construct($bdd = null){
      if(!is_null($bdd)){
         self::setBdd($bdd);
      }
   }

   public static function getId(): int{
      return self::$id;
   }

   public static function setId(int $id){
      self::$id = $id;
   }

   public static function getEmail(): string{
      return self::$email;
   }

   public static function setEmail(string $email){
      self::$email = $email;
   }

   public static function getBanDate(): string{
      return self::$ban_date;
   }

   public static function setBanDate(string $ban_date){
      self::$ban_date = $ban_date;
   }

   public static function add(string $email): bool{
      $req = self::$bdd->prepare("INSERT INTO bans(id, email, ban_date) VALUES(:id, :email, NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function deleteAll(): bool{
      return (bool) self::$bdd->exec("DELETE FROM bans");
   }

   public static function deleteById(int $id): bool{
      return (bool) self::$bdd->exec("DELETE FROM bans WHERE id=$id");
   }

   public static function deleteByEmail(string $email): bool{
      return (bool) self::$bdd->exec("DELETE FROM bans WHERE email=$email");
   }

   public static function getList(): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM bans");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByBanDate(string $ban_date): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM bans WHERE ban_date=:ban_date");
      $req->bindValue(":ban_date", $ban_date, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getById(int $id): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM bans WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getByEmail(string $email): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM bans WHERE email=:email");
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function update(int $id, string $email): bool{
      $req = self::$bdd->prepare("UPDATE bans SET email=:email WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateEmail(int $id, string $email): bool{
      $req = self::$bdd->prepare("UPDATE bans SET email=:email WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateBanDate(int $id, string $ban_date): bool{
      $req = self::$bdd->prepare("UPDATE bans SET ban_date=:ban_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":ban_date", $ban_date, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function verifyBannedList(string $email): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM bans WHERE email = :email");
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      $req->execute();
      $isBanned = (bool) $req->fetchColumn();
      $req->closeCursor();
      return $isBanned;
   }

   private static function setBdd($bdd){
      self::$bdd = $bdd;
   }
}