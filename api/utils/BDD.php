<?php
class BDD
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (is_null(self::$instance)) {
            try {
                $config = Config::getConfig();
                $mode = $_ENV["BDD_MODE"] ?? 'dev';

                $bdd = ($mode === "prod") ? $config->database->prod : $config->database->dev;

                $key = $_ENV["PASSWORD_ENCRYPT_KEY"];

                $decrypted = openssl_decrypt(
                    base64_decode($bdd->encrypted_password),
                    $_ENV["PASSWORD_ENCRYPT_ALG"],
                    $key,
                    OPENSSL_RAW_DATA,
                    base64_decode($bdd->iv),
                    base64_decode($bdd->tag)
                );

                $dsn = "mysql:host={$bdd->host};dbname={$bdd->dbname};charset=utf8mb4";

                self::$instance = new PDO($dsn, $bdd->username, $decrypted, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                error_log("Erreur critique BDD : " . $e->getMessage());
                throw new Exception("Impossible de se connecter à la base de données. Veuillez réessayer plus tard.");
            }
        }

        return self::$instance;
    }
}
