<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$password = "";
// Récupérer la clé depuis le fichier .env
$key = $_ENV['ENCRYPTION_KEY'];

$cipher = "aes-256-gcm";
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
$tag = ""; // Sera rempli par openssl_encrypt

$encrypted = openssl_encrypt($password, $cipher, $key, $options=0, $iv, $tag);

// Stockez ces valeurs (en base64 pour éviter les caractères spéciaux)
echo "Encrypted: " . $encrypted . "\n";
echo "<hr/>";
echo "IV: " . base64_encode($iv) . "\n";
echo "<hr/>";
echo "Tag: " . base64_encode($tag) . "\n";