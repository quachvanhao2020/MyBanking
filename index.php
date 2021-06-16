<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/report.php";
require_once __DIR__."/gateway.php";
$_INPUT = array_values($_REQUEST);
if(WEB_HOOK_TOKEN !== @$_GET['token']){
  die();
  return;
}