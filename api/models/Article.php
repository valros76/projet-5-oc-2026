<?php
class Article{
   private static int $id;
   private static string $title;
   private static string $content;
   private static string $slug;
   private static string $creation_date;
   private static string $modification_date;
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

   public static function getTitle(): string{
      return self::$title;
   }

   public static function setTitle(string $title){
      self::$title = $title;
   }

   public static function getContent(): string{
      return self::$content;
   }

   public static function setContent(string $content){
      self::$content = $content;
   }

   public static function getSlug(): string{
      return self::$slug;
   }

   public static function setSlug(string $slug){
      self::$slug = $slug;
   }

   public static function getCreationDate(): string{
      return self::$creation_date;
   }

   public static function setCreationDate(string $creation_date){
      self::$creation_date = $creation_date;
   }

   public static function getModificationDate(): string{
      return self::$modification_date;
   }

   public static function setModificationDate(string $modification_date){
      self::$modification_date = $modification_date;
   }

   public static function add(string $title, string $content, string $slug, string $category): bool{
      $req = self::$bdd->prepare("INSERT INTO articles(id,title,content,slug,category,creation_date,modification_date) VALUES(:id,:title,:content,:slug,:category,NOW(),NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      $req->bindValue(":slug", $slug, PDO::PARAM_STR);
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }
   
   public static function deleteAll(){
      return self::$bdd->exec("DELETE FROM articles");
   }

   public static function deleteById(int $id){
      return self::$bdd->exec("DELETE FROM articles WHERE id=$id");
   }

   public static function deleteByTitle(string $title){
      return self::$bdd->exec("DELETE FROM articles WHERE title=$title");
   }

   public static function deleteBySlug(string $slug){
      return self::$bdd->exec("DELETE FROM articles WHERE slug=$slug");
   }

   public static function getById(int $id): ?object{
      $req = self::$bdd->prepare("SELECT * FROM articles WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getBySlug(string $slug): ?object{
      $req = self::$bdd->prepare("SELECT * FROM articles WHERE slug=:slug");
      $req->bindValue(":slug", $slug, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getList(): object|array|null{
      $req = self::$bdd->prepare("SELECT * FROM articles ORDER BY modification_date DESC,creation_date DESC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getNewestList(): object|array|null{
      $req = self::$bdd->prepare("SELECT * FROM articles ORDER BY modification_date DESC,creation_date DESC LIMIT 5");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getListByCategory(string $category): object|array|null{
      $req = self::$bdd->prepare("SELECT * FROM articles WHERE category=:category ORDER BY modification_date DESC,creation_date DESC");
      $req->bindValue(":category", $category, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      foreach($datas as $key=>$article){
         if($article->category != $category){
            unset($datas[$key]);
         }
      }
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function update(int $id,string $title, string $content, string $slug, string $category): bool{
      $req = self::$bdd->prepare("UPDATE articles SET title=:title,content=:content,slug=:slug,category=:category,modification_date=NOW() WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      $req->bindValue(":slug", $slug, PDO::PARAM_STR);
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateTitle(int $id, string $title): bool{
      $req = self::$bdd->prepare("UPDATE articles SET title=:title WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":title", $title, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateContent(int $id, string $content): bool{
      $req = self::$bdd->prepare("UPDATE articles SET content=:content WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":content", $content, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateSlug(int $id, string $slug): bool{
      $req = self::$bdd->prepare("UPDATE articles SET slug=:slug WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":slug", $slug, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateCategory(int $id, string $category): bool{
      $req = self::$bdd->prepare("UPDATE articles SET category=:category WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function updateModificationDate(int $id): bool{
      $req = self::$bdd->prepare("UPDATE articles SET modification_date=NOW() WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function exists(string $title, string $content, string $slug): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM articles WHERE title=:title AND content=:content AND slug=:slug");
      $req->bindValue(":title", $title, PDO::PARAM_INT);
      $req->bindValue(":content", $content, PDO::PARAM_INT);
      $req->bindValue(":slug", $slug, PDO::PARAM_INT);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      if($exists != false){
         return true;
      }
      return false;
   }

   public static function existsById(int $id): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM articles WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      if($exists != false){
         return true;
      }
      return false;
   }

   public static function existsByCategory(string $category): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM articles WHERE category=:category");
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      if($exists != false){
         return true;
      }
      return false;
   }

   public static function existsBySlug(string $slug): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM articles WHERE slug=:slug");
      $req->bindValue(":slug", $slug, PDO::PARAM_STR);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      if($exists != false){
         return true;
      }
      return false;
   }

   public static function setBdd($bdd){
      self::$bdd = $bdd;
   }
}