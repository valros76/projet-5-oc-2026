<?php
class Petition
{
   private static int $id;
   private static string $title;
   private static string $content;
   private static string $author;
   private static int $nb_signatures;
   private static int $objectif_signatures;
   private static string $start_date;
   private static string $end_date;
   private static bool $is_validated;
   private static string $update_date;
   private static $bdd;

   public function __construct($bdd = null)
   {
      if (!is_null($bdd)) {
         self::setBdd($bdd);
      }
   }

   public static function getId(): int
   {
      return self::$id;
   }

   public static function setId(int $id)
   {
      self::$id = $id;
   }

   public static function getTitle(): string
   {
      return self::$title;
   }

   public static function setTitle(string $title)
   {
      self::$title = $title;
   }

   public static function getContent(): string
   {
      return self::$content;
   }

   public static function setContent(string $content)
   {
      self::$content = $content;
   }

   public static function getAuthor(): string
   {
      return self::$author;
   }

   public static function setAuthor(string $author)
   {
      self::$author = $author;
   }

   public static function getNbSignatures(): int
   {
      return self::$nb_signatures;
   }

   public static function setNbSignatures(int $nb_signatures)
   {
      self::$nb_signatures = $nb_signatures;
   }

   public static function getObjectifSignatures(): int
   {
      return self::$objectif_signatures;
   }

   public static function setObjectifSignatures(int $objectif_signatures)
   {
      self::$objectif_signatures = $objectif_signatures;
   }

   public static function getStartDate(): string
   {
      return self::$start_date;
   }

   public static function setStartDate(string $start_date)
   {
      self::$start_date = $start_date;
   }

   public static function getEndDate(): string
   {
      return self::$end_date;
   }

   public static function setEndDate(string $end_date)
   {
      self::$end_date = $end_date;
   }

   public static function getIsValidated(): bool
   {
      return self::$is_validated;
   }

   public static function setIsValidated(bool $is_validated)
   {
      self::$is_validated = $is_validated;
   }

   public static function getUpdateDate(): string
   {
      return self::$update_date;
   }

   public static function setUpdateDate(string $update_date)
   {
      self::$update_date = $update_date;
   }

