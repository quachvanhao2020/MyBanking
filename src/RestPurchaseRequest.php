<?php
namespace Omnipay\PayPalv2;

class RestPurchaseRequest extends RestAuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['intent'] = 'CAPTURE';
        return $data;
    }
}
