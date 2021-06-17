<?php
require_once __DIR__."/index.php";

return (function(string $productId,string $name,string $description,string $value,string $fee = ""){
    global $_GATEWAY;
    $result = [];
    $data = [
      'product_id' => $productId,
      'name' => $name,
      'description' => $description,
      'status' => 'ACTIVE',
      'billing_cycles' => 
      [
        [
          'frequency' => 
          [
            'interval_unit' => 'MONTH',
            'interval_count' => 1,
          ],
          'tenure_type' => 'REGULAR',
          'sequence' => 1,
          'total_cycles' => 12,
          'pricing_scheme' => 
          [
            'fixed_price' => 
            [
              'value' => $value,
              'currency_code' => 'USD',
            ],
          ],
        ],
      ],
      'taxes' => 
      [
        'percentage' => '10',
        'inclusive' => false,
      ],
    ];
    $data['payment_preferences'] = [
      'auto_bill_outstanding' => true,
      'setup_fee' => 
      [
        'value' => $fee,
        'currency_code' => 'USD',
      ],
      'setup_fee_failure_action' => 'CONTINUE',
      'payment_failure_threshold' => 3,
    ];
    $response = $_GATEWAY->createPlan([])->setData($data)->send();
    $result = $response->getData();
    return release($result);
})(...$_INPUT);