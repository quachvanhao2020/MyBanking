<?php

namespace Omnipay\PayPalv2;
use Omnipay\PayPal\Message\RestResponse as MessageRestResponse;

/**
 * PayPal REST Response
 */
class RestResponse extends MessageRestResponse
{
    /**
     * Does the response require a redirect?
     *
     * @return boolean
     */
    public function isRedirect()
    {
        return true;
    }
}
