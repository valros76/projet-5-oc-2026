<?php
class Model
{
    protected static ?PDO $bdd = null;

    protected static function getBdd(): PDO
    {
        if (self::$bdd === null) {
            self::$bdd = BDD::getInstance();
        }
        return self::$bdd;
    }

    // Méthode ajoutée pour permettre l'injection de BDD dans les tests
    public static function setBdd(PDO $bdd): void
    {
        self::$bdd = $bdd;
    }
}
