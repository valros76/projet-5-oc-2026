<?php
class WelcomeController extends BaseController{
  public function HelloWorld(){
    header("Refresh: 3; url=https://webdevoo.com");
    JSON::response("Bonjour ! Bienvenue sur l'API de Webdevoo", 200, [
      "helloWorld" => "Bonjour ! Bienvenue sur l'API de Webdevoo, vous allez être redirigé sur notre site, pour nourrir votre curiosité !"
    ]);
  }
}