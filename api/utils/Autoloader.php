<?php
class Autoloader
{

    public static function register()
    {
        spl_autoload_register(function ($class) {
            if (file_exists("config/config.json")) {
                $config     = file_get_contents("config/config.json");
                $configFile = json_decode($config);
            }
            $class = ucfirst($class);
            if (file_exists("models/$class.php")) {
                require "models/$class.php";
            }
            foreach ($configFile->autoloadFolders as $dir) {
                if (file_exists("$dir/$class.php")) {
                    require_once "$dir/$class.php";
                }
            }
        });
    }
}
