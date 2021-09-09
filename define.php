<?php
require_once __DIR__."/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
define("APP_NAME","MyBanking");
define("__ROOT__",__DIR__);
define("__DATA__",__ROOT__."/data");
define("__CACHE__",__DATA__."/cache");
define("__LIB__",__ROOT__."/lib");
define("ISDEV",getenv('ISDEV', true) ? intval(getenv('ISDEV')) : 0);
define("ROOT_URL",(!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
define("LOG_FILE",__ROOT__."/log.log");
define("TEST_MODE",getenv('TEST_MODE',true) ? true : false);
define("GATE_WAY",getenv('GATE_WAY',true) ? getenv('GATE_WAY') : "paypal");
define("BRAND_NAME",getenv('BRAND_NAME', true) ? getenv('BRAND_NAME') : "HQ");
define("RETURN_URL",getenv('RETURN_URL', true) ? getenv('RETURN_URL') : "https://cm3.theboter.com/active_order_product.php");
define("CANCEL_URL",getenv('CANCEL_URL', true) ? getenv('CANCEL_URL') : "https://cm3.theboter.com/cancel_order_product.php");
