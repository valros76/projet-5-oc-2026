<?php

class Clean
{
   public function __construct__()
   {
   }

   public static function cleanUri(string $uri): string
   {
      $uri = preg_replace('/[?]/i', "", $uri);
      $uri = preg_replace('/[\/]/i', "", $uri, 1);
      return $uri;
   }

   public static function cleanFilename(string $filename, string $type, string $role, string $ext): string
   {
      $httpHost = $_SERVER["HTTP_HOST"];
      $name = $filename;
      $name = preg_replace(sprintf("/(%s)/i", $httpHost), "", $name);
      $name = preg_replace('/(globals)/i', "", $name);
      $name = preg_replace('/(global)/i', "", $name);
      $name = preg_replace('/(admins)/i', "", $name);
      $name = preg_replace('/(admin)/i', "", $name);
      $name = preg_replace('/(users)/i', "", $name);
      $name = preg_replace('/(user)/i', "", $name);
      $name = preg_replace('/(errors)/i', "", $name);
      $name = preg_replace('/(error)/i', "", $name);
      $name = preg_replace('/(pages)/i', "", $name);
      $name = preg_replace('/(page)/i', "", $name);
      $name = preg_replace('/(templates)/i', "", $name);
      $name = preg_replace('/(template)/i', "", $name);
      $name = preg_replace('/(controllers)/i', "", $name);
      $name = preg_replace('/(controller)/i', "", $name);
      $name = preg_replace('/(assets)/i', "", $name);
      $name = preg_replace('/(asset)/i', "", $name);
      if(str_contains($name, "articles/")){
         $name = preg_replace('/(?:(\/articles\/)([\w\W\s\S\/]*)|(articles\/)([\w\W\s\S\/]*))/i', "lire-un-article", $name);
      }
      if(str_contains($name, "article/")){
         $name = preg_replace('/(?:(\/article\/)([\w\W\s\S\/]*)|(article\/)([\w\W\s\S\/]*))/i', "lire-un-article", $name);
      }
      $name = preg_replace('/[.]/i', "", $name);
      $name = preg_replace('/[\/]/i', "", $name);
      $name = preg_replace('/(\/\/)/i', "", $name);
      if(empty($name)){
         $name="/";
      }
      return $name;
   }

   public static function cleanSlug(string $slug){
      if(isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])){
         $httpHost = $_SERVER["HTTP_HOST"];
         $slug = preg_replace(sprintf("/(%s)/i", $httpHost), "", $slug);
         $slug = preg_replace('/(\/\/)/i', "/", $slug);
      }
      return $slug;
   }

   public static function getPath(string $uri, string $query): string
   {
      $road = substr($uri, 0, (strlen($uri) - strlen($query)));
      $road = self::cleanUri($road);
      return $road;
   }

   public static function getQuery(string $uri, string $query): string
   {
      $request = substr($uri, (strlen($uri) - strlen($query)));
      return $request;
   }

   public static function getArrayQuery(string $uri, string $query): array
   {
      $request = self::getQuery(uri: $uri, query: $query);
      $request = explode("&", $request);
      $indexedRequests = [];
      foreach ($request as $value) {
         $value = explode("=", $value);
         $indexedRequests[$value[0]] = $value[1] ?? null;
      }
      return $indexedRequests;
   }
}
