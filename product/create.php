<?php
require_once __DIR__."/index.php";

return (function(string $name,string $description,string $type,string $category,string $image_url = "",string $home_url = ""){
    global $_GATEWAY;
    if(empty($description)) $description = "description";
    if(empty($image_url)) $image_url = "https://www.w3schools.com/";
    if(empty($home_url)) $home_url = "https://www.w3schools.com/";
    $data = [
      "name" => $name,
      "description" => $description,
      "type" => "SERVICE",
      "category" => "SOFTWARE",
      "image_url" => $image_url,
      "home_url" => $home_url,
    ];
    $result = [];
    $response = $_GATEWAY->createProduct([])->setData($data)->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);