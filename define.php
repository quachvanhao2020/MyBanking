<?php
require_once __DIR__."/vendor/autoload.php";

define("APP_NAME","MyBaking");
define("__ROOT__",__DIR__);
define("__DATA__",__ROOT__."/data");
define("__CACHE__",__DATA__."/cache");
define("ISDEV",getenv('ISDEV', true) ? intval(getenv('ISDEV')) : 0);
define("ROOT_URL",(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
!defined("ENV") && define("ENV",null);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);$dotenv->load();
define("LOG_FILE",__ROOT__."/log.log");
define("WEB_HOOK_TOKEN",getenv('WEB_HOOK_TOKEN', true) ? getenv('WEB_HOOK_TOKEN') : "123");
define("TELEGRAM_TOKEN",getenv('TELEGRAM_TOKEN', true) ? getenv('TELEGRAM_TOKEN') : "1624579880:AAHQeFnbgQxCHIjihnmeBJaVOLa0nYk-bMU");
define("TEST_MODE",getenv('TEST_MODE', true) ? getenv('TEST_MODE') : true);
define("GATE_WAY",getenv('GATE_WAY', true) ? getenv('GATE_WAY') : "paypal");
