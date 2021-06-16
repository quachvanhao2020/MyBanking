<?php
use Omnipay\Omnipay;
$gateway = Omnipay::create("\Omnipay\PayPalv2\RestGateway");
$config = [
    'clientId' => PAYMENT_CLIENT_ID,
    'secret' => PAYMENT_SECRET,
    'testMode' => TEST_MODE,
];
$gateway->initialize($config);
$_PAYMENT_GATE_WAY;
return $gateway;