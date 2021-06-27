<?php
namespace Omnipay\PayPalv2\Request;

class RestCreateOrderRequest extends AbstractRestRequest
{

    /**
     * Set the plan name
     *
     * @param string $value
     * @return RestCreatePlanRequest provides a fluent interface.
     */
    public function setData($value)
    {
        $this->data = $value;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Get transaction endpoint.
     *
     * Billing plans are created using the /billing-plans resource.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/checkout/orders';
    }
}
