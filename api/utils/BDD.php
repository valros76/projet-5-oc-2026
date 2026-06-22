<?php
class BDD
{
    private $bdd;
    private static $instance;

    private function __construct($bddConfig = null)
    {

        if (is_null($bddConfig)) {
            $configManager = new Config("config/config.json");
            $config        = $configManager::getConfig();
        } else {
            $config = $bddConfig;
        }
        $bddMode = $_ENV["BDD_MODE"];
        if (!in_array($bddMode, ["dev", "prod"])) {
            $bddMode = "dev";
        }
        $db = ($bddMode === "prod") ? $config->database->prod : $config->database->dev;
        $key = $_ENV["PASSWORD_ENCRYPT_KEY"];
        $decrypted = openssl_decrypt(
            base64_decode($db->encrypted_password),
            $_ENV["PASSWORD_ENCRYPT_ALG"],
            $key,
            OPENSSL_RAW_DATA,
            base64_decode($db->iv),
            base64_decode($db->tag)
        );
        if ($bddMode === "dev") {
            // $decrypted remplace : $config->database->dev->password
            $this->bdd = new PDO("mysql:dbname={$config->database->dev->dbname};host={$config->database->dev->host};charset=utf8", $config->database->dev->username, $decrypted);
        } else {
            // $decrypted remplace : $config->database->prod->password
            $this->bdd = new PDO("mysql:dbname={$config->database->prod->dbname};host={$config->database->prod->host};charset=utf8", $config->database->prod->username, $decrypted);
        }
    }

    public static function getInstance($bddConfig)
    {
        if (empty(self::$instance)) {
            self::$instance = new BDD($bddConfig);
        }
        return self::$instance->bdd;
    }

    public function getBdd()
    {
        return $this->bdd;
    }
}
