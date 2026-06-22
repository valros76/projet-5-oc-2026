<?php
class Newsletter{
   private static int $id;
   private static string $email;
   private static string $inscription_date;
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

   public static function getInscriptionDate(): string{
      return self::$inscription_date;
   }

   public static function setInscriptionDate(string $inscription_date){
      self::$inscription_date = $inscription_date;
   }

   public static function add(string $email): bool{
      $req = self::$bdd->prepare("INSERT INTO newsletter(id, email, inscription_date) VALUES(:id, :email, NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function deleteAll(){
      return self::$bdd->exec("DELETE FROM newsletter");
   }

   public static function deleteById(int $id){
      return self::$bdd->exec("DELETE FROM newsletter WHERE id = $id");
   }

   public static function deleteByEmail(string $email){
      return self::$bdd->exec("DELETE FROM newsletter WHERE email = $email");
   }

   public static function getList(): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM newsletter ORDER BY inscription_date DESC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByIdOrder(): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM newsletter ORDER BY id ASC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByInscriptionDate(string $inscription_date): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM newsletter WHERE inscription_date=:inscription_date ORDER BY email ASC");
      $req->bindValue(":inscription_date", $inscription_date, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getById(int $id){
      $req = self::$bdd->prepare("SELECT * FROM newsletter WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getByEmail(string $email){
      $req = self::$bdd->prepare("SELECT * FROM newsletter WHERE email=:email");
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
      $req = self::$bdd->prepare("UPDATE newsletter SET email=:email WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateEmail(int $id, string $email): bool{
      $req = self::$bdd->prepare("UPDATE newsletter SET email=:email WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateInscriptionDate(int $id, string $inscription_date): bool{
      $req = self::$bdd->prepare("UPDATE newsletter SET inscription_date=:inscription_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":inscription_date", $inscription_date, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function exists(string $email){
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM newsletter WHERE email=:email");
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      return $exists;
   }

   private static function setBdd($bdd){
      self::$bdd = $bdd;
   }
}