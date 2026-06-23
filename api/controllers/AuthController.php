<?php
class AuthController extends BaseController
{

    public function Register()
    {
        $json  = file_get_contents('php://input');
        $datas = json_decode($json);
        $user  = (object) [
            "email"    => $datas->email ?? null,
            "password" => password_hash($datas->password, PASSWORD_DEFAULT) ?? null,
            "is_admin" => (bool) $datas->is_admin ?? null,
        ];
        if (is_null($user->email) || is_null($user->password) || is_null($user->is_admin)) {
            JSON::response("Données manquantes pour l'inscription.", 400);
        }

        $userManager = new User(BDD::getInstance(Config::getConfig()));
        if (! $userManager->add($user)) {
            JSON::response("Une erreur s'est produite lors de l'inscription de l'utilisateur.", 500);
        }

        $newUser = $userManager->getByEmail($user->email);
        if (! $newUser) {
            JSON::response("Une erreur s'est produite lors de la récupération de l'utilisateur pour le renvoi de données.", 404);
        }

        JSON::response("L'utilisateur a été ajouté en BDD.", 201, $newUser);
    }

    public function Connect()
    {
        $json  = file_get_contents('php://input');
        $datas = json_decode($json);
        $user  = (object) [
            "email"    => $datas->email ?? null,
            "password" => $datas->password ?? null,
        ];
        if (is_null($user->email) || is_null($user->password)) {
            JSON::response("Données manquantes pour l'inscription.", 400);
        }

        $userManager = new User(BDD::getInstance(Config::getConfig()));
        $checkUser   = $userManager::auth($user->email);

        if (! $checkUser) {
            JSON::response("L'utilisateur n'existe pas.", 404);
        }

        if (! password_verify($user->password, $checkUser->password)) {
            JSON::response("La connexion a été refusée.", 401);
        }

        unset($checkUser->password);
        JSON::response("L'utilisateur est authentifié.", 200, $checkUser);
    }
}
