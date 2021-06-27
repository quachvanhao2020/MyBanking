<?php
require_once __DIR__."/index.php";

return (function(){
    $result = [];
    $response = pay_gatetway()->listProduct()->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);