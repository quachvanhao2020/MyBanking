<?php
use Omnipay\PayPalv2\PayContext;
require_once __DIR__."/index.php";

return (function(string $value = "100",string $hash = "",array $data = []){
    $result = [];
    $context = new PayContext($hash);
    unset($context->payment_method);
    $context->user_action = "PAY_NOW";
    $response = pay_gatetway()->createOrder([])->setData(array_merge_recursive([
      "intent" => "CAPTURE",
      "purchase_units" => [
        [
          "amount"=> [
            "currency_code"=> "USD",
            "value"=> $value,
          ]
        ]
      ],
      'application_context' => (array)$context,
    ],$data))->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);