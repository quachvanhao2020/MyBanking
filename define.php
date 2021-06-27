<?php
require_once __DIR__."/vendor/autoload.php";

define("APP_NAME","MyBanking");
define("__ROOT__",__DIR__);
define("__DATA__",__ROOT__."/data");
define("__CACHE__",__DATA__."/cache");
define("ISDEV",getenv('ISDEV', true) ? intval(getenv('ISDEV')) : 0);
define("ROOT_URL",(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
!defined("ENV") && define("ENV",null);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);$dotenv->load();
define("LOG_FILE",__ROOT__."/log.log");
define("TEST_MODE",getenv('TEST_MODE', true) ? getenv('TEST_MODE') : true);
define("GATE_WAY",getenv('GATE_WAY', true) ? getenv('GATE_WAY') : "paypal");
define("BRAND_NAME",getenv('BRAND_NAME', true) ? getenv('BRAND_NAME') : "HQ");
define("RETURN_URL",getenv('RETURN_URL', true) ? getenv('RETURN_URL') : "https://stack-open-media-bot.herokuapp.com/command/active_order_product.php");
define("CANCEL_URL",getenv('CANCEL_URL', true) ? getenv('CANCEL_URL') : "https://stack-open-media-bot.herokuapp.com/command/cancel_order_product.php");
