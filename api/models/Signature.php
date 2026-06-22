<?php
class Signature{
   private static int $id;
   private static int $petition_id;
   private static string $firstname;
   private static string $lastname;
   private static string $email;
   // Ajout Prévisionnel : varchar(80)
   private static string $postal_code;
   private static string $city;
   private static string $state;
   // Fin ajout Prévisionnel
   private static string $signature_date;
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

   public static function getPetitionId(): int{
      return self::$petition_id;
   }

   public static function setPetitionId(int $petition_id){
      self::$petition_id = $petition_id;
   }

   public static function getFirstname(): string{
      return self::$firstname;
   }

   public static function setFirstname(string $firstname){
      self::$firstname = $firstname;
   }

   public static function getLastname(): string{
      return self::$lastname;
   }

   public static function setLastname(string $lastname){
      self::$lastname = $lastname;
   }

   public static function getEmail(): string{
      return self::$email;
   }

   public static function setEmail(string $email){
      self::$email = $email;
   }

   public static function getPostalCode(): string{
      return self::$postal_code;
   }

   public static function setPostalCode(string $postal_code){
      self::$postal_code = $postal_code;
   }
   
   public static function getCity(): string{
      return self::$city;
   }

   public static function setCity(string $city){
      self::$city = $city;
   }

   public static function getState(): string{
      return self::$state;
   }

   public static function setState(string $state){
      self::$state = $state;
   }

   public static function getSignatureDate(): string{
      return self::$signature_date;
   }

   public static function setSignatureDate(string $signature_date){
      self::$signature_date = $signature_date;
   }

   public static function add(int $petition_id, string $firstname, string $lastname, string $email): bool{
      $req = self::$bdd->prepare("INSERT INTO signatures(id, petition_id, firstname, lastname, email, signature_date) VALUES(:id, :petition_id, :firstname, :lastname, :email, NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":petition_id", $petition_id, PDO::PARAM_INT);
      $req->bindValue(":firstname", $firstname, PDO::PARAM_STR);
      $req->bindValue(":lastname", $lastname, PDO::PARAM_STR);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function deleteAll(): bool{
      return (bool) self::$bdd->exec("DELETE FROM signatures");
   }

   public static function deleteById(int $id): bool{
      return (bool) self::$bdd->exec("DELETE FROM signatures WHERE id=$id");
   }

   public static function deleteByPetitionId(int $petition_id): bool{
      return (bool) self::$bdd->exec("DELETE FROM signatures WHERE petition_id=$petition_id");
   }

   public static function deleteByEmail(int $email): bool{
      return (bool) self::$bdd->exec("DELETE FROM signatures WHERE email=$email");
   }

   public static function getList(): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByPetitionId(int $petition_id): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE petition_id=:petition_id ORDER BY signature_date DESC");
      $req->bindValue(":petition_id", $petition_id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByEmail(string $email): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE email=:email ORDER BY signature_date DESC");
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getArrayByPetitionId(int $petition_id): array|object|null{
      $req = self::$bdd->prepare("SELECT signature_date, lastname, firstname, email FROM signatures WHERE petition_id=:petition_id ORDER BY signature_date DESC");
      $req->bindValue(":petition_id", $petition_id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_ASSOC);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByPostalCode(string $postal_code): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE postal_code=:postal_code ORDER BY signature_date DESC");
      $req->bindValue(":postal_code", $postal_code, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByCity(string $city): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE city=:city ORDER BY signature_date DESC");
      $req->bindValue(":city", $city, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListByState(string $state): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE state=:state ORDER BY signature_date DESC");
      $req->bindValue(":state", $state, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getListBySignatureDate(string $signature_date): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE signature_date=:signature_date ORDER BY lastname DESC, firstname DESC");
      $req->bindValue(":signature_date", $signature_date, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function getById(int $id): array|object|null{
      $req = self::$bdd->prepare("SELECT * FROM signatures WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!is_null($datas) && !empty($datas)){
         return $datas;
      }
      return null;
   }

   public static function update(int $id, int $petition_id, string $firstname, string $lastname, string $email): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET petition_id=:petition_id, firstname=:firstname, lastname=:lastname, email=:email WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":petition_id", $petition_id, PDO::PARAM_INT);
      $req->bindValue(":firstname", $firstname, PDO::PARAM_STR);
      $req->bindValue(":lastname", $lastname, PDO::PARAM_STR);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updatePetitionId(int $id, int $petition_id): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET petition_id=:petition_id WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":petition_id", $petition_id, PDO::PARAM_INT);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateFirstname(int $id, string $firstname): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET firstname=:firstname WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":firstname", $firstname, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateLastname(int $id, string $lestname): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET lestname=:lestname WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":lestname", $lestname, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateEmail(int $id, string $email): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET email=:email WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":email", $email, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updatePostalCode(int $id, string $postal_code): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET postal_code=:postal_code WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":postal_code", $postal_code, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateCity(int $id, string $city): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET city=:city WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":city", $city, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateState(int $id, string $state): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET state=:state WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":state", $state, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateSignatureDate(int $id, string $signature_date): bool{
      $req = self::$bdd->prepare("UPDATE signatures SET signature_date=:signature_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":signature_date", $signature_date, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function exists(int $petition_id, string $firstname, string $lastname, string $email): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM signatures WHERE petition_id = :petition_id AND firstname = :firstname AND lastname = :lastname AND email = :email");
      $req->bindValue(":petition_id", $petition_id, PDO::PARAM_INT);
      $req->bindValue(":firstname", $firstname, PDO::PARAM_STR);
      $req->bindValue(":lastname", $lastname, PDO::PARAM_STR);
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