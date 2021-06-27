<?php
namespace Omnipay\PayPalv2\Request;

class RestPurchaseRequest extends RestAuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        $data['intent'] = 'CAPTURE';
        return $data;
    }
}
