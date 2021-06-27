<?php
use Omnipay\PayPalv2\RestGateway;

/** @var RestGateway $_GATEWAY */
global $_GATEWAY;
load_gate_way(__DIR__."/gateway/".GATE_WAY);
function load_gate_way(string $root){
    global $_GATEWAY;
    $index = $root."/index.php";
    if(file_exists($index)){
        if(TEST_MODE){
            require_once $root."/sandbox.php";
        }else{
            require_once $root."/live.php";
        }
        $_GATEWAY = require_once $index;
    }
}

/** @return RestGateway */
function pay_gatetway(){
    global $_GATEWAY;
    return $_GATEWAY;
}