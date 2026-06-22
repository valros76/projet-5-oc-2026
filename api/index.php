<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set("date.timezone", "Europe/Paris");
error_reporting(E_ALL);
// ini_set("display_errors", "off");
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");

require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once "utils/Autoloader.php";
Autoloader::register();
[$configFile, $config] = Config::registerConfig("config/config.json");

// Gérer la requête de pré-vol (OPTIONS)
// Les navigateurs envoient une requête OPTIONS avant une requête complexe pour vérifier les permissions.
// Votre API DOIT répondre à cette requête OPTIONS sans exécuter la logique principale.
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Si c'est une requête OPTIONS, on a juste besoin d'envoyer les en-têtes CORS et de terminer.
    http_response_code(200);
    exit();
}

try {
    $httpRequest = new HttpRequest();
    $router      = new Router();
    $httpRequest->setRoute($router->findRoute($httpRequest, $config->basepath));
    $httpRequest->run($config);
} catch (Exception $e) {
    $httpRequest = new HttpRequest("/error", "GET");
    $router      = new Router();
    $httpRequest->setRoute($router->findRoute($httpRequest, $config->basepath));
    $httpRequest->addParam($e);
    $httpRequest->run($config);
}
