<?php
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/iauth.php";
require_once __DIR__."/police/index.php";
require_once __DIR__."/report.php";
require_once __DIR__."/gateway.php";
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
$_INPUT = array_values($_REQUEST);
$_CACHE = [
    'default' => new FilesystemAdapter('',0,__CACHE__),
    'function' => new FilesystemAdapter('fuc',0,__CACHE__),
    'context' => new FilesystemAdapter('context',0,__CACHE__),
];

