
<?php
class Test{
  private static int $id;
  private static string $value;
  private static $bdd;

  public function __construct($bdd = null){
    if(!is_null($bdd)){
      self::setBdd($bdd);
    }
  }

  public static function add(object $datas): bool{
    $req = self::$bdd->prepare("INSERT INTO tests(value) VALUES(:value)");
    $req->bindValue(":value", $datas->value, PDO::PARAM_STR);
    return $req->execute();
  }

  private static function setBdd(PDO $bdd){
    self::$bdd = $bdd;
  }
}