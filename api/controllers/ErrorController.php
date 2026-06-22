<?php

class ErrorController
{
    private $httpRequest;
    private $config;

    /**
     * Le constructeur reçoit l'objet HttpRequest et la config 
     * car c'est ainsi que votre classe Route instancie le contrôleur.
     */
    public function __construct($httpRequest, $config)
    {
        $this->httpRequest = $httpRequest;
        $this->config = $config;
    }

    /**
     * Cette méthode sera appelée par la route /error.
     * Elle reçoit l'exception grâce à votre $httpRequest->addParam($e) dans index.php.
     */
    public function show($exception)
    {
        // On définit le code de réponse HTTP (404, 500, etc.)
        // Si l'exception a un code, on l'utilise, sinon 500 par défaut.
        $code = ($exception->getCode() == 0) ? 500 : $exception->getCode();
        
        // On s'assure que le code est valide pour une réponse HTTP
        if (!is_int($code) || $code < 100 || $code > 599) {
            $code = 500;
        }

        http_response_code($code);

        // Réponse propre en JSON pour votre API
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => $exception->getMessage(),
            "code" => $exception->getCode(),
            // Optionnel : ne pas afficher le fichier/ligne en production pour la sécurité
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
        exit;
    }
}