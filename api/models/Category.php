<?php
class Category{
   private static int $id;
   private static string $category;
   private static array $categories = [
      "webdevoo",
      "jadenya",
      "partenaires",
      "developpement",
      "economie",
      "faits-divers",
      "loisir",
      "culture",
      "sport",
      "insolite",
      "lifestyle"
   ];
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

   public static function getCategory(): string{
      return self::$category;
   }

   public static function setCategory(string $category){
      self::$category = $category;
   }

   public static function getCategories(): array{
      return self::$categories;
   }

   public static function setCategories(array $categories){
      self::$categories = $categories;
   }

   public static function uniformizeCategory(string $category){
      $category = trim($category);
      $category = preg_replace('/[\s\n\r]+/i', '-', $category);
      $category = preg_replace('/[\-]+/i', '-', $category);
      $category = strtolower($category);
      return $category;
   }

   public static function putCategoryInCategories(string $category){
      $category = self::uniformizeCategory($category);
      array_push(self::$categories, $category);
   }

   public static function putCategoriesInCategories(array $categories){
      foreach($categories as $category){
         $category = self::uniformizeCategory($category);
      }
      array_push(self::$categories, $categories);
   }

   public static function add(string $category): bool{
      $req = self::$bdd->prepare("INSERT INTO categories(id, category) VALUES(:id, :category)");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      if(self::exists($category) != true && $req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function deleteAll(){
      return self::$bdd->exec("DELETE FROM categories");
   }

   public static function deleteById(int $id){
      return self::$bdd->exec("DELETE FROM categories WHERE id=$id");
   }

   public static function deleteByCategory(string $category){
      $category = self::uniformizeCategory($category);
      return self::$bdd->exec("DELETE FROM categories WHERE category=$category");
   }

   public static function exists(string $category): bool{
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM categories WHERE category=:category");
      $category = self::uniformizeCategory($category);
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      $req->execute();
      $exists = (bool) $req->fetchColumn();
      $req->closeCursor();
      if($exists != false){
         return true;
      }
      return false;
   }

   public static function getById(int $id): ?object{
      $req = self::$bdd->prepare("SELECT id, category FROM categories WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getByCategory(string $category): ?object{
      $req = self::$bdd->prepare("SELECT id, category FROM categories WHERE category=:category");
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function getList(): object|array|null{
      $req = self::$bdd->prepare("SELECT id, category FROM categories ORDER BY id ASC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         return $datas;
      }
      return null;
   }

   public static function update(int $id, string $category): bool{
      $req = self::$bdd->prepare("UPDATE categories SET category=:category WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":category", $category, PDO::PARAM_STR);
      if($req->execute() != false){
         $req->closeCursor();
         return true;
      }
      $req->closeCursor();
      return false;
   }

   public static function actualiseCategories(): object|array|null{
      $req = self::$bdd->prepare("SELECT id, category FROM categories ORDER BY id ASC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if(!empty($datas) && $datas != false){
         self::setCategories([]);
         foreach($datas as $data){
            self::putCategoryInCategories($data->category);
         }
         return self::$categories;
      }
      return null;
   }

   public static function setBdd($bdd){
      self::$bdd = $bdd;
   }
}