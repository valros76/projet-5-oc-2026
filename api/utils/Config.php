<?php
class Config{

  private static $configFile;
  private static $config;

  public function __construct($configPath = "config/config.json"){
    if(!file_exists($configPath)){
      exit;
    }

    $this->registerConfig($configPath);
  }

  public static function getConfigFile(){
    return self::$configFile;
  }

  public static function getConfig(){
    return self::$config;
  }

  public static function registerConfig($configPath = "config/config.json"){
    self::$configFile = file_get_contents($configPath);
    // Ne pas oublier true pour transformer en tableau associatif
    self::$config = json_decode(self::$configFile);

    return [self::$configFile, self::$config];
  }

}