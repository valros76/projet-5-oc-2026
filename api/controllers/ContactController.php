<?php
class ContactController extends BaseController
{

  public function sendMail($params)
  {
    if (!isset($params) || empty($params)) {
      JSON::response("Erreur lors de la réception des données du formulaire de contact", 400, $params);
    }

    $params = json_decode($params);
    $datas = [
      "email" => Verify::cleanEmail($params->email) ?? null,
      "message" => Verify::cleanInputTextarea($params->message) ?? null,
      "reason" => Verify::cleanInputString($params->reason) ?? null,
      "return_date" => Verify::cleanInputString($params->returnDate) ?? null,
      "rgpd" => Verify::cleanInputString($params->rgpd) ?? null,
    ];

    foreach ($datas as $value) {
      if (is_null($value)) {
        JSON::response("Erreur lors de la réception des données du formulaire de contact", 400, $datas);
      }
    }

    switch ($datas["reason"]) {
      case "formation_sous_traitance":
        $datas["reason"] = "Je cherche un formateur";
        break;
      case "formation":
        $datas["reason"] = "Informations pour une formation";
        break;
      case "website":
        $datas["reason"] = "Création d'un site vitrine";
        break;
      case "ecommerce":
        $datas["reason"] = "Création d'une boutique en ligne";
        break;
      case "first_site":
        $datas["reason"] = "Création de votre première page web";
        break;
      case "presentation":
        $datas["reason"] = "Création d'une page web de présentation";
        break;
      case "one_product":
        $datas["reason"] = "Création d'une page d'achat pour produit unique";
        break;
      case "formation_prestashop":
        $datas["reason"] = "Formation Prestashop";
        break;
      case "formation_wordpress":
        $datas["reason"] = "Formation Wordpress";
        break;
      case "modification":
        $datas["reason"] = "Modification d'un site existant";
        break;
      case "fonctionnality":
        $datas["reason"] = "Création et ajout d'une fonctionnalité supplémentaire";
        break;
      case "freelance":
        $datas["reason"] = "Réserver une prestation journalière freelance";
        break;
      case "partenariat":
        $datas["reason"] = "Demande de partenariat";
        break;
      case "reclamation":
        $datas["reason"] = "Effectuer une réclamation";
        break;
      case "contact":
      default:
        $datas["reason"] = "Contacter l'entreprise";
        break;
    }

    switch ($datas["return_date"]) {
      case "all_work_days":
        $datas["return_date"] = "Tous les jours ouvrés";
        break;
      case "monday":
        $datas["return_date"] = "Le lundi";
        break;
      case "tuesday":
        $datas["return_date"] = "Le mardi";
        break;
      case "wednesday":
        $datas["return_date"] = "Le mercredi";
        break;
      case "thursday":
        $datas["return_date"] = "Le jeudi";
        break;
      case "friday":
        $datas["return_date"] = "Le vendredi";
        break;
      case "saturday":
        $datas["return_date"] = "Le samedi";
        break;
      case "sunday":
        $datas["return_date"] = "Le dimanche";
        break;
      case "none":
      default:
        $datas["return_date"] = "Pas de jour de préférence";
        break;
    }

    $config = new Config();
    $configFile = json_decode($config->getConfigFile());
    $contactManager = new Contact(BDD::getInstance($configFile));
    $object = "{$datas["email"]} - {$datas["email"]} - Préférence de rappel : {$datas["return_date"]}";

    if (!$contactManager::add($datas["email"], $contactManager::getServerMail(), $object, $datas["message"]) !== false) {
      JSON::response("Erreur lors de l'enregistrement du message SAV.", 400, $datas);
    }

    if(!Mail::sendMailSimple($datas["email"], Mail::getServerEmail(), $datas["reason"], $datas["message"])){
      JSON::response("Message sauvegardé !", 200, $datas);
    }
    JSON::response("Message envoyé !", 200, $datas);
  }
}