   public static function add(string $title, string $content, string $author, int $nb_signatures, int $objectif_signatures, string $start_date, string $end_date, bool $is_validated = false): bool
   {
      $req = self::$bdd->prepare("INSERT INTO petitions(id, title, content, author, nb_signatures, objectif_signatures, start_date, end_date, is_validated, update_date) VALUES(:id, :title, :content, :author, :nb_signatures, :objectif_signatures, :start_date, :end_date, :is_validated, NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      $req->bindValue(":author", $author, PDO::PARAM_STR);
      $req->bindValue(":nb_signatures", $nb_signatures, PDO::PARAM_INT);
      $req->bindValue(":objectif_signatures", $objectif_signatures, PDO::PARAM_INT);
      $req->bindValue(":start_date", $start_date, PDO::PARAM_STR);
      $req->bindValue(":end_date", $end_date, PDO::PARAM_STR);
      $req->bindValue(":is_validated", $is_validated, PDO::PARAM_BOOL);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function deleteAll()
   {
      return (bool) self::$bdd->exec("DELETE FROM petitions");
   }

   public static function deleteById(int $id)
   {
      return (bool) self::$bdd->exec("DELETE FROM petitions WHERE id=$id");
   }

   public static function countAll(): int|null{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM petitions");
      $req->execute();
      $count = $req->fetchColumn();
      $req->closeCursor();
      if($count != false){
         return $count;
      }
      return 0;
   }

   public static function getList(): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM petitions ORDER BY end_date DESC, update_date DESC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getPartedList(int|null $offset = null, int|null $limit = null): array|object|null
   {
      if(!is_null($offset) && !is_null($limit)){
         $req = self::$bdd->prepare("SELECT * FROM petitions ORDER BY update_date DESC LIMIT :offset, :limit");
         $req->bindValue(":offset", (int) $offset, PDO::PARAM_INT);
         $req->bindValue(":limit", (int) $limit, PDO::PARAM_INT);
      }else{
         $req = self::$bdd->prepare("SELECT * FROM petitions ORDER BY update_date DESC");
      }
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getModerationList(string $filter = null): array|object|null
   {
      switch ($filter) {
         case "not_moderated":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE is_validated = false ORDER BY update_date DESC;");
            break;
         case "newest":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (end_date >= NOW()) ORDER BY update_date DESC;");
            break;
         case "current":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date <= NOW()) AND (end_date >= NOW()) AND is_validated = true ORDER BY update_date DESC;");
            break;
         case "not_started":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date > NOW()) AND is_validated = true ORDER BY update_date DESC;");
            break;
         case "finished":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (end_date <= NOW()) AND is_validated = true ORDER BY update_date DESC");
            break;
         case "all":
         case null:
         default:
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE is_validated = true ORDER BY update_date DESC");
            break;
      }
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getListByAuthor(string|null $author, string $filter = null): array|object|null
   {
      switch ($filter) {
         case "current":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date <= NOW()) AND (end_date >= NOW()) AND author=:author ORDER BY update_date DESC;");
            break;
         case "not_started":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date > NOW()) AND author=:author ORDER BY update_date DESC;");
            break;
         case "finished":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (end_date <= NOW()) AND author=:author ORDER BY update_date DESC");
            break;
         case "not_moderated":
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE is_validated=:is_validated AND author=:author ORDER BY update_date DESC");
            $req->bindValue(":is_validated", (bool) false, PDO::PARAM_BOOL);
            break;
         case "all":
         case null:
         default:
            $req = self::$bdd->prepare("SELECT * FROM petitions WHERE author=:author ORDER BY update_date DESC");
            break;
      }
      $req->bindValue(":author", $author, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getCurrentList(string $author = null): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date <= NOW()) AND (end_date >= NOW()) AND is_validated=true ORDER BY update_date DESC;");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getPartedCurrentList(int|null $offset = null, int|null $limit = null): array|object|null
   {
      if(!is_null($offset) && !is_null($limit)){
         $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date <= NOW()) AND (end_date >= NOW()) AND is_validated=true ORDER BY update_date DESC LIMIT :offset, :limit");
         $req->bindValue(":offset", (int) $offset, PDO::PARAM_INT);
         $req->bindValue(":limit", (int) $limit, PDO::PARAM_INT);
      }else{
         $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date <= NOW()) AND (end_date >= NOW()) AND is_validated=true ORDER BY update_date DESC");
      }
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getNotStartedList(): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date > NOW()) AND is_validated=true ORDER BY update_date DESC;");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getPartedNotStartedList(int|null $offset = null, int|null $limit = null): array|object|null
   {
      if(!is_null($offset) && !is_null($limit)){
         $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date > NOW()) AND is_validated=true ORDER BY update_date DESC LIMIT :offset, :limit");
         $req->bindValue(":offset", (int) $offset, PDO::PARAM_INT);
         $req->bindValue(":limit", (int) $limit, PDO::PARAM_INT);
      }else{
         $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (start_date > NOW()) AND is_validated=true ORDER BY update_date DESC");
      }
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getFinishedList(): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (end_date <= NOW()) AND is_validated=true ORDER BY update_date DESC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getPartedFinishedList(int|null $offset = null, int|null $limit = null): array|object|null
   {
      if(!is_null($offset) && !is_null($limit)){
         $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (end_date <= NOW()) AND is_validated=true ORDER BY update_date DESC LIMIT :offset, :limit");
         $req->bindValue(":offset", (int) $offset, PDO::PARAM_INT);
         $req->bindValue(":limit", (int) $limit, PDO::PARAM_INT);
      }else{
         $req = self::$bdd->prepare("SELECT * FROM petitions WHERE (end_date <= NOW()) AND is_validated=true ORDER BY update_date DESC");
      }
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getById(int $id): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM petitions WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getByInfos(string $title, int $objectif_signatures, string $start_date, string $end_date): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM petitions WHERE title=:title AND objectif_signatures=:objectif_signatures AND start_date=:start_date AND end_date=:end_date ORDER BY id DESC");
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":objectif_signatures", $objectif_signatures, PDO::PARAM_INT);
      $req->bindValue(":start_date", $start_date, PDO::PARAM_STR);
      $req->bindValue(":end_date", $end_date, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function update(int $id, string $title, string $content, string $author, int $nb_signatures, int $objectif_signatures, string $start_date, string $end_date, string $is_validated): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET title=:title, content=:content, author=:author, nb_signatures=:nb_signatures, objectif_signatures=:objectif_signatures, start_date=:start_date, end_date=:end_date, is_validated=:is_validated, update_date=NOW() WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      $req->bindValue(":author", $author, PDO::PARAM_STR);
      $req->bindValue(":nb_signatures", $nb_signatures, PDO::PARAM_INT);
      $req->bindValue(":objectif_signatures", $objectif_signatures, PDO::PARAM_INT);
      $req->bindValue(":start_date", $start_date, PDO::PARAM_STR);
      $req->bindValue(":end_date", $end_date, PDO::PARAM_STR);
      $req->bindValue(":is_validated", $is_validated, PDO::PARAM_BOOL);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateInfos(int $id, string $title, string $content, string $author, int $objectif_signatures, string $start_date, string $end_date, bool $is_validated): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET title=:title, content=:content, author=:author, objectif_signatures=:objectif_signatures, start_date=:start_date, end_date=:end_date, is_validated=:is_validated, update_date=NOW() WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      $req->bindValue(":author", $author, PDO::PARAM_STR);
      $req->bindValue(":objectif_signatures", $objectif_signatures, PDO::PARAM_INT);
      $req->bindValue(":start_date", $start_date, PDO::PARAM_STR);
      $req->bindValue(":end_date", $end_date, PDO::PARAM_STR);
      $req->bindValue(":is_validated", $is_validated, PDO::PARAM_BOOL);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateTitle(int $id, string $title): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET title=:title WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateContent(int $id, string $content): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET content=:content WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateAuthor(int $id, string $author): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET author=:author WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":author", $author, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateListByAuthor(string $old_author, string $new_author): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET author=:new_author WHERE author=:old_author");
      $req->bindValue(":old_author", $old_author, PDO::PARAM_STR);
      $req->bindValue(":new_author", $new_author, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateNbSignatures(int $id, int $nb_signatures): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET start_date=:start_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":nb_signatures", $nb_signatures, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateObjectifSignatures(int $id, int $objectif_signatures): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET start_date=:start_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":objectif_signatures", $objectif_signatures, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateStartDate(int $id, string $start_date): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET start_date=:start_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":start_date", $start_date, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateEndDate(int $id, string $end_date): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET end_date=:end_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":end_date", $end_date, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateIsValidated(int $id, bool $is_validated): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET is_validated=:is_validated WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":is_validated", $is_validated, PDO::PARAM_BOOL);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function verifyValidation(int $id): bool
   {
      $req = self::$bdd->prepare("SELECT is_validated FROM petitions WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $is_validated = $req->fetchColumn();
      $req->closeCursor();
      return $is_validated;
   }

   public static function incrementNbSignatures(int $id): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET nb_signatures=(nb_signatures + 1) WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function decrementSignatures(int $id): bool
   {
      $req = self::$bdd->prepare("UPDATE petitions SET nb_signatures=IF(nb_signatures > 0, nb_signatures - 1, 0) WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function exists(string $title, string $author): bool
   {
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM petitions WHERE title=:title AND author=:author");
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":author", $author, PDO::PARAM_STR);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      return $exists;
   }

   private static function setBdd($bdd)
   {
      self::$bdd = $bdd;
   }
}
