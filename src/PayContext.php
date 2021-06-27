<?php
namespace Omnipay\PayPalv2;

class PayContext{
    public $brand_name = BRAND_NAME;
    public $locale = "en-US";
    public $landing_page;
    public $shipping_preference = 'NO_SHIPPING';
    public $user_action = 'SUBSCRIBE_NOW';
    public $payment_method = [
        'payer_selected' => 'PAYPAL',
        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
    ];
    public $return_url = RETURN_URL;
    public $cancel_url = CANCEL_URL;
    public $stored_payment_source;
    
    public function __construct($hash = "")
    {
        //$this->cancel_url.= "?hash={$hash}";
        $this->return_url.= "?hash={$hash}";
    }
}