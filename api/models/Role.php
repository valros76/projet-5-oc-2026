<?php

class Role{
   protected array $roles = [
      "ADMIN" => "ADMIN",
      "ERROR" => "ERROR",
      "GLOBAL" => "GLOBAL",
      "USER" => "USER",
   ];

   public function __construct__(){}

   public static function getRole(string $role){
      $role = mb_strtoupper($role);
      if(in_array($role, self::$roles)){
         return self::$roles[$role];
      }else{
         return null;
      }
   }
}