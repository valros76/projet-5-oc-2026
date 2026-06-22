<?php
class Rank{
   private static $ranksList = [
      0 => "Contributeur débutant",
      1 => "Contributeur intermédiaire",
      2 => "Contributeur chevronné",
   ];

   public static function getAll(){
      return self::$ranksList;
   }

   public static function getDefault(){
      return self::$ranksList[0];
   }
}