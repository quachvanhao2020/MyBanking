<?php
require_once __DIR__."/index.php";

return (function(){
    global $_GATEWAY;
    $result = [];
    $response = $_GATEWAY->listPlan()->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);