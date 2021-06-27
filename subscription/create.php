<?php
use Omnipay\PayPalv2\PayContext;
require_once __DIR__."/index.php";

return (function(string $plan_id,string $locale = "en-US",string $hash,array $data = []){
    $result = [];
    $context = new PayContext($hash);
    $context->locale = $locale;
    $response = pay_gatetway()->createSubscription([])->setData(array_merge_recursive([
      'plan_id' => $plan_id,
      'application_context' => (array)$context,
    ],$data))->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);