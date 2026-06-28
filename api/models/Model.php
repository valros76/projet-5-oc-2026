<?php
class Model{
  protected static ?PDO $bdd = null;

    protected static function getBdd(): PDO {
        if (self::$bdd === null) {
            self::$bdd = BDD::getInstance();
        }
        return self::$bdd;
    }
}