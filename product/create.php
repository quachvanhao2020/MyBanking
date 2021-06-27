<?php
require_once __DIR__."/index.php";

return (function(string $name,string $description,string $type,string $category,string $image_url = "",string $home_url = "",array $_data = []){
    if(empty($description)) $description = "description";
    if(empty($image_url)) $image_url = "https://www.w3schools.com/";
    if(empty($home_url)) $home_url = "https://www.w3schools.com/";
    if(empty($type)) $type = "SERVICE";
    if(empty($category)) $category = "SOFTWARE";
    $data = [
      "name" => $name,
      "description" => $description,
      "type" => $type,
      "category" => $category,
      "image_url" => $image_url,
      "home_url" => $home_url,
    ];
    $data = array_merge_recursive($data,$_data);
    $result = [];
    $response = pay_gatetway()->createProduct([])->setData($data)->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);