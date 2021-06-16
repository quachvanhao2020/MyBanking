<?php
namespace Omnipay\PayPalv2;

class RestCreateSubscriptionRequest extends AbstractRestRequest
{
    const API_VERSION = 'v1';

    /**
     * Get the agreement name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set the agreement name
     *
     * @param string $value
     * @return RestCreateSubscriptionRequest provides a fluent interface.
     */
    public function setData($value)
    {
        $this->data = $value;
        return $this;
    }

    public function getData()
    {
        //$this->validate('name', 'description', 'startDate', 'payerDetails', 'planId');

        return $this->data;
    }

    /**
     * Get transaction endpoint.
     *
     * Subscriptions are created using the /billing-agreements resource.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/billing/subscriptions';
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new RestAuthorizeResponse($this, $data, $statusCode);
    }
}
