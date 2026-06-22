<?php

class OldRouter
{
   protected static string $path_views_admin = "views/admin";
   protected static string $path_views_global = "views/global";
   protected static string $path_views_user = "views/user";
   protected static string $path_views_error = "views/error";
   protected static string $path_controllers_admin = "controllers/admin";
   protected static string $path_controllers_global = "controllers/global";
   protected static string $path_controllers_user = "controllers/user";
   protected static string $path_models_admin = "models/admin";
   protected static string $path_models_global = "models/global";
   protected static string $path_models_user = "models/user";
   protected static string $path_sources_css_admin = "sources/css/admin";
   protected static string $path_sources_css_global = "sources/css/global";
   protected static string $path_sources_css_user = "sources/css/user";
   protected static string $path_sources_css_error = "sources/css/error";
   protected static string $path_sources_js_admin = "sources/js/admin";
   protected static string $path_sources_js_global = "sources/js/global";
   protected static string $path_sources_js_user = "sources/js/user";
   protected static string $path_sources_js_error = "sources/js/error";

   public function __construct__()
   {
   }

   public static function requireFile(string $name = "accueil", string $type = "views", string $role = "global", string $ext = "php")
   {
      $type = mb_strtolower($type);
      $role = mb_strtolower($role);
      $ext = mb_strtolower($ext);
      /*
         Test requested values
      */
      // var_dump("Name: $name");
      // var_dump("Type: $type");
      // var_dump("Role: $role");
      // var_dump("Ext: $ext");
      if ($type != "models") {
         $name = mb_strtolower($name);
      } else {
         $name = ucfirst($name);
      }
      $path = "$type/$role/$name.$ext";
      /*
      Test path 
       */
      // var_dump($path);
      if (file_exists($path)) {
         require $path;
      } else {
         self::launchError(404, "Erreur de récupération du fichier '$name'.");
      }
   }

   public static function requireArticle(string $name = "accueil", string $type = "views", string $role = "global", string $ext = "php", array $options = []){
      $type = mb_strtolower($type);
      $role = mb_strtolower($role);
      $ext = mb_strtolower($ext);
      if ($type != "models") {
         $name = mb_strtolower($name);
      } else {
         $name = ucfirst($name);
      }
      if(isset($options) && !empty($options)){
         foreach($options as $key=>$value){
            $_SESSION[$key] = $value;
         }
      }
      $path = "$type/$role/$name.$ext";
      if (file_exists($path)) {
         require $path;
      } else {
         self::launchError(404, "Erreur de récupération du fichier '$name'.");
      }
   }

   public static function requireTemplate(string $name, string $type = "templates", string $role = "global", string $ext = "php")
   {
      /*
         Use with require below.
      */
      $type = mb_strtolower($type);
      $role = mb_strtolower($role);
      $ext = mb_strtolower($ext);
      if ($type != "models") {
         $name = mb_strtolower($name);
      } else {
         $name = ucfirst($name);
      }
      $path = "$type/$role/$name.$ext";
      if (file_exists($path)) {
         return $path;
      } else {
         self::launchError(404, "Erreur de récupération du template '$name'.");
      }
   }

   public static function includeTemplate(string $name, string $type = "templates", string $role = "global", string $ext = "php")
   {
      /*
         Use with include below.
      */
      $type = mb_strtolower($type);
      $role = mb_strtolower($role);
      $ext = mb_strtolower($ext);
      if ($type != "models") {
         $name = mb_strtolower($name);
      } else {
         $name = ucfirst($name);
      }
      $path = "$type/$role/$name.$ext";
      if (file_exists($path)) {
         return $path;
      } else {
         self::launchError(404, "Erreur d'inclusion du template '$name'.");
      }
   }
   
   public static function includeFile(string $name, string $type, string $role, string $ext = "php")
   {
      $type = mb_strtolower($type);
      $role = mb_strtolower($role);
      $ext = mb_strtolower($ext);
      /*
         Test requested values
      */
      // var_dump("Name: $name");
      // var_dump("Type: $type");
      // var_dump("Role: $role");
      // var_dump("Ext: $ext");
      if ($type != "models") {
         $name = mb_strtolower($name);
      } else {
         $name = ucfirst($name);
      }
      $path = "$type/$role/$name.$ext";
      /*
      Test path 
       */
      // var_dump($path);
      if (file_exists($path)) {
         include $path;
      } else {
         self::launchError(404, "Erreur d'inclusion du fichier '$name'.");
      }
   }

   public static function requireAsset(string $name, string $type, string $ext)
   {
      $type = mb_strtolower($type);
      $ext = mb_strtolower($ext);
      $path = "$type/$name.$ext";
      if(str_contains($path, ".$ext.$ext")){
         $path = str_replace(".$ext.$ext", ".$ext", $path);
      }
      $path = str_replace("//", "/", $path);
      if (file_exists($path)) {
         require $path;
      } else {
         self::launchError(404, "Erreur de récupération de l'asset '$name'.");
      }
   }

   public static function requireSource(string $name, string $type = "css", string $role = "global", string $ext = "css")
   {
      /*
         Return string path
      */
      $type = mb_strtolower($type);
      $role = mb_strtolower($role);
      $ext = mb_strtolower($ext);
      $path = "sources/$type/$role/$name.$ext";
      if (file_exists($path)) {
         $path .= "?v=".filemtime($path);
         return "/$path";
      } else {
         self::launchError(404, "Erreur de récupération de la source '$name'.");
      }
   }

   public static function launchError(int $err, string $message = "")
   {
      switch ($err) {
         case 404:
         default:
            $path = self::$path_views_error . "/404.php";
            break;
      }
      require $path;
   }
}
