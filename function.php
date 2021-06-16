<?php

function release(array $result,int $code = 200){
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($result);
}