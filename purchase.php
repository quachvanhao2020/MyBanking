<?php
require_once __DIR__."/index.php";

return (function(string $data){
    global $_GATEWAY;
    $result = [];
    $response = $_GATEWAY->purchase([
        'items' => [
            [
                "price" => "500.00",
                "currency" => "USD"
            ]
        ]
    ])->send();
    if ($response->isRedirect()) {
        $response->redirect();
    } elseif ($response->isSuccessful()) {
        $result = $response->getData();
        return release($result);
    } else {
        return release($result);
    }
})(...$_INPUT);