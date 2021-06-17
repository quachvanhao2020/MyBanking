<?php
require_once __DIR__."/index.php";

return (function(string $plan_id,string $locale = "en-US",string $return_url,string $cancel_url){
    global $_GATEWAY;
    $result = [];
    $response = $_GATEWAY->createSubscription([])->setData([
      'plan_id' => $plan_id,
      'application_context' => [
        'brand_name' => BRAND_NAME,
        'locale' => $locale,
        'shipping_preference' => 'NO_SHIPPING',
        'user_action' => 'SUBSCRIBE_NOW',
        'payment_method' => [
          'payer_selected' => 'PAYPAL',
          'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
        ],
        'return_url' => $return_url,
        'cancel_url' => $cancel_url,
      ],
    ])->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);