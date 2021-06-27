<?php
namespace Omnipay\PayPalv2\Response;

use Omnipay\PayPal\Message\RestAuthorizeResponse as MessageRestAuthorizeResponse;

/**
 * PayPal REST Authorize Response
 */
class RestAuthorizeResponse extends MessageRestAuthorizeResponse
{

    public function isRedirect()
    {
        return $this->getRedirectUrl() !== null;
    }

    public function getRedirectUrl()
    {
        if (isset($this->data['links']) && is_array($this->data['links'])) {
            foreach ($this->data['links'] as $key => $value) {
                if ($value['rel'] == 'approve') {
                    return $value['href'];
                }
            }
        }

        return null;
    }

    /**
     * Get the URL to complete (execute) the purchase or agreement.
     *
     * The URL is embedded in the links section of the purchase or create
     * subscription request response.
     *
     * @return string
     */
    public function getCompleteUrl()
    {
        if (isset($this->data['links']) && is_array($this->data['links'])) {
            foreach ($this->data['links'] as $key => $value) {
                if ($value['rel'] == 'execute') {
                    return $value['href'];
                }
            }
        }

        return null;
    }

}
