<?php
class NewsletterAction
{
   private static int $min_interval = 7;
   private static int $max_interval  = 14;
   private static int $id;
   private static int $nb_days_next_send;
   private static string $last_send_date;
   private static $bdd;

   public function __construct($bdd = null)
   {
      if (!is_null($bdd)) {
         self::setBdd($bdd);
      }
   }

   public static function getMinInterval(): int
   {
      return self::$min_interval;
   }

   public static function setMinInterval(int $min_interval)
   {
      self::$min_interval = $min_interval;
   }

   public static function getMaxInterval(): int
   {
      return self::$max_interval;
   }

   public static function setMaxInterval(int $max_interval)
   {
      self::$max_interval = $max_interval;
   }

   public static function getId(): int
   {
      return self::$id;
   }

   public static function setId(int $id)
   {
      self::$id = $id;
   }

   public static function getNbDaysNextSend(): int
   {
      return self::$nb_days_next_send;
   }

   public static function setNbDaysNextSend(int $nb_days_next_send)
   {
      if ($nb_days_next_send < self::$min_interval) {
         $nb_days_next_send = (int) self::$min_interval;
      }
      if ($nb_days_next_send > self::$max_interval) {
         $nb_days_next_send = (int) self::$max_interval;
      }
      self::$nb_days_next_send = $nb_days_next_send;
   }

   public static function getLastSendDate(): string
   {
      return self::$last_send_date;
   }

   public static function setLastSendDate(string $last_send_date)
   {
      self::$last_send_date = $last_send_date;
   }

   public static function add(int $nb_days_next_send): bool
   {
      $req = self::$bdd->prepare("INSERT INTO newsletter_actions(id, nb_days_next_send, last_send_date) VALUES(:id, :nb_days_next_send, NOW())");
      $req->bindValue(":id", self::$bdd->lastInsertId(), PDO::PARAM_INT);
      $req->bindValue(":nb_days_next_send", (int) $nb_days_next_send, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function getList(): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM newsletter_actions ORDER BY id ASC");
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getFirst(): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM newsletter_actions ORDER BY id ASC LIMIT 0,1");
      $req->execute();
      $datas = $req->fetch(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function getById(int $id): array|object|null
   {
      $req = self::$bdd->prepare("SELECT * FROM newsletter_actions WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->execute();
      $datas = $req->fetchAll(PDO::FETCH_OBJ);
      $req->closeCursor();
      if (!is_null($datas) && !empty($datas)) {
         return $datas;
      }
      return null;
   }

   public static function update(int $id, int $nb_days_next_send): bool
   {
      $req = self::$bdd->prepare("UPDATE newsletter_actions SET nb_days_next_send=:nb_days_next_send, last_send_date=NOW() WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":nb_days_next_send", $nb_days_next_send, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateNbDaysNextSend(int $id, int $nb_days_next_send): bool
   {
      $req = self::$bdd->prepare("UPDATE newsletter_actions SET nb_days_next_send=:nb_days_next_send WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":nb_days_next_send", $nb_days_next_send, PDO::PARAM_INT);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function updateLastSendDate(int $id, string $last_send_date): bool
   {
      $req = self::$bdd->prepare("UPDATE newsletter_actions SET last_send_date=:last_send_date WHERE id=:id");
      $req->bindValue(":id", $id, PDO::PARAM_INT);
      $req->bindValue(":last_send_date", $last_send_date, PDO::PARAM_STR);
      if ($req->execute() != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function getRandomNbDaysNextSend(int $start_interval = 7, int $end_interval = 14): int
   {
      return (int) rand($start_interval, $end_interval);
   }

   public static function existsFirst(): bool
   {
      $req = self::$bdd->prepare("SELECT COUNT(id) FROM newsletter_actions");
      $req->execute();
      $exists = $req->fetchColumn();
      if ($exists != false) {
         $req->closeCursor();
         return true;
      }
      return false;
   }

   public static function compareDateWithDelay(string $old_date, string $new_date, int $delay): bool
   {
      // On ajoute le délai en nombre de jours à l'ancienne date d'envoi.
      $converted_delay = new Datetime($old_date);
      $date_interval = DateInterval::createFromDateString("$delay days");
      $converted_delay = $converted_delay->add($date_interval);
      $converted_delay = strtotime($converted_delay->format("Y-m-d"));
      // Conversion de l'ancienne et de la nouvelle date.
      $old_date = strtotime($old_date);
      $new_date = strtotime($new_date);
      // On vérifie si "nouvelle date - le délai" (en timestamp) est supérieur à 0. Si oui, c'est que le délai est passé.
      $isAfterNewDate = ($new_date - $converted_delay) >= 0 ? true : false;
      // On vérifie qu'il y a bien un délai d'écart entre l'ancienne date d'envoi et le délai donné.
      $isAfterOldDate = ($converted_delay - $old_date) >= 0 ? true : false;
      // Si ces calculs sont vrais, alors on renvoie true.
      if ($isAfterNewDate === true && $isAfterOldDate === true) {
         return true;
      }
      return false;
   }

   public static function sendSimpleMail($actual_petition = null): bool
   {
      $newsletter = new Newsletter(BDD::getInstance(Config::getConfigFile()));
      $newsletterList = $newsletter::getList();
      if (!is_null($newsletterList)) {
         $server_email = Mail::getServerEmail();
         $actual_datetime = new DateTime("now");
         $date_day = Format::formatDatetime($actual_datetime->format("Y-m-d H:i:s"), "d/m/Y");
         $hour_day = Format::formatDatetime($actual_datetime->format("Y-m-d H:i:s"), "H:i");
         $subject = "De nouvelles pétitions ont été publiée sur E-petition";
         if (!is_null($actual_petition) && isset($actual_petition->id) && !empty($actual_petition->id)) {
            $petition_link = $_SERVER["SERVER_NAME"] . "/liste-des-petitions";
         } else {
            $petition_link = $_SERVER["SERVER_NAME"] . "/liste-des-petitions";
         }
         $create_petition_link = $_SERVER["SERVER_NAME"] . "/user/creer-une-petition";
         $message = "
            <h2>De nouvelles pétitions ont été publiées sur E-petition</h2>
            <p>
               Vous pouvez dès à présent consulter les nouvelles pétitions en cliquant ici :
            </p>
            <p><strong><a href='$petition_link'>Découvrir les pétitions</a></strong></p>
            <hr/>
            <h2>Créez votre pétition</h2>
            <p>
            <strong>Un sujet vous tient à cœur  ?</strong>
            </p>
            <p>Créez votre pétition en <b><a href='$create_petition_link'>cliquant ici</a></b>.</p>
            <h3>Pourquoi créer une pétition ?</h3>
            <p>Il est primordial et vital que nos opinions et nos valeurs en tant que citoyens soient prises en compte pour que demain soit un monde meilleur.</p>
            <p>Une pétition est un <b>moyen d’action efficace</b>, pour que les citoyens reprennent le pouvoir sur les actions qui leur semblent justes.</p>
            <p>Créez votre pétition et rejoignez les réveillés.</p>
            <p><strong><a href='$create_petition_link'>Je crée ma pétition</a></strong></p>
            <p>
               Bonne journée.
            </p>
         ";
         $getReturn = false;
         foreach ($newsletterList as $newsletter_line) {
            if (!is_null($newsletter_line->email)) {
               if(Mail::sendMailSimple($server_email, $newsletter_line->email, $subject, $message)){
                  $getReturn = true;
               }
            }
         }
         return $getReturn;
      }
      return false;
   }

   private static function setBdd($bdd)
   {
      self::$bdd = $bdd;
   }
}
