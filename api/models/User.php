<?php
class User{
  private static int $id;
  private static string $email;
  private static string $password;
  private static bool $is_admin;
  private static string $inscription_date;
  private static PDO $bdd;

  public function __construct($bdd = null){
    if(!is_null($bdd)){
      self::setBdd($bdd);
    }
  }

  public static function add($user, $is_admin = false){
    $req = self::$bdd->prepare("INSERT INTO users(email, password, is_admin) VALUES(:email, :password, :is_admin)");
    $req->bindValue(":email", $user->email, PDO::PARAM_STR);
    $req->bindValue(":password", $user->password, PDO::PARAM_STR);
    $req->bindValue(":is_admin", $user->is_admin, PDO::PARAM_BOOL);

    return $req->execute();
  }

  public static function getById(int $id){
    $req = self::$bdd->prepare("SELECT id, email, is_admin, inscription_date FROM users WHERE id=:id");
    $req->bindValue(":id", $id, PDO::PARAM_INT);
    $req->execute();
    $user = $req->fetch(PDO::FETCH_OBJ);

    return $user;
  }

  public static function getByEmail(string $email){
    $req = self::$bdd->prepare("SELECT id, email, is_admin, inscription_date FROM users WHERE email=:email");
    $req->bindValue(":email", $email, PDO::PARAM_STR);
    $req->execute();
    $user = $req->fetch(PDO::FETCH_OBJ);

    return $user;
  }

  public static function auth(string $email){
    $req = self::$bdd->prepare("SELECT * FROM users WHERE email=:email");
    $req->bindValue(":email", $email, PDO::PARAM_INT);
    $req->execute();
    $user = $req->fetch(PDO::FETCH_OBJ);

    return $user;
  }

  private static function setBdd(PDO $bdd){
    self::$bdd = $bdd;
  }
}