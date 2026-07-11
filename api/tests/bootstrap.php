<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/Autoloader.php';
Autoloader::register();
if (!defined('SESSION_NONE')) {
    define('SESSION_NONE', PHP_SESSION_NONE);
}